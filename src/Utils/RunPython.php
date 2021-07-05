<?php

namespace App\Utils;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

$process = new Process(['python', '/PyCode/your_script.py']);
$process->run();

// executes after the command finishes
if (!$process->isSuccessful())
{
throw new ProcessFailedException($process);
}

echo $process->getOutput();
