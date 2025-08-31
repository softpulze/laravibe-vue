<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

final class MakeDTOCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:dto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new DTO class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Class';

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/dto.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\\DTOs';
    }

    /**
     * Get the console command arguments.
     *
     * @return array<array{string, string, int, string}>
     */
    protected function getOptions(): array
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the DTO class even if the class already exists'],
        ];
    }

    /**
     * Resolve the fully-qualified path to the stub.
     */
    private function resolveStubPath(string $stub): string
    {
        return base_path($stub);
    }
}
