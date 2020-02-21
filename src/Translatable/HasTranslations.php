<?php

namespace Nip\I18n\Translatable;

/**
 * Trait HasTranslations
 * @package Nip\I18n\Translatable
 */
trait HasTranslations
{
    use HasTranslator;

    /**
     * @param $slug
     * @param array $params
     * @param bool $language
     * @return string
     */
    public function translate($slug, $params = [], $language = false)
    {
        $slug = $this->getTranslateRoot() . '.' . $slug;

        return $this->getTranslator()->trans($slug, $params, $language);
    }

    /**
     * @param $type
     * @param array $params
     * @param bool $language
     * @return string
     */
    public function getLabel($type, $params = [], $language = false)
    {
        $slug = 'labels.' . $type;

        return $this->translate($slug, $params, $language);
    }

    /**
     * @param $name
     * @param array $params
     * @param bool $language
     * @return string
     */
    public function getMessage($name, $params = [], $language = false)
    {
        $slug = 'messages.' . $name;

        return $this->translate($slug, $params, $language);
    }

    abstract protected function getTranslateRoot();
}
