<?php

declare(strict_types=1);


namespace Osonsms\Exception;


use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @author Shahboz Mirbadiev <shahboz.100@yandex.ru>
 */
class HttpTransportException extends TransportException
{
    private $response;

    public function __construct(string $message = null, ResponseInterface $response, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->response = $response;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}