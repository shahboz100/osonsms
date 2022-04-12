<?php

declare(strict_types=1);


namespace Osonsms\Service;


use Osonsms\Exception\InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class SendService
{
    /** @var ContainerInterface $container */
    protected $container;
    protected $url = '';
    const METHOD = 'GET';

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->url = $container->get('osonsms.baseUrl');
    }

    /**
     * Метод отправки СМС
     *
     * @param string $phone
     * @param string $msg
     */
    public function send(string $phone, string $msg)
    {
        if ('' === $this->url) {
            throw InvalidArgumentException::invalidUrl();
        }

        try {
            $client = HttpClient::create();
            $response = $client->request(self::METHOD, $this->url, [/*options*/]);

            switch ($response->getStatusCode()) {
                case Response::HTTP_CREATED:
                    //TODO: Обработка ответа 201
                    break;
                case Response::HTTP_BAD_REQUEST:
                    //TODO: Обработка ошибки 400
                    break;
                case Response::HTTP_INTERNAL_SERVER_ERROR:
                    //TODO: Обработка ошибки 500
                    break;
                default:
                    //TODO: Обработка ошибки в иных случаях
            }
        } catch (TransportExceptionInterface $e) {
            //TODO: Обработка ошибки вызова
        }
    }
}