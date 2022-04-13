<?php

declare(strict_types=1);


namespace Osonsms\Service;


use Psr\Container\ContainerInterface;

class HelperService
{
    /** @var ContainerInterface $container */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Метод возвращает хэш для обращения в сервис osonsms.com
     *
     * @param $txnId
     * @return string
     */
    public function getHash($txnId): string
    {
        $data = implode(';', [
            $txnId,
            $this->container->getParameter('osonsms.login'),
            $this->container->getParameter('osonsms.hash')
        ]);

        return hash('sha256', $data);
    }

    /**
     * Возвращает сгенерированный UUID версии 4
     * @return string
     */
    public function generateUuid4(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}