<?php

namespace ImaginaryMachines\Webhooks;


/**
 * A WebhookEvent is a possible action/ data getter we can use for a webhook
 */
interface WebhookEventContract {

    /**
     * Get the ID of the event
     *
     * @return string
     */
    public function getId();

    /**
     * Get the label for the event
     *
     * @return string
     */
    public function getLabel();





}
