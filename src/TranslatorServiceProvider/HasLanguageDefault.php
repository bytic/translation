<?php

namespace Nip\I18n\TranslatorServiceProvider;

use Nip\I18n\Translator;

/**
 * Trait HasLanguageDefault
 * @package Nip\I18n\TranslatorServiceProvider
 */
trait HasLanguageDefault
{
    protected function bootLanguageDefault()
    {
        $langDefault = $this->getLanguageDefault();

        /** @var Translator $translator */
        $translator = $this->getContainer()->get('translator');
        $translator->setPersistedLocale($langDefault);
    }

    /**
     * @return string
     */
    protected function getLanguageDefault()
    {
        /** @noinspection PhpUndefinedFunctionInspection */
        return function_exists('config') && function_exists('app') && \app()->has('config') ? config('app.locale.default') : 'en';
    }
}
