<?php

namespace Nip\I18n\Translator\Traits;

use Nip\I18n\Translator\Backend\BackendTrait;
use Nip\Locale\Detector\Detector;
use Nip\Locale\Detector\LocalePersist;

/**
 * Trait LegacyCodeTrait
 * @package Nip\I18n\Translator\Traits
 */
trait LegacyCodeTrait
{

    /**
     * @var bool
     */
    public $defaultLanguage = false;

    /**
     * @var bool|string
     */
    public $selectedLanguage = false;

    /**
     * @return array
     * @deprecated Use getAvailableResourceLocales instead
     */
    public function getLanguages()
    {
        return $this->getAvailableResourceLocales();
    }

    /**
     * @deprecated use getLocale()
     */
    public function getLanguage()
    {
        if (!$this->selectedLanguage) {
            $this->setLocaleFromRequest();
            $locale = $this->getLocale();
            $this->persistLocale();

            $this->selectedLanguage = $locale;
        }

        return $this->getLocale();
    }

    /**
     * @param string $language
     * @return $this
     * @deprecated Use setPersistedLocale
     */
    public function setLanguage($language)
    {
        $this->setPersistedLocale($language);

        return $this;
    }

    /**
     * @param $lang
     * @return boolean
     * @deprecated use isSupportedLocale
     */
    public function isValidLanguage($lang)
    {
        return $this->isSupportedLocale($lang);
    }

    /**
     * @param string $lang
     * @return string
     */
    public function getLanguageCode($lang)
    {
        if (isset($this->languageCodes[$lang])) {
            return $this->languageCodes[$lang];
        }

        return $lang . "_" . strtoupper($lang);
    }

    /**
     * gets the default language to be used when translating
     * @return boolean $language
     */
    public function getDefaultLanguage()
    {
        if (!$this->defaultLanguage) {
            $language = substr(setlocale(LC_ALL, 0), 0, 2);
            $languages = $this->getLanguages();
            $languageDefault = reset($languages);
            $language = $this->isValidLanguage($language) ? $language : $languageDefault;
            $this->setDefaultLanguage($language);
        }

        return $this->defaultLanguage;
    }

    /**
     * @param string $language
     * @return $this
     * @deprecated Use setLocale
     */
    public function setDefaultLanguage($language)
    {
        $this->setLocale($language);
        $this->defaultLanguage = $language;

        return $this;
    }

    /**
     * @param BackendTrait $backend
     * @deprecated
     */
    public function setBackend($backend)
    {
        $backend->setTranslator($this);
    }
}
