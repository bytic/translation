<?php

namespace Nip\I18n;

use Nip\I18n\Translator\Backend\AbstractBackend;
use Nip\I18n\Translator\Traits\HasCataloguesTrait;
use Nip\I18n\Translator\Traits\HasFormatterTrait;
use Nip\I18n\Translator\Traits\HasLoaderTrait;
use Nip\I18n\Translator\Traits\HasLocaleTrait;
use Nip\I18n\Translator\Traits\HasRequestTrait;
use Nip\I18n\Translator\Traits\HasResourcesTrait;
use Nip\I18n\Translator\Traits\TranslateTrait;
use function Nip\url;

/**
 * Class Translator
 * @package Nip\I18n
 */
class Translator
{
    use HasLoaderTrait, HasCataloguesTrait, HasLocaleTrait, HasResourcesTrait, HasRequestTrait, TranslateTrait, HasFormatterTrait;

    /**
     * @var bool
     */
    public $defaultLanguage = false;

    /**
     * @var bool|string
     */
    public $selectedLanguage = false;

    /**
     * @var array
     */
    protected $languageCodes = [
        'en' => 'en_US',
    ];

    public function __construct(?string $locale)
    {
        $this->setLocale($locale);
    }


    /**
     * @param $lang
     * @return string
     */
    public function changeLangURL($lang)
    {
        $newURL = str_replace('language=' . $this->getLanguage(), '', url()->current());
        $newURL = $newURL . (strpos($newURL, '?') == false ? '?' : '&') . 'language=' . $lang;

        return $newURL;
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
            $language = false;

            if (isset($_SESSION['language']) && $this->isValidLanguage($_SESSION['language'])) {
                $language = $_SESSION['language'];
            }

            $requestLanguage = $this->getRequest()->get('language');
            if ($requestLanguage && $this->isValidLanguage($requestLanguage)) {
                $language = $requestLanguage;
            }

            if ($language) {
                $this->setLanguage($language);
            } else {
                $this->setLanguage($this->getDefaultLanguage());
            }
        }

        return $this->selectedLanguage;
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
     * @return array
     */
    public function getLanguages()
    {
        return $this->backend->getLanguages();
    }

    /**
     * Selects a language to be used when translating
     *
     * @param string $language
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->selectedLanguage = $language;
        $_SESSION['language'] = $language;

        $code = $this->getLanguageCode($language);

        putenv('LC_ALL=' . $code);
        setlocale(LC_ALL, $code);
        setlocale(LC_NUMERIC, 'en_US');

        return $this;
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
     * Sets the default language to be used when translating
     *
     * @param string $language
     * @return $this
     */
    public function setDefaultLanguage($language)
    {
        $this->defaultLanguage = $language;

        return $this;
    }

}
