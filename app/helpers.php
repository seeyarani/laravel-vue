<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

function logMessage($message, $isTerminal = false)
{
    $message = print_r($message, true);
    if ($isTerminal) {
        (new \Symfony\Component\Console\Output\ConsoleOutput())->writeln($message);
    } else {
        Log::info($message);
    }
}

function getUid()
{
    return (string) Str::uuid();
}