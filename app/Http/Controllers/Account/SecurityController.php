<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account;

use App\DTOs\PageMeta;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Response;

final class SecurityController extends Controller
{
    public function edit(): Response
    {
        return vue('account/Security', metaProps: new PageMeta(title: 'Security'));
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        /** @var array{current_password: string, password: string} $validated */
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        authUser()->update([
            'password' => Hash::make($validated['password']),
        ]);

        toastSuccess('Password updated successfully.');

        return back();
    }
}
