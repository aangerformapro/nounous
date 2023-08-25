<?php

declare(strict_types=1);

namespace App\Application;

use NGSOFT\DataStructure\SimpleObject;
use Roots\WPConfig\Config;

use function NGSOFT\Filesystem\require_file;

class Settings extends SimpleObject
{
    public static function loadSettings(
        string $root,
        array $search = ['app', 'src'],
        string $filename = 'settings.php'
    ): static {
        static $instance;

        if (is_null($instance))
        {
            $root ??= Config::get('ROOT_PATH');

            $data     = [];

            foreach ($search as $dir)
            {
                if (is_array(
                    $arr = require_file($root . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $filename)
                ))
                {
                    $data = array_replace($data, $arr);
                }
            }
            $instance = new static($data, true);
            $instance->lock();
        }

        return $instance;
    }
}
