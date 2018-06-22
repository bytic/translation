<?php

namespace Nip\I18n\Translator\Traits;

use Nip\Request;

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

    protected function checkInitRequest()
    {
        if ($this->request === null) {
            $this->setRequest($this->generateRequest());
        }
    }

    protected function generateRequest()
    {
        return app('request');
    }
}
