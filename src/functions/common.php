<?php

use Nip\Utility\Container;

if (!function_exists('translator')) {
    /**
     * @return \Nip\I18n\Translator
     */
    function translator()
    {
        return Container::get('translator');
    }
}
