<?php

namespace Nip\I18n\Translator\Traits;

use Nip\I18n\Translator\Backend\BackendTrait;
use Nip\Locale\Detector\Detector;

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
     * Checks SESSION, GET and Nip_Request and selects requested language
     * If language not requested, falls back to default
     *
     * @return string
     */
    public function getLanguage()
    {
        if (!$this->selectedLanguage) {
            $locale = Detector::detect($this->getRequest());

            if ($locale) {
                $this->setLanguage($locale);
            } else {
                $this->setLanguage($this->getDefaultLanguage());
            }
        }

        return $this->selectedLanguage;
    }

    /**
     * Selects a language to be used when translating
     *
     * @param string $language
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->setLocale($language);

        $code = $this->getLanguageCode($language);

        putenv('LC_ALL=' . $code);
        setlocale(LC_ALL, $code);
        setlocale(LC_NUMERIC, 'en_US');

        return $this;
    }

    /**
     * @param $lang
     * @return bool
     */
    public function isValidLanguage($lang)
    {
        return in_array($lang, $this->getLanguages());
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
