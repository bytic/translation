<?php

namespace Nip\I18n\Tests;

use Nip\I18n\TranslatableMessage;

/**
 *
 */
class TranslatableMessageTest extends AbstractTest
{
    /**
     * @test
     */
    public function should_convert_to_string()
    {
        $string = new TranslatableMessage('test');
        self::assertSame('test', (string)$string);
    }
}