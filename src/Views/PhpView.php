<?php

namespace Views;

use Slim\Views\PhpRenderer;

use function NGSOFT\Filesystem\require_file;

class PhpView extends PhpRenderer
{
    public function fetchTemplate(string $template, array $data = []): string
    {
        if ( ! str_ends_with($template, '.php'))
        {
            $template .= '.php';
        }

        return parent::fetchTemplate($template, $data);
    }

    protected function protectedIncludeScope(string $template, array $data): void
    {
        $cwd = getcwd();

        $dir = dirname($template);
        @chdir(is_dir($dir) ? $dir : $this->templatePath);

        require_file($template, $data);
        chdir($cwd);
    }
}
