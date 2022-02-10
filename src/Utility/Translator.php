<?php

namespace Nip\I18n\Utility;

use Nip\Container\Utility\Container;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 *
 */
class Translator
{
    public static function instance(): ?TranslatorInterface
    {
        static $instance = false;
        if ($instance === false) {
            try {
                $instance = Container::get('translator');
            } catch (\Exception $e) {
                $instance = null;
            }
        }
        return $instance;
    }

    public static function trans()
    {

    }
}
