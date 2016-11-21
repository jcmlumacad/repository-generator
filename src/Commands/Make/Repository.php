<?php

namespace Conds18\Repository\Commands\Make;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class Repository extends GeneratorCommand
{
    private $eloquent;
    private $folder;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repositories';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->makeRepository();
        $this->makeModel();
        $this->makeEloquentRepository();
    }

    private function makeRepository()
    {
        $type = 'Repository';
        $this->eloquent = 'Eloquent';
        $this->folder = $this->getNameInput();

        $filename = $this->getNameInput() . $type;

        $eloquentFilename = $this->eloquent . $this->getNameInput() . $type;

        $name = $this->parseName($this->type . '\\' . $filename);

        $path = $this->getPath($name);

        if ($this->alreadyExists($name)) {
            $this->error($filename . ' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->info($filename . ' created successfully.');

        $this->createEloquent($eloquentFilename, $filename);
    }

    private function $this->makeModel()
    {

    }

    private function $this->makeEloquentRepository()
    {
        
    }

    private function createEloquent($filename, $repository)
    {
        $name = $this->parseName($this->type . '\\' .  $this->folder . '\\' . $filename);

        $path = $this->getPath($name);

        if ($this->alreadyExists($name)) {
            $this->error($filename . ' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $buildClass = $this->buildEloquentClass($name, $repository);
        $buildClass = $this->replaceRepository($buildClass, $repository);
        $buildClass = $this->replaceModel($buildClass, $this->getNameInput());
        $buildClass = $this->replaceVarModel($buildClass, $this->getNameInput());

        $this->files->put($path, $buildClass);

        $this->info($filename . ' created successfully.');

        $this->call('make:model', ['name' => $this->getNameInput()]);
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildEloquentClass($name, $repository)
    {
        $stub = $this->files->get($this->getEloquentStub());

        return $this->replaceNamespace($stub, $name)
                    ->replaceClass($stub, $name);
    }

    protected function replaceRepository($stub, $name)
    {
        $repository = str_replace($this->getNamespace($name).'\\', '', $name);
        
        return str_replace('DummyRepository', $repository, $stub);
    }

    protected function replaceModel(&$stub, $name)
    {
        $model = str_replace($this->getNamespace($name).'\\', '', $name);
        
        return str_replace('DummyModel', $model, $stub);
    }

    protected function replaceVarModel(&$stub, $name)
    {
        $model = str_replace($this->getNamespace($name).'\\', '', $name);
        
        return str_replace('dummyModel', lcfirst($model), $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stub/Repository.stub';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getEloquentStub()
    {
        return __DIR__ . '/stub/EloquentDummyRepository.stub';
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return $this->argument('name');
    }   

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the class'],
        ];
    }
}
