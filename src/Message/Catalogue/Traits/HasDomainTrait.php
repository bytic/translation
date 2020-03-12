<?php

namespace Nip\I18n\Message\Catalogue\Traits;

use Nip\I18n\Message\Catalogue\MessageCatalogueInterface;

/**
 * Trait HasDomainTrait
 * @package Nip\I18n\Message\Catalogue\Traits
 */
trait HasDomainTrait
{

    /**
     * {@inheritdoc}
     */
    public function getDomains()
    {
        return array_keys($this->messages);
    }

    /**
     * @param string $domain
     * @return string
     */
    public function checkDomain($domain = MessageCatalogueInterface::DEFAULT_DOMAIN)
    {
        if (empty($domain)) {
            return MessageCatalogueInterface::DEFAULT_DOMAIN;
        }
        return $domain;
    }
}