<?php

namespace Nip\I18n\Tests\Resource;

use Nip\I18n\Message\Catalogue\MessageCatalogueInterface;
use Nip\I18n\Resource\ResourceFactory;
use Nip\I18n\Tests\AbstractTest;

class ResourceFactoryTest extends AbstractTest
{


    /**
     * @dataProvider getEmptyValuesProvider
     */
    public function testCreateWithEmptyValues($domain)
    {
        $resource = ResourceFactory::create('trans.php', 'php', $domain);

        self::assertEquals(MessageCatalogueInterface::DEFAULT_DOMAIN, $resource->getDomain());
    }

    public function getEmptyValuesProvider()
    {
        return [
            [null],
            [false],
            [0],
            [''],
        ];
    }
}
