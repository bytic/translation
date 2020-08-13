<?php

namespace Nip\I18n\Message\Catalogue;

use Nip\I18n\Message\Catalogue\Traits\HasCatalogueOperationsTrait;
use Nip\I18n\Message\Catalogue\Traits\HasDomainTrait;
use Nip\I18n\Message\Catalogue\Traits\HasFallbackCatalogueTrait;
use Nip\I18n\Message\Catalogue\Traits\HasLocaleTrait;
use Nip\I18n\Message\Catalogue\Traits\HasMessagesTrait;
use Nip\I18n\Message\Catalogue\Traits\HasMetadataTrait;
use Nip\I18n\Message\Catalogue\Traits\HasResourcesTrait;

/**
 * Class MessageCatalogue
 * @package Nip\I18n\Message\Catalogue
 */
class MessageCatalogue implements MessageCatalogueInterface, MetadataAwareInterface
{
    use HasLocaleTrait;
    use HasMessagesTrait;
    use HasCatalogueOperationsTrait;
    use HasFallbackCatalogueTrait;
    use HasDomainTrait;
    use HasMetadataTrait;
    use HasResourcesTrait;

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
}
