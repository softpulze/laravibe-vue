<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\DTOs\PageMeta;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Inertia\Response;

final class PasswordResetLinkController extends Controller
{
    /**
     * Show the password reset link request page.
     */
    public function create(Request $request): Response
    {
        return vue('auth/ForgotPassword', [
            'status' => $request->session()->get('status'),
        ], new PageMeta(
            heading: 'Forgot password',
            subheading: 'Enter your email to receive a password reset link',
            title: 'Forgot password'
        ));
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        Password::sendResetLink(
            $request->only('email')
        );

        return back()->with('status', __('A reset link will be sent if the account exists.'));
    }
}
