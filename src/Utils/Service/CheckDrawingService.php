<?php

namespace App\Utils\Service;

use App\Entity\DrawingCheckResult;

class CheckDrawingService
{
    public function checkDrawing(DrawingCheckResult $result, String $referenceImg,String $learnersImg): MusicMetrics {
        $command = "/bin/bash -c 'python3 /var/www/diplom/python/main.py " . $referenceImg . $learnersImg . "'";
        $output = null;
        $status = null;
        exec($command, $output, $status);
        return $result;
    }
}