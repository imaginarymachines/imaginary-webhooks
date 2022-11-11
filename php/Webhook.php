<?php

namespace ImaginaryMachines\Webhooks;


class Webhook implements WebhookContract {

    protected $id;
    protected $label;
    protected $callback;
    protected $action;
    protected $priority;
    protected $acceptedArgs;
    public function __construct(
        string $id,
        string $label,
        string $action,
        callable $callback,
        int $priority = 10,
        int $acceptedArgs = 1
    ){
        $this->id = $id;
        $this->label = $label;
        $this->action = $action;
        $this->callback = $callback;
        $this->priority = $priority;
        $this->acceptedArgs = $acceptedArgs;


    }
    public function addHook(){
        add_action(
            $this->action,
            $this->callback,
            $this->priority,
            $this->acceptedArgs
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

}
