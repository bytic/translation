<?php

namespace Nip\I18n\Loader;

class PhpFileLoader extends FileLoader
{

    /**
     * {@inheritdoc}
     */
    protected function loadResource($resource)
    {
        /** @var TYPE_NAME $resource */
        return require $resource;
    }

}