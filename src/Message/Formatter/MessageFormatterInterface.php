<?php

namespace Nip\I18n\Message\Formatter;

/**
 * Interface MessageFormatterInterface
 * @package Nip\I18n\Message\Formatter
 */
interface MessageFormatterInterface
{
    /**
     * Formats a localized message pattern with given arguments.
     *
     * @param string $message    The message (may also be an object that can be cast to string)
     * @param string $locale     The message locale
     * @param array  $parameters An array of parameters for the message
     *
     * @return string
     */
    public function format($message, $locale, array $parameters = []);
}
