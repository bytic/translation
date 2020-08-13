<?php

namespace Nip\I18n\Translator\Traits;

use Nip\I18n\Loader\LoaderInterface;

trait HasLoaderTrait
{
    /**
     * @var LoaderInterface[]
     */
    protected $loaders = [];

    /**
     * Adds a Loader.
     *
     * @param string $format The name of the loader (@see addResource())
     * @param LoaderInterface $loader A LoaderInterface instance
     */
    public function addLoader($format, LoaderInterface $loader)
    {
        $this->loaders[$format] = $loader;
    }

    /**
     * @param string $format
     * @return bool
     */
    public function hasLoader($format)
    {
        return isset($this->loaders[$format]);
    }

    /**
     * @param $format
     * @return LoaderInterface
     */
    public function getLoader($format)
    {
        return $this->loaders[$format];
    }

    /**
     * Gets the loaders.
     *
     * @return array LoaderInterface[]
     */
    public function getLoaders()
    {
        return $this->loaders;
    }
}
