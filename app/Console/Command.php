<?php

namespace App\Console;

use Illuminate\Console\Command as IlluminateCommand;

class Command extends IlluminateCommand
{
    protected function logCall()
    {
        \Log::notice('[CALL] artisan command', \Helper::getLogContext());
    }

    public function comment($string, $verbosity = null)
    {
        parent::comment($string, $verbosity);
        \Log::debug($string, \Helper::getLogContext());
    }

    public function info($string, $verbosity = null)
    {
        parent::info($string, $verbosity);
        \Log::info($string, \Helper::getLogContext());
    }

    public function warn($string, $verbosity = null)
    {
        parent::warn($string, $verbosity);
        \Log::warning($string, \Helper::getLogContext());
    }

    public function error($string, $verbosity = null)
    {
        parent::error($string, $verbosity);
        \Log::error($string, \Helper::getLogContext());
    }

    public function getInput()
    {
        return $this->input;
    }
}
