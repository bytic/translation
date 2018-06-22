<?php

/*
 * Based on https://github.com/symfony/translation/blob/master/Loader/FileLoader.php
 */

namespace Nip\I18n\Loader;

use Nip\I18n\Exception\InvalidResourceException;
use Nip\I18n\Exception\NotFoundResourceException;

abstract class FileLoader extends ArrayLoader
{

    /**
     * {@inheritdoc}
     */
    public function load($resource, $locale, $domain = 'messages')
    {
        if (!stream_is_local($resource)) {
            throw new InvalidResourceException(sprintf('This is not a local file "%s".', $resource));
        }

        if (!file_exists($resource)) {
            throw new NotFoundResourceException(sprintf('File "%s" not found.', $resource));
        }
        $messages = $this->loadResource($resource);

        // empty resource
        if (null === $messages) {
            $messages = array();
        }

        // not an array
        if (!is_array($messages)) {
            throw new InvalidResourceException(sprintf('Unable to load file "%s".', $resource));
        }

        $catalogue = parent::load($messages, $locale, $domain);

//        if (class_exists('Symfony\Component\Config\Resource\FileResource')) {
//            $catalogue->addResource(new FileResource($resource));
//        }

        return $catalogue;
    }

    /**
     * @param string $resource
     *
     * @return array
     *
     * @throws InvalidResourceException if stream content has an invalid format
     */
    abstract protected function loadResource($resource);
}
