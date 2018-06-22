<?php

namespace Nip\I18n\Message\Catalogue\Traits;

use Nip\I18n\Message\Catalogue\MessageCatalogueInterface;

/**
 * Trait HasMessagesTrait
 * @package Nip\I18n\Message\Catalogue\Traits
 */
trait HasMessagesTrait
{
    protected $messages = [];

    /**
     * {@inheritdoc}
     */
    public function all($domain = null)
    {
        if (null === $domain) {
            return $this->messages;
        }
        return isset($this->messages[$domain]) ? $this->messages[$domain] : [];
    }

    /**
     * {@inheritdoc}
     */
    public function set($id, $translation, $domain = MessageCatalogueInterface::DEFAULT_DOMAIN)
    {
        $this->add([$id => $translation], $domain);
    }

    /**
     * {@inheritdoc}
     */
    public function has($id, $domain = MessageCatalogueInterface::DEFAULT_DOMAIN)
    {
        if (isset($this->messages[$domain][$id])) {
            return true;
        }
        if (null !== $this->fallbackCatalogue) {
            return $this->fallbackCatalogue->has($id, $domain);
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function defines($id, $domain = MessageCatalogueInterface::DEFAULT_DOMAIN)
    {
        return isset($this->messages[$domain][$id]);
    }

    /**
     * {@inheritdoc}
     */
    public function get($id, $domain = MessageCatalogueInterface::DEFAULT_DOMAIN)
    {
        if (isset($this->messages[$domain][$id])) {
            return $this->messages[$domain][$id];
        }

        if (null !== $this->fallbackCatalogue) {
            return $this->fallbackCatalogue->get($id, $domain);
        }
        return $id;
    }

    /**
     * {@inheritdoc}
     */
    public function replace($messages, $domain = MessageCatalogueInterface::DEFAULT_DOMAIN)
    {
        $this->messages[$domain] = [];
        $this->add($messages, $domain);
    }

    /**
     * {@inheritdoc}
     */
    public function add($messages, $domain = MessageCatalogueInterface::DEFAULT_DOMAIN)
    {
        if (!isset($this->messages[$domain])) {
            $this->messages[$domain] = $messages;
        } else {
            $this->messages[$domain] = array_replace($this->messages[$domain], $messages);
        }
    }

    /**
     * @param array $messages
     */
    public function setMessages(array $messages): void
    {
        $this->messages = $messages;
    }
}
