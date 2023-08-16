<?php

use GImage\Image;

require 'vendor/autoload.php';

foreach ([16, 32, 64, 96, 128, 180, 256, 300] as $size)
{
    $a = new Image();

    $a->load(__DIR__ . '/logo.png')
        ->resizeToWidth($size)
        ->resizeToHeight($size)
        ->toPNG()->save(__DIR__ . sprintf('/logox%u.png', $size));
}
