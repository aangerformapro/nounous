<?php

declare(strict_types=1);

namespace App\Application\Renderers;

use Psr\Http\Message\ResponseInterface;

use function NGSOFT\Filesystem\require_file;

class PhpRenderer
{
    protected string $templatePath;
    protected string $layout;

    public function __construct(
        string $templatePath,
        string $layout = '',
        protected array $attributes = []
    ) {
        $this->setTemplatePath($templatePath);
        $this->setLayout($layout);
    }

    public function render(ResponseInterface $response, string $template, array $data = []): ResponseInterface
    {
        $output = $this->fetch($template, $data, true);
        $response->getBody()->write($output);
        return $response;
    }

    public function fetchTemplate(string $template, array $data = []): string
    {
        if ( ! str_ends_with($template, '.php'))
        {
            $template .= '.php';
        }

        if (isset($data['template']))
        {
            throw new \InvalidArgumentException('Duplicate template key found');
        }

        if ( ! $this->templateExists($template))
        {
            throw new PhpTemplateNotFoundException('View cannot render "' . $template
                                                   . '" because the template does not exist');
        }
        $data = array_merge($this->attributes, $data);

        try
        {
            ob_start();
            $this->protectedIncludeScope($this->templatePath . $template, $data);
            $output = ob_get_clean();
        } catch (\Throwable $e)
        {
            ob_end_clean();
            throw $e;
        }

        return $output;
    }

    public function fetch(string $template, array $data = [], bool $useLayout = false): string
    {
        $output = $this->fetchTemplate($template, $data);

        if ($this->layout && $useLayout)
        {
            $data['content'] = $output;
            $output          = $this->fetchTemplate($this->layout, $data);
        }

        return $output;
    }

    public function getLayout(): string
    {
        return $this->layout;
    }

    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    public function templateExists(string $template): bool
    {
        $path = $this->templatePath . $template;
        return is_file($path) && is_readable($path);
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    public function addAttribute(string $key, $value): void
    {
        $this->attributes[$key] = $value;
    }

    public function getAttribute(string $key)
    {
        if ( ! isset($this->attributes[$key]))
        {
            return false;
        }

        return $this->attributes[$key];
    }

    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }

    public function setTemplatePath(string $templatePath): void
    {
        $this->templatePath = rtrim($templatePath, '/\\') . '/';
    }

    protected function protectedIncludeScope(string $template, array $data): void
    {
        $cwd = getcwd();

        $dir = dirname($template);
        @chdir(is_dir($dir) ? $dir : $this->templatePath);

        require_file($template, $data);
        @chdir($cwd);
    }
}
