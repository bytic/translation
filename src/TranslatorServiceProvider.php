<?php

namespace Nip\I18n;

use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;
use Nip\Container\ServiceProviders\Providers\BootableServiceProviderInterface;
use Nip\I18n\Loader\PhpFileLoader;
use Nip\I18n\Middleware\LocalizationMiddleware;

/**
 * Class MailServiceProvider
 * @package Nip\Mail
 */
class TranslatorServiceProvider extends AbstractSignatureServiceProvider implements BootableServiceProviderInterface
{
    use TranslatorServiceProvider\HasLanguageDefault;
    use TranslatorServiceProvider\HasLanguages;

    protected $languageDirectory = null;

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['translator', 'translation.languages', 'translation.loader'];
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerLanguages();
        $this->registerTranslator();
        $this->registerResources();
        $this->registerMiddleware();
    }

    public function boot()
    {
        $this->bootLanguageDefault();
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

    protected function registerMiddleware()
    {
        if (!$this->getContainer()->has('kernel.http')) {
            return;
        }
        $kernel = $this->getContainer()->has('kernel') ? $this->getContainer()->get('kernel.http') : null;
        if (!$kernel || !method_exists($kernel, 'pushMiddleware')) {
            return;
        }
        $kernel->prependMiddleware(
            new LocalizationMiddleware($this->getContainer()->get('translator'))
        );
    }
}
