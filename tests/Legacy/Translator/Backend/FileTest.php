<?php

namespace Nip\I18n\Tests\Legacy\Translator\Backend;

use Nip\I18n\Tests\AbstractTest;
use Nip\I18n\Translator;

/**
 * Class FileTest
 * @package Nip\I18n\Tests\Legacy\Translator\Backend
 */
class FileTest extends AbstractTest
{

    public function testUseWithTranslator()
    {
        $translator = new Translator();

        $backend = new \Nip\I18n\Translator\Backend\File();
        $translator->setBackend($backend);

        foreach (['ro', 'en'] as $language) {
            $backend->addLanguage($language, $resource = TEST_FIXTURE_PATH . '/languages/' . $language . '/');
        }

        self::assertSame('Zi', $translator->trans('day', [], null, 'ro'));
        self::assertSame('Day', $translator->trans('day', [], null, 'en'));
    }

}

