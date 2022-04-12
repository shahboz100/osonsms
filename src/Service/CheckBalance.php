<?php

declare(strict_types=1);


namespace Osonsms\Service;


use Psr\Container\ContainerInterface;

class CheckBalance
{
    /** @var ContainerInterface $container */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function check()
    {
        //TODO: Check balance
    }
}