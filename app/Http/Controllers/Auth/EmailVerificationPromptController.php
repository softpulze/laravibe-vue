<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Data\PageMeta;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

final class EmailVerificationPromptController extends Controller
{
    /**
     * Show the email verification prompt page.
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('dashboard', absolute: false))
                    : vue('auth/VerifyEmail', [
                        'status' => $request->session()->get('status'),
                    ], new PageMeta(
                        heading: 'Verify email',
                        subheading: 'Please verify your email address by clicking on the link we just emailed to you.',
                        title: 'Email verification'
                    ));
    }
}
