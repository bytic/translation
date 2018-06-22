<?php

namespace Nip\I18n\Message\Catalogue\Traits;

use Nip\I18n\Resource\ResourceInterface;

trait HasResourcesTrait
{
    protected $resources = [];

    /**
     * {@inheritdoc}
     */
    public function getResources()
    {
        return array_values($this->resources);
    }

    /**
     * {@inheritdoc}
     */
    public function addResource(ResourceInterface $resource)
    {
        $this->resources[$resource->__toString()] = $resource;
    }
}
