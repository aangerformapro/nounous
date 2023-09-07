<?php

declare(strict_types=1);

namespace App\Application\Actions;

use App\Application\Renderers\JsonRenderer;
use App\Application\Renderers\PhpRenderer;
use App\Application\Renderers\RedirectRenderer;
use App\Domain\DomainException\DomainRecordNotFoundException;
use Models\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

abstract class Action
{
    protected Request $request;

    protected Response $response;

    protected array $args;


    public function __construct(
        protected LoggerInterface $logger,
        protected PhpRenderer $phpRenderer,
        protected JsonRenderer $jsonRenderer,
        protected RedirectRenderer $redirectRenderer
    ) {

    }

    /**
     * @throws HttpNotFoundException
     * @throws HttpBadRequestException
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request  = $request;
        $this->response = $response;
        $this->args     = $args;
        $this->initialize();

        try
        {
            return $this->action();
        } catch (DomainRecordNotFoundException $e)
        {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }
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

    public function render(string $template, array $data = []): ResponseInterface
    {
        return $this->phpRenderer->render($this->response, $template, $data);
    }

    public function redirectFor(string $routeName, array $data = [], array $query = []): ResponseInterface
    {
        return $this->redirectRenderer
            ->redirectFor($this->response, $routeName, $data, $query)
        ;
    }

    public function redirect(string $path, array $query = []): ResponseInterface
    {
        return $this->redirectRenderer
            ->redirect($this->response, $path, $query)
        ;
    }

    protected function initialize(): void
    {
    }

    /**
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    abstract protected function action(): Response;

    /**
     * @return array|object
     */
    protected function getFormData()
    {
        return $this->request->getAttribute('postdata') ?? [];
    }

    /**
     * @return mixed
     *
     * @throws HttpBadRequestException
     */
    protected function resolveArg(string $name)
    {
        if ( ! isset($this->args[$name]))
        {
            throw new HttpBadRequestException($this->request, "Could not resolve argument `{$name}`.");
        }

        return $this->args[$name];
    }

    protected function tryResolveArg(string $name)
    {
        try
        {
            return $this->resolveArg($name);
        } catch (HttpBadRequestException)
        {
        }

        return null;
    }

    protected function getUser(): ?User
    {
        return $this->request->getAttribute('user');
    }

    /**
     * @param null|array|object $data
     */
    protected function respondWithData($data = null, int $statusCode = 200): Response
    {
        $payload = new ActionPayload($statusCode, $data);

        return $this->respond($payload);
    }

    protected function respond(ActionPayload $payload): Response
    {
        $json = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $this->response->getBody()->write($json);

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($payload->getStatusCode())
        ;
    }
}
