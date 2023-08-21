<?php

namespace Actions;

use App\Application\Renderers\JsonRenderer;
use App\Application\Renderers\PhpRenderer;
use App\Application\Renderers\RedirectRenderer;

abstract class BaseAction
{
    public function __construct(
        protected PhpRenderer $phpRenderer,
        protected JsonRenderer $jsonRenderer,
        protected RedirectRenderer $redirectRenderer
    ) {
    }

    public function getPhpRenderer(): PhpRenderer
    {
        return $this->phpRenderer;
    }

    public function getJsonRenderer(): JsonRenderer
    {
        return $this->jsonRenderer;
    }

    public function getRedirectRenderer(): RedirectRenderer
    {
        return $this->redirectRenderer;
    }
}
