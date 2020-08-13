<?php

namespace Nip\I18n\Resource;

use Nip\Collections\Collection;
use Nip\I18n\Message\Catalogue\MessageCatalogueInterface;
use Nip\I18n\Exception\RuntimeException;
use Nip\I18n\Translator;

/**
 * Class ResourceCollection
 * @package Nip\I18n\Resource
 */
class ResourceCollection extends Collection
{
    protected $locale;

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     */
    public function setLocale($locale): void
    {
        $this->locale = $locale;
    }

    /**
     * @param Translator $translator
     * @param MessageCatalogueInterface $catalogue
     */
    public function loadIntoCatalogue(Translator $translator, MessageCatalogueInterface $catalogue)
    {
        foreach ($this as $resource) {
            /** @var Resource $resource */
            if (!$translator->hasLoader($resource->getFormat())) {
                throw new RuntimeException(
                    sprintf(
                    'The "%s" translation loader is not registered.',
                    $resource->getFormat()
                )
                );
            }
            $loader = $translator->getLoader($resource->getFormat());
            $newCatalogue = $loader->load($resource->getResource(), $this->getLocale(), $resource->getDomain());
            $catalogue->addCatalogue($newCatalogue);
        }
    }
}
