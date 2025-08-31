<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\DTOs\PageMeta;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;

final class ProfileController extends Controller
{
    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        return vue('settings/Profile', [
            // @phpstan-ignore-next-line instanceof.alwaysTrue
            'mustVerifyEmail' => authUser() instanceof MustVerifyEmail,
            'status' => $request->session()->get('status'),
        ], new PageMeta(
            title: 'Profile settings',
        ));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $authUser = authUser();
        $authUser->fill($request->validated());

        if ($authUser->isDirty('email')) {
            $authUser->email_verified_at = null;
        }

        $authUser->save();

        return to_route('profile.edit');
    }

    /**
     * Delete the user's profile.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = authUser();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
