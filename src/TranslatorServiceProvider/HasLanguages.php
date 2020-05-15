<?php

namespace Nip\I18n\TranslatorServiceProvider;

/**
 * Trait HasLanguages
 * @package Nip\I18n\TranslatorServiceProvider
 */
trait HasLanguages
{
    protected $languages = null;

    public function registerLanguages()
    {
        $this->getContainer()->share('translation.languages', function () {
            return $this->getLanguages();
        });
    }

    /**
     * @return null
     */
    protected function getLanguages()
    {
        if ($this->languages === null) {
            $this->initLanguages();
        }

        return $this->languages;
    }

    protected function initLanguages()
    {
        $this->setLanguages($this->generateLanguages());
    }

    /**
     * @return array
     */
    protected function generateLanguages()
    {
        /** @noinspection PhpUndefinedFunctionInspection */
        $languages = config('app.locale.enabled');

        if (empty($languages)) {
            return [];
        }

        if (is_string($languages)) {
            $languages = explode(',', $languages);
        }

        if (!is_array($languages)) {
            return [];
        }

        return array_filter($languages);
    }

    /**
     * Made public to allow testing
     * @param null $languages
     */
    public function setLanguages($languages)
    {
        $this->languages = $languages;
    }
}