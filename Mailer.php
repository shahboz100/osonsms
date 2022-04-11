<?php

namespace Osonsms;

interface Mailer
{

    public function send(string $phone, string $message);
}