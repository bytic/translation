<?php

namespace Nip\I18n\Tests;

use Nip\I18n\Catalogue\MessageCatalogue;
use Nip\I18n\Translator;

class TranslatorTest extends AbstractTest
{

    public function testGetCatalogue()
    {
        $translator = new Translator();
        $translator->setLocale('en');
        $this->assertEquals(new MessageCatalogue('en'), $translator->getCatalogue());

        $translator->setLocale('fr');
        $this->assertEquals(new MessageCatalogue('fr'), $translator->getCatalogue('fr'));
    }
}