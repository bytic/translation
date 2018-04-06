<?php

namespace Nip\I18n\Translator\Traits;

use Nip\I18n\Exception\LogicException;
use Nip\I18n\Message\Catalogue\MessageCatalogueInterface;
use Nip\I18n\Message\Formatter\ChoiceMessageFormatterInterface;

trait TranslateTrait
{
    /**
     * {@inheritdoc}
     */
    public function trans($id, array $parameters = [], $domain = null, $locale = null)
    {
        if (null === $domain) {
            $domain = MessageCatalogueInterface::DEFAULT_DOMAIN;
        }
        $message = $this->getCatalogue($locale)->get((string)$id, $domain);
        return $this->getFormatter()->format($message, $locale, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function transChoice($id, $number, array $parameters = array(), $domain = null, $locale = null)
    {
        if (!$this->formatter instanceof ChoiceMessageFormatterInterface) {
            throw new LogicException(
                sprintf('The formatter "%s" does not support plural translations.',
                    get_class($this->formatter))
            );
        }
        if (null === $domain) {
            $domain = 'messages';
        }
        $id = (string)$id;
        $catalogue = $this->getCatalogue($locale);
        $locale = $catalogue->getLocale();
        while (!$catalogue->defines($id, $domain)) {
            if ($cat = $catalogue->getFallbackCatalogue()) {
                $catalogue = $cat;
                $locale = $catalogue->getLocale();
            } else {
                break;
            }
        }
        return $this->formatter->choiceFormat($catalogue->get($id, $domain), $number, $locale, $parameters);
    }
}