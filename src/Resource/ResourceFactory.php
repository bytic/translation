<?php

namespace Nip\I18n\Resource;

use Nip\I18n\Message\Catalogue\MessageCatalogueInterface;

class ResourceFactory
{
    /**
     * Adds a Resource.
     *
     * @param mixed $resource The resource name
     * @param string $format The name of the loader (@see addLoader())
     * @param string $domain The domain
     *
     * @return Resource
     */
    public static function create($resource, $format, $domain = null)
    {
        if (empty($domain)) {
            $domain = MessageCatalogueInterface::DEFAULT_DOMAIN;
        }
        $resource = new Resource($resource, $format, $domain);
        return $resource;
    }
}