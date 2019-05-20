<?php

namespace Nip\I18n\Translator\Traits;

use Nip\Locale\Detector\Detector;
use Nip\Request;

/**
 * Trait HasRequestTrait
 * @package Nip\I18n\Translator\Traits
 */
trait HasRequestTrait
{
    /**
     * @var Request
     */
    protected $request = null;

    /**
     * @return Request
     */
    public function getRequest()
    {
        $this->checkInitRequest();
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    public function setLocaleFromRequest()
    {
        $locale = $this->detectLocaleFromRequest();
        if ($locale) {
            $this->setLocale($locale);
        }
    }

    /**
     * @return string|null
     */
    protected function detectLocaleFromRequest()
    {
        $locale = Detector::detect($this->getRequest());

        return !empty($locale) && $this->isSupportedLocale($locale) ? $locale : null;
    }

    protected function checkInitRequest()
    {
        if ($this->request === null) {
            $this->setRequest($this->generateRequest());
        }
    }

    /**
     * @return Request
     */
    protected function generateRequest()
    {
        return app('request');
    }
}
