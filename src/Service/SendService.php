<?php

declare(strict_types=1);


namespace Osonsms\Service;


use Exception;
use Osonsms\Entity\Error;
use Osonsms\Entity\SendResult;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
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
        $this->url = $this->container->getParameter('osonsms.baseUrl');
    }

    /**
     * Метод отправки СМС
     *
     * @param string $phone
     * @param string $msg
     * @param $txnId
     * @return Error|SendResult
     * @throws Exception
     */
    public function send(string $phone, string $msg, $txnId)
    {
        $strHash = $this->getHash($txnId);
        try {
            $client = HttpClient::create();
            $response = $client->request(self::METHOD, $this->url . '/sendsms_v1.php', [
                'query' => [
                    'msg' => $msg,
                    'txn_id' => $txnId,
                    'str_hash' => $strHash,
                    'phone_number' => $phone,
                    'login' => $this->container->getParameter('osonsms.login')
                ]
            ]);

            $result = json_decode($response->getContent());
            return $this->getObject($result);

        } catch (TransportExceptionInterface|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $e) {
            throw new \Exception('Ошибка при отправке сообщения!');
        }
    }

    protected function getObject($request)
    {
        if (isset($request->error)) {
            $error = new Error();
            $error->setCode($request->error->code);
            $error->setErrorType($request->error->error_type);
            $error->setMsg($request->error->msg);
            $error->setTimestamp($request->error->timestamp);

            return $error;
        } elseif (isset($request->status)) {
            $sendResult = new SendResult();
            $sendResult->setStatus($request->status);
            $sendResult->setTimestamp($request->timestamp);
            $sendResult->setTxnId($request->txn_id);
            $sendResult->setMsgId($request->msg_id);
            $sendResult->setSmscMsgId($request->smsc_msg_id);
            $sendResult->setSmscMsgStatus($request->smsc_msg_status);
            $sendResult->setSmscMsgParts($request->smsc_msg_parts);

            return $sendResult;
        } else {
            $error = new Error();
            $error->setCode(-1);
            $error->setErrorType('fatal');
            $error->setMsg('Неизвестная ошибка!');
            $error->setTimestamp((string)time());

            return $error;
        }
    }

    /**
     * Метод проверяет статус ранее отправленного СМС
     * @param $txnId
     * @param $msgId
     */
    public function checkStatus($txnId, $msgId)
    {
        $strHash = $this->getHash($txnId);
        try {
            $client = HttpClient::create();
            $response = $client->request(self::METHOD, $this->url . '/query_sms.php', [
                'query' => [
                    'msg_id' => $msgId,
                    'txn_id' => $txnId,
                    'str_hash' => $strHash,
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
     * Метод возвращает актуальный баланс на счете
     * @param $txnId
     * @return float
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getBalance($txnId): float
    {
        $strHash = $this->getHash($txnId);
        try {
            $client = HttpClient::create();
            $response = $client->request(self::METHOD, $this->url . '/check_balance.php', [
                'query' => [
                    'str_hash' => $strHash,
                    'txn_id' => $txnId,
                    'login' => $this->container->getParameter('osonsms.login')
                ]
            ]);

            switch ($response->getStatusCode()) {
                case Response::HTTP_OK:
                    $result = json_decode($response->getContent());
                    if (isset($result->balance)) {
                        return $result->balance;
                    }
                    break;
                case Response::HTTP_INTERNAL_SERVER_ERROR:
                case Response::HTTP_BAD_REQUEST:
                default:
                    return 0;
            }
        } catch (TransportExceptionInterface $e) {
            return 0;
        }
        return 0;
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