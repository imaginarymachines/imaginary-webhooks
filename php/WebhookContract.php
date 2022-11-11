<?php

namespace ImaginaryMachines\Webhooks;

interface WebhookContract {

    public function getId();
    public function getSecret();
    public function getUrl();

}
