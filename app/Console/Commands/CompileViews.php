<?php

namespace App\Console\Commands;

use App\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;

class CompileViews extends Command
{
    protected $signature = 'view:compile';
    protected $description = 'Command description';

    public function handle()
    {
        $this->logCall();

        $this->info('start view compiler');
        $targetDir = storage_path('framework/views/php');
        if (! file_exists($targetDir)) {
            $this->createDirectory($targetDir);
            $this->comment('created directory '.$targetDir);
        }
        $path = base_path('resources/views');
        $fs = new Filesystem($path);
        $files = $fs->allFiles(realpath($path));
        $compiler = new BladeCompiler($fs, $targetDir);
        foreach ($files as $file) {
            $filePath = $file->getRealPath();
            $this->comment('compile view: '.$filePath);
            $compiler->setPath($filePath);
            $contents = $compiler->compileString($fs->get($filePath));
            $compiledPath = $compiler->getCompiledPath($compiler->getPath());
            $fs->put($compiledPath.'.php', $contents);
        }
    }

    protected function createDirectory($path)
    {
        if (! mkdir($path)) {
            throw new \RuntimeException(sprintf('Can\'t create the directory: %s', $path));
        }
    }
}
