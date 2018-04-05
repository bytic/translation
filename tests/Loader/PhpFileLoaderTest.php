<?php

namespace Nip\I18n\Tests\Translator\Backend;

use Nip\I18n\Catalogue\MessageCatalogueInterface;
use Nip\I18n\Loader\PhpFileLoader;
use Nip\I18n\Tests\AbstractTest;

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
}
