<?php

declare(strict_types=1);


namespace Osonsms\Exception;

/**
 * @author Shahboz Mirbadiev <shahboz.100@yandex.ru>
 */
interface TransportExceptionInterface extends ExceptionInterface
{
    public function getDebug(): string;

    public function appendDebug(string $debug): void;
}