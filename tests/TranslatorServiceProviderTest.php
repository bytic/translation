<?php

namespace Nip\I18n\Tests;

use Nip\Config\Config;
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
    public function test_registerLoader()
    {
        $provider = new TranslatorServiceProvider();
        $provider->setLanguages(['ro', 'en']);
        $provider->setLanguageDirectory(TEST_FIXTURE_PATH . DIRECTORY_SEPARATOR . 'languages');

        $container = new Container();
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
     * @dataProvider data_registerLanguages
     * @param $config
     * @param $return
     */
    public function test_registerLanguages($config, $return)
    {
        $provider = new TranslatorServiceProvider();

        $config = new Config(['app' => ['locale' => ['enabled' => $config]]]);

        $container = Container::getInstance();

        $container->set('config', $config);

        $provider->setContainer($container);
        $provider->registerLanguages();

        self::assertSame($return, $container->get('translation.languages'));
    }

    /**
     * @return array
     */
    public function data_registerLanguages()
    {
        return [
            ['', []],
            [null, []],
            [1, []],
            ['ro', ['ro']],
            ['ro,', ['ro']],
            ['ro,en', ['ro', 'en']],
        ];
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
