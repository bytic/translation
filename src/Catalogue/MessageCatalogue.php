<?php

namespace Nip\I18n\Catalogue;

use Nip\I18n\Catalogue\Traits\HasCatalogueOperationsTrait;
use Nip\I18n\Catalogue\Traits\HasFallbackCatalogueTrait;
use Nip\I18n\Catalogue\Traits\HasLocaleTrait;
use Nip\I18n\Catalogue\Traits\HasMessagesTrait;
use Nip\I18n\Catalogue\Traits\HasMetadataTrait;
use Nip\I18n\Catalogue\Traits\HasResourcesTrait;

class MessageCatalogue implements MessageCatalogueInterface, MetadataAwareInterface
{
    use HasLocaleTrait, HasMessagesTrait, HasCatalogueOperationsTrait, HasFallbackCatalogueTrait, HasMetadataTrait, HasResourcesTrait;

    protected $parent;

    /**
     * @param string $locale The locale
     * @param array $messages An array of messages classified by domain
     */
    public function __construct(?string $locale, array $messages = [])
    {
        $this->setLocale($locale);
        $this->setMessages($messages);
    }

    /**
     * {@inheritdoc}
     */
    public function getDomains()
    {
        return array_keys($this->messages);
    }
}
