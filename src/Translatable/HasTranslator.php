<?php

namespace Nip\I18n\Translatable;

use Nip\I18n\Translator as Translator;

/**
 * Trait HasTranslator
 * @package Nip\I18n\Translatable
 */
trait HasTranslator
{
    /**
     * @var Translator
     */
    protected $translator = null;

    /**
     * @return Translator
     */
    public function getTranslator()
    {
        if ($this->translator == null) {
            $this->initTranslator();
        }

        return $this->translator;
    }

    /**
     * @param Translator $translator
     */
    public function setTranslator($translator)
    {
        $this->translator = $translator;
    }

    protected function initTranslator()
    {
        $this->setTranslator($this->newTranslator());
    }

    /**
     * @return Translator
     */
    protected function newTranslator()
    {
        return app('translator');
    }
}
