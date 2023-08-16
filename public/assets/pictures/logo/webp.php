<?php

declare(strict_types=1);

$dir               = __DIR__;

$toCompress        = [];
$toDecompress      = [];
$files             = [];
$json              = [];

const WEBP         = '.webp';
const NOTWEBP      = ['.jpg', '.png'];
const COMPRESS_EXT = '.png';

foreach (scandir($dir) ?: [] as $file)
{
    if (str_starts_with($file, '.'))
    {
        continue;
    }

    $name = pathinfo(path: $file)['filename'];
    $ext  = '.' . (pathinfo(path: $file)['extension'] ?? '');

    if (WEBP === $ext)
    {
        $files[$name] ??= [];
        $files[$name]['src'] = $file;
    } elseif (in_array($ext, NOTWEBP))
    {
        $files[$name] ??= [];
        $files[$name]['alt'] = $file;
    }
}

foreach ($files as $name => &$item)
{
    set_time_limit(120);

    if (isset($item['src']) && ! isset($item['alt']))
    {
        $item['alt'] = $name . COMPRESS_EXT;
        passthru(
            sprintf(
                'cwebp -q 100 -lossless -exact "%s" -o "%s"',
                $dir . DIRECTORY_SEPARATOR . $item['src'],
                $dir . DIRECTORY_SEPARATOR . $item['alt']
            )
        );
    } elseif (isset($item['alt']) && ! isset($item['src']))
    {
        $item['src'] = $name . WEBP;
        passthru(
            sprintf(
                'cwebp -q 100 -lossless -exact "%s" -o "%s"',
                $dir . DIRECTORY_SEPARATOR . $item['alt'],
                $dir . DIRECTORY_SEPARATOR . $item['src']
            )
        );
    }
}

file_put_contents(
    $dir . DIRECTORY_SEPARATOR . 'pictures.json',
    json_encode($files, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
);
