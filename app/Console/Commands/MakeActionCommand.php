<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

final class MakeActionCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:action';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new action';

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
        return $this->resolveStubPath('/stubs/action.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\\Actions';
    }

    /**
     * Get the console command arguments.
     *
     * @return array<array{string, string, int, string}>
     */
    protected function getOptions(): array
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the action even if the action already exists'],
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
