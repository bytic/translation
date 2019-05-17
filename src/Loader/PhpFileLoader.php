<?php

namespace Nip\I18n\Loader;

use Symfony\Component\Finder\Finder;

/**
 * Class PhpFileLoader
 * @package Nip\I18n\Loader
 */
class PhpFileLoader extends FileLoader
{

    /**
     * {@inheritdoc}
     */
    protected function loadResource($resource)
    {
        if (is_dir($resource)) {
            return $this->loadResourceDirectory($resource);
        }

        return $this->loadResourceFile($resource);
    }


    /**
     * {@inheritdoc}
     */
    protected function loadResourceDirectory($resource)
    {
        $files = $this->listResourceDirectory($resource);
        if ($files->count() < 1) {
            return false;
        }
        $messages = [];
        foreach ($files as $file) {
            $messages = array_merge($messages, $this->loadResourceFile($file->getPathname()));
        }
        return $messages;
    }

    /**
     * @param $directory
     * @return Finder
     */
    protected function listResourceDirectory($directory)
    {
        $finder = new Finder();
        $extension = 'php';
        return $finder->files()->name('*.' . $extension)->in($directory);
    }

    /**
     * {@inheritdoc}
     */
    protected function loadResourceFile($resource)
    {
        /** @var TYPE_NAME $resource */
        return require $resource;
    }
}
