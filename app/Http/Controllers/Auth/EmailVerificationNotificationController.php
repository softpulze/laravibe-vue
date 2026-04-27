<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;

final class EmailVerificationNotificationController
{
    /**
     * Send a new email verification notification.
     */
    public function store(): RedirectResponse
    {
        if (authUser()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }
        authUser()->sendEmailVerificationNotification();
        toastSuccess('A new verification link has been sent to your email address.');

        return back();
    }
}
