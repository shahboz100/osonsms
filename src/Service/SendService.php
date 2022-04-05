<?php

declare(strict_types=1);


namespace Osonsms\Service;


use Psr\Container\ContainerInterface;

class SendService
{
    /** @var ContainerInterface $container */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function send(string $prone, string $msg)
    {
        //TODO: Отправка сообщения
    }
}