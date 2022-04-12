<?php

declare(strict_types=1);


namespace Osonsms\Exception;

/**
 * @author Shahboz Mirbadiev <shahboz.100@yandex.ru>
 */
class InvalidArgumentException extends \InvalidArgumentException implements ExceptionInterface
{
    public static function invalidUrl(): InvalidArgumentException
    {
        return new self('Ошибка! Не найден URL для отправки');
    }
}