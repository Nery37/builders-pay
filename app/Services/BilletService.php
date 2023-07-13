<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\BilletTypeEnum;
use App\Exceptions\BilletExceptions;
use App\Http\Requests\BilletProcessRequest;
use App\Repositories\BilletRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Type\Integer;
use stdClass;

class BilletService extends AppService
{
    protected $baseUrl;
    protected $clientId;
    protected $clientSecret;

    /**
     * @param BilletRepository $repository
     */
    public function __construct(
        BilletRepository $repository,
    ) {
        $this->repository = $repository;
        $this->baseUrl = config('app.builder_base_url');
        $this->clientId = config('app.builder_client_id');
        $this->clientSecret = config('app.builder_client_secret');
    }

    public function process(BilletProcessRequest $request): JsonResponse
    {
        try {
            $billet = $this->getBillet($request->code);
            $this->isBilletValid($billet);
            $calculations = $this->calculateAmounts($billet->amount, $billet->due_date, $request->payment_date);
            $this->saveCalculations(
                $billet->code,
                $billet->amount,
                $billet->due_date,
                $request->payment_date,
                $calculations['interest_amount_calculated'],
                $calculations['fine_amount_calculated'],
                $calculations['amount']
            );

            return response()->json($calculations);
        } catch (BilletExceptions $e) {
            throw $e;
        }
    }

    public function getBillet(string $code): stdClass
    {
        try {
            $token = $this->getAccessToken();
            $response = Http::withHeaders([
                'Authorization' => $token,
                'Accept' => 'application/json'
            ])->post("$this->baseUrl/bill-payments/codes", [
                'code' => $code,
            ]);

            if ($response->failed()) 
            {
                throw BilletExceptions::failedToConsultAPIException();
            }

            return $response->object();
        } catch (BilletExceptions $e) {
            throw $e;
        }
    }

    public function isBilletValid($billet): Void
    {
        try {
            if (!$billet || $billet->type !== BilletTypeEnum::NPC->value) {
                throw BilletExceptions::invalidBilletTypeException();
            }           
            if (!$this->isBilletExpired($billet->due_date)) {
                throw BilletExceptions::billetExpired();
            }
        } catch (BilletExceptions $e) {
            throw $e;
        }
    }

    private function getAccessToken(): String
    {
        try {
            $response = Http::post("$this->baseUrl/auth/tokens", [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]);

            if ($response->failed()) {
                throw BilletExceptions::authAccessTokenFailedException();
            }

            $data = $response->json();
            return $data['token'];
        } catch (BilletExceptions $e) {
            throw $e;
        }
    }

    public function calculateAmounts($billetAmount, $dueDate, $paymentDate): Array
    {
        $daysDelay = $this->calculateDaysDelay($dueDate, $paymentDate);
        $interestAmount = $this->calculateInterestAmount($billetAmount, $daysDelay);
        $fineAmount = $this->calculateFineAmount($billetAmount);
        $totalAmount = $billetAmount + $interestAmount + $fineAmount;

        return [
            'original_amount' => $billetAmount,
            'amount' => $totalAmount,
            'due_date' => $dueDate,
            'payment_date' => $paymentDate,
            'interest_amount_calculated' => $interestAmount,
            'fine_amount_calculated' => $fineAmount,
        ];
    }

    public function saveCalculations($code, $originalAmount, $dueDate, $paymentDate, $interestAmount, $fineAmount, $totalAmount): Void
    {
        $this->repository->create([
            'code' => $code,
            'original_amount' => $originalAmount,
            'due_date' => $dueDate,
            'payment_date' => $paymentDate,
            'interest_amount_calculated' => $interestAmount,
            'fine_amount_calculated' => $fineAmount,
            'amount' => $totalAmount,
        ]);
    }

    private function isBilletExpired($dueDate): Bool
    {
        $dueDateTime = Carbon::parse($dueDate);
        return $dueDateTime->isPast();
    }

    private function calculateDaysDelay($dueDate, $paymentDate): Float
    {
        $dueDateTime = strtotime($dueDate);
        $paymentDateTime = strtotime($paymentDate);

        return floor(($paymentDateTime - $dueDateTime) / (60 * 60 * 24));
    }

    private function calculateInterestAmount($billetAmount, $daysDelay): Integer|Float
    {
        $interestRate = 0.033; // 1% ao dia
        $interestAmount = $billetAmount * $interestRate * $daysDelay / 100;

        return $interestAmount;
    }

    private function calculateFineAmount($billetAmount): Integer|Float
    {
        $fineAmount = $billetAmount * 0.02; // 2%

        return $fineAmount;
    }
}
