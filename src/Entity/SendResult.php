<?php

namespace Osonsms\Entity;

class SendResult
{
    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $txnId;

    /**
     * @var string
     */
    private $msgId;

    /**
     * @var string
     */
    private $smscMsgId;

    /**
     * @var string
     */
    private $smscMsgStatus;

    /**
     * @var integer
     */
    private $smscMsgParts;

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    /**
     * @param string $timestamp
     */
    public function setTimestamp(string $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return int
     */
    public function getTxnId(): int
    {
        return $this->txnId;
    }

    /**
     * @param int $txnId
     */
    public function setTxnId(int $txnId): void
    {
        $this->txnId = $txnId;
    }

    /**
     * @return string
     */
    public function getMsgId(): string
    {
        return $this->msgId;
    }

    /**
     * @param string $msgId
     */
    public function setMsgId(string $msgId): void
    {
        $this->msgId = $msgId;
    }

    /**
     * @return string
     */
    public function getSmscMsgId(): string
    {
        return $this->smscMsgId;
    }

    /**
     * @param string $smscMsgId
     */
    public function setSmscMsgId(string $smscMsgId): void
    {
        $this->smscMsgId = $smscMsgId;
    }

    /**
     * @return string
     */
    public function getSmscMsgStatus(): string
    {
        return $this->smscMsgStatus;
    }

    /**
     * @param string $smscMsgStatus
     */
    public function setSmscMsgStatus(string $smscMsgStatus): void
    {
        $this->smscMsgStatus = $smscMsgStatus;
    }

    /**
     * @return int
     */
    public function getSmscMsgParts(): int
    {
        return $this->smscMsgParts;
    }

    /**
     * @param int $smscMsgParts
     */
    public function setSmscMsgParts(int $smscMsgParts): void
    {
        $this->smscMsgParts = $smscMsgParts;
    }
}