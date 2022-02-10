<?php

namespace Nip\I18n\Tests;

use Nip\I18n\Loader\ArrayLoader;
use Nip\I18n\Message\Catalogue\MessageCatalogue;
use Nip\I18n\Translator;

/**
 * Class TranslatorTest
 * @package Nip\I18n\Tests
 */
class TranslatorTest extends AbstractTest
{
    public function testSetGetLocale()
    {
        $translator = new Translator('en');
        static::assertEquals('en', $translator->getLocale());

        $translator->setLocale('fr');
        static::assertEquals('fr', $translator->getLocale());
    }

    public function testGetCatalogue()
    {
        $translator = new Translator('en');
        static::assertEquals(new MessageCatalogue('en'), $translator->getCatalogue());

        $translator->setLocale('fr');
        static::assertEquals(new MessageCatalogue('fr'), $translator->getCatalogue('fr'));
    }

    /**
     * @param $expected
     * @param $id
     * @param $translation
     * @param $parameters
     * @param $locale
     * @param $domain
     * @dataProvider getTransDataProvider
     */
    public function testTrans($expected, $id, $translation, $parameters, $locale, $domain)
    {
        $translator = new Translator($locale);
        $translator->addLoader('array', new ArrayLoader());
        $translator->addResource('array', [(string)$id => $translation], $locale, $domain);

        static::assertEquals($expected, $translator->trans($id, $parameters, $domain, $locale));
        static::assertEquals($expected, $translator->trans($id, $parameters, $domain, ''));
        static::assertEquals($expected, $translator->trans($id, $parameters, $domain, false));
    }

    /**
     * @param $expected
     * @param $id
     * @param $translation
     * @param $parameters
     * @param $locale
     * @param $domain
     * @dataProvider getTransDataProvider
     */
    public function testTranslate($expected, $id, $translation, $parameters, $locale, $domain)
    {
        $translator = new Translator('en');
        $translator->addLoader('array', new ArrayLoader());
        $translator->addResource('array', [(string)$id => $translation], $locale, $domain);

        static::assertEquals($expected, $translator->translate($id, $parameters, $locale));
    }


    public function testAddResourceAfterTrans()
    {
        $translator = new Translator('fr');
        $translator->addLoader('array', new ArrayLoader());

        $translator->setFallbackLocales(['en']);

        $translator->addResource('array', ['foo' => 'foofoo'], 'en');
        static::assertEquals('foofoo', $translator->trans('foo'));

        $translator->addResource('array', ['bar' => 'foobar'], 'en');
        static::assertEquals('foobar', $translator->trans('bar'));
        static::assertEquals('foofoo', $translator->trans('foo'));
    }

    /**
     * @return array
     */
    public function getTransDataProvider()
    {
        return [
            ['Symfony est super !', 'Symfony is great!', 'Symfony est super !', [], 'fr', ''],
            ['Symfony est awesome !', 'Symfony is %what%!', 'Symfony est #{what} !', ['what' => 'awesome'], 'fr', '']
        ];
    }
}
