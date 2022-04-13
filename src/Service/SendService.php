<?php

declare(strict_types=1);


namespace Osonsms\Service;


use Psr\Container\ContainerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class SendService
{
    /** @var ContainerInterface $container */
    protected $container;
    protected $url = '';
    protected $helper = null;
    const METHOD = 'GET';

    public function __construct(ContainerInterface $container, HelperService $helper)
    {
        $this->container = $container;
        $this->url = $this->container->getParameter('osonsms.baseUrl');
        $this->helper = $helper;
    }

    /**
     * Метод отправки СМС
     *
     * @param string $phone
     * @param string $msg
     */
    public function send(string $phone, string $msg)
    {
        $txnId = $this->helper->generateUuid4();
        $strHash = $this->helper->getHash($txnId);
        try {
            $client = HttpClient::create();
            $response = $client->request(self::METHOD, $this->url, [
                'query' => [
                    'str_hash' => $strHash,
                    'txn_id' => $txnId,
                    'login' => $this->container->getParameter('osonsms.login')
                ]
            ]);

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

    /**
     * Метод проверяет статус ранее отправленного СМС
     * @param $txnId
     */
    public function checkStatus($txnId)
    {
        //TODO: Проверка статуса смс
    }

    /**
     * Метод возвращает актуальный баланс на счете
     */
    public function getBalance()
    {
        $txnId = $this->helper->generateUuid4();
        $strHash = $this->helper->getHash($txnId);
        try {
            $client = HttpClient::create();
            $response = $client->request(self::METHOD, $this->url, [
                'query' => [
                    'str_hash' => $strHash,
                    'txn_id' => $txnId,
                    'login' => $this->container->getParameter('osonsms.login')
                ]
            ]);

            switch ($response->getStatusCode()) {
                case Response::HTTP_CREATED:
                    $result = json_decode($response->getContent());
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