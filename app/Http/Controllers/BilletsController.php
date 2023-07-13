<?php

namespace App\Http\Controllers;

use App\Http\Requests\BilletProcessRequest;
use Illuminate\Http\Request;
use App\Services\AppService;
use App\Services\BilletService;
use Illuminate\Http\JsonResponse;

/**
 * Class BilletsController.
 *
 * @package namespace App\Http\Controllers;
 */
class BilletsController extends Controller
{
    protected AppService $service;

    /**
     * BilletsController constructor.
     *
     * @param BilletService $service
     */
    public function __construct(BilletService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws ValidatorException
     */
    public function process(BilletProcessRequest $request): JsonResponse
    {
        try {
            return $this->service->process($request);
        } catch (\Exception $exception) {
            return $this->undefinedErrorResponse($exception->getMessage(), $exception->getCode());
        }
    }
}

