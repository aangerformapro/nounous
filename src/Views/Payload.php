<?php

namespace Views;

class Payload implements \JsonSerializable
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
