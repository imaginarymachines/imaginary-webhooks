<?php

namespace ImaginaryMachines\Webhooks;

class Webhook implements WebhookContract {

    protected $id;
    protected $secret;
    protected $url;

    public function __construct(
        string $id,
        string $url,
        string $secret = null
    ){
        $this->id = $id;
        $this->url = $url;
        $this->secret = $secret;
    }

    /**
     * @return string
     *
     */
    public function getId(){
        return $this->id;
    }



    /**
     * @return string|null
     */
    public function getSecret(){
        return $this->secret;
    }

     /**
     * @return string
     *
     */
    public function getUrl(){
        return $this->url;
    }

}
