<?php
namespace App\Console;

use Illuminate\Console\Command as IlluminateCommand;

class Command extends IlluminateCommand
{
    protected function logCall()
    {
        \Log::notice('[CALL] artisan command', \Helper::getLogContext());
    }

    public function comment($string, $verbosity = NULL)
    {
        parent::comment($string, $verbosity);
        \Log::debug($string, \Helper::getLogContext());
    }

    public function info($string, $verbosity = NULL)
    {
        parent::info($string, $verbosity);
        \Log::info($string, \Helper::getLogContext());
    }

    public function warn($string, $verbosity = NULL)
    {
        parent::warn($string, $verbosity);
        \Log::warning($string, \Helper::getLogContext());
    }

    public function error($string, $verbosity = NULL)
    {
        parent::error($string, $verbosity);
        \Log::error($string, \Helper::getLogContext());
    }

    public function getInput()
    {
        return $this->input;
    }
}
