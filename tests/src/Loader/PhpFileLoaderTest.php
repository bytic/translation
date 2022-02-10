<?php

namespace Nip\I18n\Tests\Loader;

use Nip\I18n\Loader\PhpFileLoader;
use Nip\I18n\Message\Catalogue\MessageCatalogueInterface;
use Nip\I18n\Tests\AbstractTest;
use const TEST_FIXTURE_PATH;

/**
 * Class PhpFileLoaderTest
 * @package Nip\I18n\Tests\Loader
 */
class PhpFileLoaderTest extends AbstractTest
{
    public function testAddLanguage()
    {
        $loader = new PhpFileLoader();
        $resource = TEST_FIXTURE_PATH . '/languages/en/general.php';
        $catalogue = $loader->load($resource, 'en');

        self::assertSame('en', $catalogue->getLocale());
        self::assertSame('Day', $catalogue->get('day'));

        self::assertSame(
            ['day' => 'Day'],
            $catalogue->all(MessageCatalogueInterface::DEFAULT_DOMAIN)
        );
    }

    public function testAddDirectory()
    {
        $loader = new PhpFileLoader();
        $resource = TEST_FIXTURE_PATH . '/languages/en/';
        $catalogue = $loader->load($resource, 'en');

        self::assertSame('en', $catalogue->getLocale());
        self::assertSame('Day', $catalogue->get('day'));
        self::assertSame('Subject', $catalogue->get('subject'));
    }
}
