<?php

namespace Nip\I18n\Translator\Traits;

use Nip\I18n\Exception\InvalidArgumentException;
use Nip\I18n\Locale\LocaleValidator;

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
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * {@inheritdoc}
     */
    public function checkValidLocale($locale = null)
    {
        if (null === $locale) {
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
        $locales = array();
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