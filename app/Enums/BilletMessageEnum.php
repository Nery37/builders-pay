<?php

declare(strict_types=1);

namespace App\Enums;

enum BilletMessageEnum: string
{
    case FAILED_TO_CONSULT_API = 'Failed to access Billet API.';
    case INVALID_BILLET_TYPE = 'Only NPC type slips can be calculated.';
    case BILLET_EXPIRED = 'The Billet must be expired.';
    case AUTH_ACCESS_TOKEN_FAILED = 'An error occurred while authenticating the billet api.';
}