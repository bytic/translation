<?php

namespace Nip\I18n\Translator\Traits;

use Nip\I18n\Exception\InvalidArgumentException;
use Nip\I18n\Locale\LocaleValidator;
use Nip\I18n\Resource\Resource;
use Nip\I18n\Resource\ResourceCollection;
use Nip\I18n\Resource\ResourceFactory;

/**
 * Trait HasResourcesTrait
 * @package Nip\I18n\Translator\Traits
 */
trait HasResourcesTrait
{
    /**
     * @var ResourceCollection[]
     */
    protected $resources = [];

    /**
     * Adds a Resource.
     *
     * @param string $format The name of the loader (@see addLoader())
     * @param mixed $resource The resource name
     * @param string $locale The locale
     * @param string $domain The domain
     *
     * @throws InvalidArgumentException If the locale contains invalid characters
     */
    public function addResource($format, $resource, $locale, $domain = null)
    {
        LocaleValidator::assertValidLocale($locale);
        $resource = ResourceFactory::create($resource, $format, $domain);
        $this->appendResourceToCollection($locale, $resource);

        if ($this->isFallbackLocales($locale)) {
            $this->resetCatalogues();
        } else {
            $this->removeCatalogue($locale);
        }
    }

    /**
     * @param $locale
     * @return Resource[]
     */
    public function getResources($locale)
    {
        return $this->getResourceCollection($locale)->all();
    }

    /**
     * @param $locale
     * @return bool
     */
    public function hasResources($locale)
    {
        return $this->hasResourceCollection($locale) && $this->getResourceCollection($locale)->count() > 0;
    }

    /**
     * @param $locale
     * @param $resource
     * @return void
     */
    protected function appendResourceToCollection($locale, $resource)
    {
        $this->getResourceCollection($locale)[] = $resource;
    }

    /**
     * @param $locale
     * @return ResourceCollection
     */
    public function getResourceCollection($locale)
    {
        $this->checkInitResourceCollection($locale);
        return $this->resources[$locale];
    }

    /**
     * @param $locale
     * @return bool
     */
    public function hasResourceCollection($locale)
    {
        return isset($this->resources[$locale]);
    }

    /**
     * @param $locale
     * @param ResourceCollection $collection
     * @return void
     */
    public function setResourceCollection($locale, $collection)
    {
        $this->resources[$locale] = $collection;
    }

    protected function checkInitResourceCollection($locale)
    {
        if (!$this->hasResourceCollection($locale)) {
            $this->initResourceCollection($locale);
        }
    }

    /**
     * @param $locale
     * @return void
     */
    protected function initResourceCollection($locale)
    {
        $this->setResourceCollection($locale, $this->newResourceCollection($locale));
    }

    /**
     * @param $locale
     * @return ResourceCollection
     */
    protected function newResourceCollection($locale)
    {
        $collection = new ResourceCollection();
        $collection->setLocale($locale);
        return $collection;
    }
}
