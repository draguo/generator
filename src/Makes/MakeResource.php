<?php

namespace Draguo\Generator\Makes;


use Illuminate\Filesystem\Filesystem;
use Draguo\Generator\Commands\ScaffoldMakeCommand;

class MakeResource
{
    use MakerTrait;

    function __construct(ScaffoldMakeCommand $scaffoldCommand, Filesystem $files)
    {
        $this->files = $files;
        $this->scaffoldCommandObj = $scaffoldCommand;

        $this->start();
    }

    private function start()
    {

        $name = $this->scaffoldCommandObj->getObjName('Name');
        $path = $this->getPath($name."Resource", 'resource');
        if ($this->files->exists($path))
        {
            return $this->scaffoldCommandObj->comment("x $path");
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->compileStub('resource'));

        $this->scaffoldCommandObj->info('+ ' . $path);
    }

    protected function compileStub($filename)
    {
        $stub = $this->files->get(substr(__DIR__,0, -5) . 'Stubs/'.$filename.'.stub');

        $this->buildStub($this->scaffoldCommandObj->getMeta(), $stub);

        return $stub;
    }
}