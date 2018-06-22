<?php

namespace Nip\I18n\Translator\Traits;

use Nip\I18n\Exception\LogicException;
use Nip\I18n\Message\Catalogue\MessageCatalogueInterface;
use Nip\I18n\Message\Formatter\ChoiceMessageFormatterInterface;

/**
 * Trait TranslateTrait
 * @package Nip\I18n\Translator\Traits
 */
trait TranslateTrait
{
    /**
     * {@inheritdoc}
     */
    public function trans($id, array $parameters = [], $domain = null, $locale = null)
    {
        if (empty($domain)) {
            $domain = MessageCatalogueInterface::DEFAULT_DOMAIN;
        }
        $message = $this->getCatalogue($locale)->get((string)$id, $domain);
        return $this->getFormatter()->format($message, $locale, $parameters);
    }

    /**
     * @param $id
     * @param null $domain
     * @param null $locale
     * @return mixed
     */
    public function hasTrans($id, $domain = null, $locale = null)
    {
        if (null === $domain) {
            $domain = MessageCatalogueInterface::DEFAULT_DOMAIN;
        }

        return $this->getCatalogue($locale)->has((string)$id, $domain);
    }

    /**
     * {@inheritdoc}
     */
    public function transChoice($id, $number, array $parameters = [], $domain = null, $locale = null)
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

    /**
     * Returns translation of $slug in given or selected $language
     *
     * @param string|boolean $slug
     * @param array $params
     * @param string|boolean $language
     * @return string
     * @deprecated Use new trans() method
     */
    public function translate($slug = false, $params = [], $language = null)
    {
        return $this->trans($slug, $params, null, $language);
    }

    /**
     * Returns translation of $slug in given or selected $language
     *
     * @param bool|string $slug
     * @param bool|string $language
     * @return boolean
     * @deprecated Use new hasTrans() method
     */
    public function hasTranslation($slug = false, $language = null)
    {
        return $this->hasTrans($slug, null, $language);
    }
}
