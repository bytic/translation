<?php

namespace Nip\I18n\Loader;

use Nip\I18n\Catalogue\MessageCatalogue;
use Nip\I18n\Catalogue\MessageCatalogueInterface;

class ArrayLoader implements LoaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function load($resource, $locale, $domain = MessageCatalogueInterface::DEFAULT_DOMAIN)
    {
        $this->flatten($resource);
        $catalogue = new MessageCatalogue($locale);
        $catalogue->add($resource, $domain);
        return $catalogue;
    }

    /**
     * Flattens an nested array of translations.
     *
     * The scheme used is:
     *   'key' => array('key2' => array('key3' => 'value'))
     * Becomes:
     *   'key.key2.key3' => 'value'
     *
     * This function takes an array by reference and will modify it
     *
     * @param array &$messages The array that will be flattened
     * @param array $subnode Current subnode being parsed, used internally for recursive calls
     * @param string $path Current path being parsed, used internally for recursive calls
     */
    private function flatten(array &$messages, array $subnode = null, $path = null)
    {
        if (null === $subnode) {
            $subnode = &$messages;
        }
        foreach ($subnode as $key => $value) {
            if (is_array($value)) {
                $nodePath = $path ? $path . '.' . $key : $key;
                $this->flatten($messages, $value, $nodePath);
                if (null === $path) {
                    unset($messages[$key]);
                }
            } elseif (null !== $path) {
                $messages[$path . '.' . $key] = $value;
            }
        }
    }

}