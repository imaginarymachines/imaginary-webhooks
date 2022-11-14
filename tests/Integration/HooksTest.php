<?php
namespace  ImaginaryMachines\Webhooks\Tests\Integration;

use ImaginaryMachines\Webhooks\Hooks;
use PHPUnit\Framework\TestCase;


class HooksTest extends TestCase {


    /**
     * Test added "init" action
     *
     *  @group hooks
     *
     */
	function testAddInit()
    {

        $this->assertSame(
            10,
            has_action('init', [
                Hooks::class, 'onInit'
            ])
        );
    }

    /**
     * Test added "save_post" action
     *
     *  @group hooks
     *
     */
    function testAddSavePost()
    {

        $this->assertSame(
            10,
            has_action('save_post', [
                Hooks::class, 'onSavePost'
            ])
        );
    }
}
