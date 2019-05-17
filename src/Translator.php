<?php

namespace Nip\I18n;

use Nip\I18n\Translator\Backend\AbstractBackend;
use Nip\I18n\Translator\Traits\HasCataloguesTrait;
use Nip\I18n\Translator\Traits\HasFormatterTrait;
use Nip\I18n\Translator\Traits\HasLoaderTrait;
use Nip\I18n\Translator\Traits\HasLocaleTrait;
use Nip\I18n\Translator\Traits\HasRequestTrait;
use Nip\I18n\Translator\Traits\HasResourcesTrait;
use Nip\I18n\Translator\Traits\LegacyCodeTrait;
use Nip\I18n\Translator\Traits\TranslateTrait;
use function Nip\url;

/**
 * Class Translator
 * @package Nip\I18n
 */
class Translator
{
    use HasLoaderTrait, HasCataloguesTrait, HasLocaleTrait;
    use HasResourcesTrait, HasRequestTrait, TranslateTrait, HasFormatterTrait;
    use LegacyCodeTrait;

    /**
     * @var array
     */
    protected $languageCodes = [
        'en' => 'en_US',
    ];

    /**
     * Translator constructor.
     * @param string|null $locale
     */
    public function __construct(?string $locale = null)
    {
        if ($locale) {
            $this->setLocale($locale);
        }
    }


    /**
     * @param $lang
     * @return string
     */
    public function changeLangURL($lang)
    {
        $newURL = str_replace('language=' . $this->getLocale(), '', url()->current());
        $newURL = $newURL . (strpos($newURL, '?') == false ? '?' : '&') . 'language=' . $lang;

        return $newURL;
    }
}
