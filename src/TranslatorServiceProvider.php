<?php

namespace Nip\I18n;

use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;
use Nip\I18n\Loader\PhpFileLoader;
use Nip\I18n\Middleware\LocalizationMiddleware;

/**
 * Class MailServiceProvider
 * @package Nip\Mail
 */
class TranslatorServiceProvider extends AbstractSignatureServiceProvider
{
    protected $languages = null;
    protected $languageDirectory = null;

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerLanguages();
        $this->registerTranslator();
        $this->registerLanguageDefault();
        $this->registerResources();
        $this->registerMiddleware();
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['translator', 'translation.languages', 'translation.loader'];
    }


    /**
     * Register the session manager instance.
     *
     * @return void
     */
    protected function registerTranslator()
    {
        $this->getContainer()
            ->share('translator', function () {
                $translator = new Translator('en');
                $translator->addLoader('php', new PhpFileLoader());
                return $translator;
            });
    }

    /**
     * Register the translation line loader.
     *
     * @return void
     */
    protected function registerResources()
    {
        $basDirectory = $this->getLanguageDirectory();
        $languages = $this->getContainer()->get('translation.languages');

        /** @var Translator $translator */
        $translator = $this->getContainer()->get('translator');

        foreach ($languages as $language) {
            $translator->addResource('php', $basDirectory . DIRECTORY_SEPARATOR . $language, $language);
        }
    }

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

    /**
     * @return null
     */
    protected function getLanguageDirectory()
    {
        if ($this->languageDirectory === null) {
            $this->initLanguageDirectory();
        }

        return $this->languageDirectory;
    }

    /**
     * Made public to allow testing
     * @param null $languageDirectory
     */
    public function setLanguageDirectory($languageDirectory)
    {
        $this->languageDirectory = $languageDirectory;
    }

    protected function initLanguageDirectory()
    {
        $this->setLanguageDirectory($this->generateLanguageDirectory());
    }

    /**
     * @return string
     */
    protected function generateLanguageDirectory()
    {
        /** @noinspection PhpUndefinedFunctionInspection */
        return app('path.lang');
    }

    protected function registerLanguageDefault()
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

    protected function registerMiddleware()
    {
        if ($this->getContainer()->has('kernel.http')) {
            $kernel = $this->getContainer()->has('kernel') ? $this->getContainer()->get('kernel.http') : null;
            if ($kernel && method_exists($kernel, 'pushMiddleware')) {
            // REMOVE Middleware. Now it overwrites config variable
//            $kernel->prependMiddleware(
    //            new LocalizationMiddleware($this->getContainer()->get('translator'))
    //        );
            }
        }
    }
}
