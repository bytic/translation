<?php

namespace Nip\I18n\Translator\Backend;

use Nip\I18n\Translator;
use Nip\I18n\Translator\Traits\LegacyCodeTrait;

/**
 * Trait BackendTrait
 * @package Nip\I18n\Translator\Backend
 */
trait BackendTrait
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
        if (!$this->translator) {
            $this->initTranslator();
        }

        return $this->translator;
    }

    /**
     * @param Translator|LegacyCodeTrait $translator
     */
    public function setTranslator($translator)
    {
        $this->translator = $translator;
    }
}
