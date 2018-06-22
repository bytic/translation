<?php

namespace Nip\I18n\Tests;

use Nip\Container\Container;
use Nip\Container\ContainerInterface;
use Nip\I18n\Translator;
use Nip\I18n\TranslatorServiceProvider;

/**
 * Class TranslatorServiceProviderTest
 * @package Nip\Tests\Form
 */
class TranslatorServiceProviderTest extends AbstractTest
{
    public function testRegisterLoader()
    {
        $provider = new TranslatorServiceProvider();
        $provider->setLanguages(['ro', 'en']);
        $provider->setLanguageDirectory(TEST_FIXTURE_PATH . DIRECTORY_SEPARATOR . 'languages');
        $container = Container::getInstance();
//        $container->addServiceProvider($provider);
        $provider->setContainer($container);
        $provider->register();

        $container = $provider->getContainer();
        self::assertInstanceOf(ContainerInterface::class, $container);

        $translator = $container->get('translator');
        self::assertInstanceOf(Translator::class, $translator);

        self::assertSame('Day', $translator->trans('day'));
        self::assertSame('Day', $translator->trans('day', [], null, 'en'));
        self::assertSame('Zi', $translator->trans('day', [], null, 'ro'));
    }

    /**
     * @return Container
     */
    protected function getContainer()
    {
        $container = Container::getInstance();
        $container->addServiceProvider(TranslatorServiceProvider::class);
        return $container;
    }
}
