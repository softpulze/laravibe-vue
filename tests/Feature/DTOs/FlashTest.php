<?php

declare(strict_types=1);

use App\DTOs\Flash;
use App\DTOs\FlashAction;
use App\Enums\FlashActionType;
use App\Enums\FlashType;

it('can creates instance of FlashAction and convert to array and json', function () {
    $copyAction = FlashAction::copy('Text To Copy');

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

it('can creates instance of Flash and convert to array and json', function () {
    $flash = new Flash(FlashType::SUCCESS, 'Saved');

    expect($flash->toArray())
        ->toBe([
            'type' => 'success',
            'message' => 'Saved',
        ])
        ->and($flash->toJson(JSON_UNESCAPED_SLASHES))->toBeJson()
        ->and(json_decode($flash->toJson(JSON_UNESCAPED_SLASHES), true))->toBe([
            'type' => 'success',
            'message' => 'Saved',
        ]);
});

it('can create instances using factory methods', function (): void {
    $copyAction = FlashAction::copy('Text To Copy');
    $redirectAction = FlashAction::redirect('https://example.com', 'Example Label');

    expect($copyAction)
        ->type->toBe(FlashActionType::COPY)
        ->payload->toBe('Text To Copy')
        ->label->toBeNull()
        ->and($redirectAction)
        ->type->toBe(FlashActionType::REDIRECT)
        ->payload->toBe('https://example.com')
        ->label->toBe('Example Label');
});
