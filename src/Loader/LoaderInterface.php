<?php

namespace Nip\I18n\Loader;

use Nip\I18n\Message\Catalogue\MessageCatalogueInterface;

interface LoaderInterface
{
    /**
     * @param $resource
     * @param $locale
     * @param string $domain
     * @return mixed
     */
    public function load($resource, $locale, $domain = MessageCatalogueInterface::DEFAULT_DOMAIN);
}