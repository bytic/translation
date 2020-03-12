<?php

namespace Nip\I18n\Translator\Backend;

use Nip\I18n\Loader\PhpFileLoader;

/**
 * Class File
 * @package Nip\I18n\Translator\Backend
 */
class File
{
    use BackendTrait;

    /**
     * @param $language
     * @param $path
     */
    public function addLanguage($language, $path)
    {
        if (!$this->getTranslator()->hasLoader('php')) {
            $this->getTranslator()->addLoader('php', new PhpFileLoader());
        }

        $this->getTranslator()->addResource('php', $path, $language);
    }
}
