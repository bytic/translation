<?php

namespace Nip\I18n\Translator\Traits;

use Nip\I18n\Catalogue\MessageCatalogue;
use Nip\I18n\Catalogue\MessageCatalogueInterface;
use Nip\I18n\Exception\NotFoundResourceException;
use Nip\I18n\Exception\RuntimeException;
use Nip\I18n\Locale\LocaleValidator;

/**
 * Trait HasCataloguesTrait
 * @package Nip\I18n\Translator\Traits
 *
 * @property $cacheDir
 */
trait HasCataloguesTrait
{
    /**
     * @var MessageCatalogueInterface[]
     */
    protected $catalogues = [];

    /**
     * {@inheritdoc}
     */
    public function getCatalogue($locale = null)
    {
        $locale = $this->checkValidLocale($locale);
        $this->checkLoadedCatalogue($locale);
        return $this->catalogues[$locale];
    }

    /**
     * @param $locale
     * @return bool
     */
    public function hasCatalogue($locale)
    {
        return isset($this->catalogues[$locale]);
    }

    public function removeCatalogue($locale)
    {
        unset($this->catalogues[$locale]);
    }

    public function resetCatalogues()
    {
        $this->catalogues = [];
    }

    /**
     * @param null $locale
     * return void
     */
    protected function checkLoadedCatalogue($locale = null)
    {
        if (!$this->hasCatalogue($locale)) {
            $this->loadCatalogue($locale);
        }
    }

    /**
     * @param string $locale
     */
    protected function loadCatalogue($locale)
    {
        if (property_exists($this, 'cacheDir')) {
            $this->initializeCacheCatalogue($locale);
            return;
        }
        $this->initializeCatalogue($locale);

    }

    /**
     * @param string $locale
     */
    protected function initializeCatalogue($locale)
    {
        LocaleValidator::assertValidLocale($locale);

        try {
            $this->doLoadCatalogue($locale);
        } catch (NotFoundResourceException $e) {
            if (!$this->computeFallbackLocales($locale)) {
                throw $e;
            }
        }
        $this->loadFallbackCatalogues($locale);
    }

    protected function initializeCacheCatalogue(string $locale): void
    {

    }

    protected function doLoadCatalogue($locale): void
    {
        $catalogue = new MessageCatalogue($locale);

        if ($this->hasResources($locale)) {
            $this->getResourceCollection($locale)->loadIntoCatalogue($this, $catalogue);
        }
        $this->setCatalogue($locale, $catalogue);
    }

    protected function setCatalogue($locale, MessageCatalogueInterface $catalogue)
    {
        $this->catalogues[$locale] = $catalogue;
    }

    protected function loadFallbackCatalogues($locale): void
    {
        $current = $this->catalogues[$locale];
        foreach ($this->computeFallbackLocales($locale) as $fallback) {
            if (!isset($this->catalogues[$fallback])) {
                $this->initializeCatalogue($fallback);
            }

            $fallbackCatalogue = new MessageCatalogue($fallback, $this->catalogues[$fallback]->all());
            foreach ($this->catalogues[$fallback]->getResources() as $resource) {
                $fallbackCatalogue->addResource($resource);
            }

            $current->addFallbackCatalogue($fallbackCatalogue);
            $current = $fallbackCatalogue;
        }
    }
}