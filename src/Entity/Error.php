<?php

namespace Osonsms\Entity;

class Error
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $errorType;

    /**
     * @var string
     */
    private $msg;

    /**
     * @var string
     */
    private $timestamp;

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getErrorType(): string
    {
        return $this->errorType;
    }

    /**
     * @param string $errorType
     */
    public function setErrorType(string $errorType): void
    {
        $this->errorType = $errorType;
    }

    /**
     * @return string
     */
    public function getMsg(): string
    {
        return $this->msg;
    }

    /**
     * @param string $msg
     */
    public function setMsg(string $msg): void
    {
        $this->msg = $msg;
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
}