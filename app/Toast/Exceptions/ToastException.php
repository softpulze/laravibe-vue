<?php

declare(strict_types=1);

namespace App\Toast\Exceptions;

use App\Enums\ToastType;
use App\Toast\DTOs\ToastPayload;
use Exception;
use Illuminate\Contracts\Debug\ShouldntReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

final class ToastException extends Exception implements ShouldntReport
{
    public function __construct(
        string $message = '',
        private readonly ToastType $type = ToastType::ERROR,
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): RedirectResponse
    {
        toast()->append(new ToastPayload($this->type, $this->getMessage()));

        return back();
    }
}
