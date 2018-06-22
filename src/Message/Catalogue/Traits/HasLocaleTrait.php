<?php

namespace Nip\I18n\Message\Catalogue\Traits;

/**
 * Trait HasLocaleTrait
 * @package Nip\I18n\Message\Catalogue\Traits
 */
trait HasLocaleTrait
{
    protected $locale;

    /**
     * {@inheritdoc}
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     */
    public function setLocale($locale): void
    {
        $this->locale = $locale;
    }
}
