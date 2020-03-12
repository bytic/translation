<?php

namespace Nip\I18n\Translator\Traits;

use Nip\I18n\Exception\InvalidArgumentException;
use Nip\I18n\Locale\LocaleValidator;
use Nip\Locale\Detector\LocalePersist;

/**
 * Trait HasLocaleTrait
 * @package Nip\I18n\Translator\Traits
 */
trait HasLocaleTrait
{

    /**
     * @var string
     */
    protected $locale;


    /**
     * @var array
     */
    private $fallbackLocales = [];

    /**
     * {@inheritdoc}
     */
    public function setLocale($locale)
    {
        LocaleValidator::assertValidLocale($locale);
        $this->locale = $locale;
    }

    /**
     * {@inheritdoc}
     */
    public function setPersistedLocale($locale)
    {
        $this->setLocale($locale);
        $this->persistLocale();
    }

    public function persistLocale()
    {
        LocalePersist::persist($this->getLocale());
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param $locale
     * @return bool
     */
    public function isSupportedLocale($locale)
    {
        return in_array($locale, $this->getAvailableResourceLocales());
    }

    /**
     * {@inheritdoc}
     */
    public function checkValidLocale($locale = null)
    {
        if (empty($locale)) {
            $locale = $this->getLocale();
        }
        LocaleValidator::assertValidLocale($locale);
        return $locale;
    }

    /**
     * Sets the fallback locales.
     *
     * @param array $locales The fallback locales
     *
     * @throws InvalidArgumentException If a locale contains invalid characters
     */
    public function setFallbackLocales(array $locales)
    {
        // needed as the fallback locales are linked to the already loaded catalogues
        $this->resetCatalogues();
        foreach ($locales as $locale) {
            LocaleValidator::assertValidLocale($locale);
        }
        $this->fallbackLocales = $locales;
    }

    /**
     * Gets the fallback locales.
     *
     * @return array $locales The fallback locales
     */
    public function getFallbackLocales()
    {
        return $this->fallbackLocales;
    }

    /**
     * @param $locale
     * @return bool
     */
    public function isFallbackLocales($locale)
    {
        return in_array($locale, $this->fallbackLocales);
    }

    /**
     * @param $locale
     * @return array
     */
    protected function computeFallbackLocales($locale)
    {
        $locales = [];
        foreach ($this->fallbackLocales as $fallback) {
            if ($fallback === $locale) {
                continue;
            }
            $locales[] = $fallback;
        }

        if (false !== strrchr($locale, '_')) {
            array_unshift($locales, substr($locale, 0, -strlen(strrchr($locale, '_'))));
        }
        return array_unique($locales);
    }
}
