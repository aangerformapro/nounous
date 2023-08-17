<?php

namespace Views;

use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

abstract class JsonView
{
    protected LoggerInterface $logger;
    protected Request $request;

    protected Response $response;
    protected array $args;

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request  = $request;
        $this->response = $response;
        $this->args     = $args;

        try
        {
            return $this->action();
        } catch (\Throwable $e)
        {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }
    }

    abstract protected function action(): Response;

    /**
     * @return array|object
     */
    protected function getFormData()
    {
        return $this->request->getParsedBody();
    }

    protected function resolveArg(string $name)
    {
        if ( ! isset($this->args[$name]))
        {
            throw new HttpBadRequestException($this->request, "Could not resolve argument `{$name}`.");
        }

        return $this->args[$name];
    }
}
