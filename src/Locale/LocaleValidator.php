<?php

namespace Nip\I18n\Locale;

use Nip\I18n\Exception\InvalidArgumentException;

/**
 * Class LocaleValidator
 * @package Nip\I18n\Locale
 */
class LocaleValidator
{

    /**
     * Asserts that the locale is valid, throws an Exception if not.
     *
     * @param string $locale Locale to tests
     *
     * @throws InvalidArgumentException If the locale contains invalid characters
     */
    public static function assertValidLocale($locale)
    {
        if (1 !== preg_match('/^[a-z0-9@_\\.\\-]*$/i', $locale)) {
            throw new InvalidArgumentException(sprintf('Invalid "%s" locale.', $locale));
        }
    }
}
