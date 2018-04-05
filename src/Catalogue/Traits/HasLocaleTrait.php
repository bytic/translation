<?php

namespace Nip\I18n\Catalogue\Traits;

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