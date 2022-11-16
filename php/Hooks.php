<?php

namespace ImaginaryMachines\Webhooks;

use ImaginaryMachines\Webhooks\Metaboxes\EventName;
use ImaginaryMachines\Webhooks\Metaboxes\Secret;
use ImaginaryMachines\Webhooks\Metaboxes\Url;

class Hooks {

    /**
 * @return Plugin
 */
    protected static function getPlugin(){
        return imwm_webhook();
    }
    /**
     * Add actions for saved events
     *
     * @return void
     */
    public static function onInit(){
        $added = [];
        foreach (static::getPlugin()->getSaved() as $saved) {
            if (! isset($saved[EventName::KEY])) {
                continue;
            }
            $eventId = $saved[EventName::KEY];
            if ($eventId && static::getPlugin()->getRegisteredEvent($eventId)) {
                $event = static::getPlugin()->getRegisteredEvent($eventId);
                $webhook = new Webhook(
                    $saved['ID'],
                    $saved[Url::KEY],
                    $saved[Secret::KEY]
                );
                $event->addHook($webhook);
                $added[] = $webhook;
            }
        }
        do_action('imwm_webhooks_added', $added);
    }

    /**
     * When saving webhooks, re-prime cache
     *
     * @uses "save_post"
     *
     * @param int $post_ID
     * @param \WP_Post $post_ID
     * @param bool $update
     *
     * @return void
     *
     */
    public static function onSavePost(int $post_ID, \WP_Post $post, bool $update){
        if (Plugin::CPT_NAME === $post->post_type) {
            static::getPlugin()->getSaved();
        }
    }

}
