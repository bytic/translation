<?php

namespace Nip\I18n\Message\Catalogue\Traits;

use Nip\I18n\Message\Catalogue\MessageCatalogueInterface;
use Nip\I18n\Message\Catalogue\MetadataAwareInterface;
use Nip\I18n\Exception\LogicException;

trait HasCatalogueOperationsTrait
{
    /**
     * {@inheritdoc}
     */
    public function addCatalogue(MessageCatalogueInterface $catalogue)
    {
        if ($catalogue->getLocale() !== $this->locale) {
            throw new LogicException(sprintf('Cannot add a catalogue for locale "%s" as the current locale for this catalogue is "%s"',
                $catalogue->getLocale(), $this->locale));
        }
        foreach ($catalogue->all() as $domain => $messages) {
            $this->add($messages, $domain);
        }
        foreach ($catalogue->getResources() as $resource) {
            $this->addResource($resource);
        }
        if ($catalogue instanceof MetadataAwareInterface) {
            $metadata = $catalogue->getMetadata('', '');
            $this->addMetadata($metadata);
        }
    }
}