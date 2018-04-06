<?php

namespace Nip\I18n\Resource;

class Resource implements ResourceInterface
{
    protected $resource;

    protected $format;

    protected $domain;

    public function __construct($resource, $format, $domain)
    {
        $this->setResource($resource);
        $this->setFormat($format);
        $this->setDomain($domain);
    }

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param mixed $format
     */
    public function setFormat($format): void
    {
        $this->format = $format;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
    }

    /**
     * @return mixed
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param mixed $domain
     */
    public function setDomain($domain): void
    {
        $this->domain = $domain;
    }

    /**
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param mixed $resource
     */
    public function setResource($resource): void
    {
        $this->resource = $resource;
    }
}
