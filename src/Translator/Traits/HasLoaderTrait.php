<?php

namespace Nip\I18n\Translator\Traits;

use Nip\I18n\Loaders\LoaderInterface;

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
     * Gets the loaders.
     *
     * @return array LoaderInterface[]
     */
    protected function getLoaders()
    {
        return $this->loaders;
    }
}