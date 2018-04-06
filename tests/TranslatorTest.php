<?php

namespace Nip\I18n\Tests;

use Nip\I18n\Catalogue\MessageCatalogue;
use Nip\I18n\Loader\ArrayLoader;
use Nip\I18n\Translator;

class TranslatorTest extends AbstractTest
{

    public function testSetGetLocale()
    {
        $translator = new Translator('en');
        $this->assertEquals('en', $translator->getLocale());

        $translator->setLocale('fr');
        $this->assertEquals('fr', $translator->getLocale());
    }

    public function testGetCatalogue()
    {
        $translator = new Translator('en');
        $this->assertEquals(new MessageCatalogue('en'), $translator->getCatalogue());

        $translator->setLocale('fr');
        $this->assertEquals(new MessageCatalogue('fr'), $translator->getCatalogue('fr'));
    }

    public function testTrans()
    {
        $translator = new Translator('en');

        $translator->addLoader('array', new ArrayLoader());
        $translator->addResource('array', ['foo' => 'foofoo'], 'en');

        $this->assertEquals('foofoo', $translator->trans('foo'));
    }

    public function testAddResourceAfterTrans()
    {
        $translator = new Translator('fr');
        $translator->addLoader('array', new ArrayLoader());

        $translator->setFallbackLocales(['en']);

        $translator->addResource('array', ['foo' => 'foofoo'], 'en');
        $this->assertEquals('foofoo', $translator->trans('foo'));

        $translator->addResource('array', array('bar' => 'foobar'), 'en');
        $this->assertEquals('foobar', $translator->trans('bar'));
        $this->assertEquals('foofoo', $translator->trans('foo'));
    }
}