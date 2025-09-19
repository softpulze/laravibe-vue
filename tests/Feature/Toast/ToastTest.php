<?php

declare(strict_types=1);

use App\Enums\ToastActionType;
use App\Enums\ToastType;
use App\Toast\DTOs\ToastActionPayload;
use App\Toast\DTOs\ToastPayload;
use App\Toast\Exceptions\ToastException;
use App\Toast\Toast;

it('can creates instance of ToastActionPayload and convert to array and json', function () {
    $copyAction = ToastActionPayload::copy('Text To Copy');

    expect($copyAction->toArray())
        ->toBe([
            'type' => 'copy',
            'payload' => 'Text To Copy',
            'label' => null,
        ])
        ->and($copyAction->toJson(JSON_UNESCAPED_SLASHES))->toBeJson()
        ->and(json_decode($copyAction->toJson(JSON_UNESCAPED_SLASHES), true))->toBe([
            'type' => 'copy',
            'payload' => 'Text To Copy',
            'label' => null,
        ]);
});

it('can creates instance of ToastPayload and convert to array and json', function () {
    $toast = new ToastPayload(ToastType::SUCCESS, 'Saved');

    expect($toast->toArray())
        ->toBe([
            'type' => 'success',
            'message' => 'Saved',
        ])
        ->and($toast->toJson(JSON_UNESCAPED_SLASHES))->toBeJson()
        ->and(json_decode($toast->toJson(JSON_UNESCAPED_SLASHES), true))->toBe([
            'type' => 'success',
            'message' => 'Saved',
        ]);
});

it('can create instances of ToastActionPayload using factory methods', function (): void {
    $copyAction = ToastActionPayload::copy('Text To Copy');
    $redirectAction = ToastActionPayload::redirect('https://example.com', 'Example Label');

    expect($copyAction)
        ->type->toBe(ToastActionType::COPY)
        ->payload->toBe('Text To Copy')
        ->label->toBeNull()
        ->and($redirectAction)
        ->type->toBe(ToastActionType::REDIRECT)
        ->payload->toBe('https://example.com')
        ->label->toBe('Example Label');
});

it('can create instances of ToastPayload using factory methods', function () {
    ToastPayload::success('Saved');
    ToastPayload::error('Saved');
    ToastPayload::info('Saved');
    ToastPayload::warning('Saved');

    expect(toast()->pull())->toBeArray()->toHaveCount(4);
});

it('can add toast to session when throw ToastException', function () {
    $message = 'Test error message';
    $exception = new ToastException($message);

    // Create a request
    $request = Request::create('/test');

    // Get the session instance and start it
    $session = app('session');
    $session->start();

    // Set the session store on the request (not the session manager)
    $request->setLaravelSession($session->driver());

    // Call the render method
    $response = $exception->render($request);

    // Verify toast was added to session
    $toasts = toast()->pull();
    expect($toasts)
        ->toBeArray()
        ->toHaveCount(1)
        ->and($toasts[0])
        ->message->toBe($message)
        ->type->toBe('error')
        ->and($response)
        ->toBeInstanceOf(Illuminate\Http\RedirectResponse::class);
});
