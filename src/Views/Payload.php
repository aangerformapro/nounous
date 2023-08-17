<?php

namespace Views;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

class Payload implements \JsonSerializable, \Stringable
{
    private int $statusCode;

    /**
     * @var null|array|object
     */
    private $data;

    private ?ActionError $error;

    public function __construct(
        int $statusCode = 200,
        $data = null,
        ?ActionError $error = null
    ) {
        $this->statusCode = $statusCode;
        $this->data       = $data;
        $this->error      = $error;
    }

    #[\ReturnTypeWillChange]
    public function __toString(): string
    {
        return json_encode($this, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return null|array|object
     */
    public function getData()
    {
        return $this->data;
    }

    public function render(ResponseFactoryInterface|ResponseInterface $response): ResponseInterface
    {
        if ($response instanceof ResponseFactoryInterface)
        {
            $response = $response->createResponse($this->statusCode);
        } else
        {
            $response = $response->withStatus($this->statusCode);
        }

        $response->getBody()->write((string) $this);
        return $response;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        $payload = [
            'statusCode' => $this->statusCode,
        ];

        if (null !== $this->data)
        {
            $payload['data'] = $this->data;
        } elseif (null !== $this->error)
        {
            $payload['error'] = $this->error;
        }

        return $payload;
    }
}
