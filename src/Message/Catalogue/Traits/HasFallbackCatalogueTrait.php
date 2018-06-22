<?php

namespace Nip\I18n\Message\Catalogue\Traits;

use Nip\I18n\Message\Catalogue\MessageCatalogue;
use Nip\I18n\Message\Catalogue\MessageCatalogueInterface;
use Nip\I18n\Exception\LogicException;

/**
 * Trait HasFallbackCatalogueTrait
 * @package Nip\I18n\Message\Catalogue\Traits
 */
trait HasFallbackCatalogueTrait
{

    /**
     * @var MessageCatalogue
     */
    protected $fallbackCatalogue;

    /**
     * {@inheritdoc}
     */
    public function addFallbackCatalogue(MessageCatalogueInterface $catalogue)
    {
        // detect circular references
        $c = $catalogue;
        while ($c = $c->getFallbackCatalogue()) {
            if ($c->getLocale() === $this->getLocale()) {
                throw new LogicException(sprintf('Circular reference detected when adding a fallback catalogue for locale "%s".',
                    $catalogue->getLocale()));
            }
        }
        $c = $this;
        do {
            if ($c->getLocale() === $catalogue->getLocale()) {
                throw new LogicException(sprintf('Circular reference detected when adding a fallback catalogue for locale "%s".',
                    $catalogue->getLocale()));
            }
            foreach ($catalogue->getResources() as $resource) {
                $c->addResource($resource);
            }
        } while ($c = $c->parent);
        $catalogue->parent = $this;
        $this->fallbackCatalogue = $catalogue;
        foreach ($catalogue->getResources() as $resource) {
            $this->addResource($resource);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFallbackCatalogue()
    {
        return $this->fallbackCatalogue;
    }
}
