<?php

use Illuminate\Support\Facades\Log;

function logMessage($message, $isTerminal = false)
{
    $message = print_r($message, true);
    if ($isTerminal) {
        (new \Symfony\Component\Console\Output\ConsoleOutput())->writeln($message);
    } else {
        Log::info($message);
    }
}