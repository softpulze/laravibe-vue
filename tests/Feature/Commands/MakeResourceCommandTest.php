<?php

declare(strict_types=1);

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

use function Pest\Laravel\artisan;

it('generates a resource class using the application stub', function (): void {
    $filesystem = app(Filesystem::class);
    $class = 'TmpResource' . Str::random(8);
    $path = app_path('Http/Resources/' . $class . '.php');

    try {
        artisan('make:resource', ['name' => $class])
            ->expectsOutputToContain('created')
            ->assertSuccessful();

        $contents = rescue(fn () => $filesystem->get($path), fn () => '');

        expect($filesystem->exists($path))->toBeTrue()
            ->and($contents)
            ->toContain('declare(strict_types=1);')
            ->toContain('namespace App\\Http\\Resources;')
            ->toContain('final class ' . $class . ' extends AppResource')
            ->toContain('public function toArray(Request $request): array')
            ->toContain('$this->id()')
            ->toContain('...$this->timestamps()');
    } finally {
        removeResource($filesystem, $path);
    }
});

it('generates a resource collection class using the application stub', function (): void {
    $filesystem = app(Filesystem::class);
    $class = 'TmpCollection' . Str::random(8);
    $path = app_path('Http/Resources/' . $class . '.php');

    try {
        artisan('make:resource', ['name' => $class, '--collection' => true])
            ->expectsOutputToContain('created')
            ->assertSuccessful();

        $contents = rescue(fn () => $filesystem->get($path), fn () => '');

        expect($filesystem->exists($path))->toBeTrue()
            ->and($contents)
            ->toContain('namespace App\\Http\\Resources;')
            ->toContain('final class ' . $class . ' extends AppResourceCollection')
            ->toContain('public function toArray(Request $request): array')
            ->toContain('return parent::toArray($request);');
    } finally {
        removeResource($filesystem, $path);
    }
});

function removeResource(Filesystem $filesystem, string $path): void
{
    if ($filesystem->exists($path)) {
        $filesystem->delete($path);
    }
}
