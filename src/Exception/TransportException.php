<?php

declare(strict_types=1);


namespace Osonsms\Exception;

/**
 * @author Shahboz Mirbadiev <shahboz.100@yandex.ru>
 */
class TransportException extends RuntimeException implements TransportExceptionInterface
{
    private $debug = '';

    public function getDebug(): string
    {
        return $this->debug;
    }

    public function appendDebug(string $debug): void
    {
        $this->debug .= $debug;
    }
}