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
use Nip\Locale\Detector\Pipeline\Stages\QueryStage;
use function Nip\url;

/**
 * Class Translator
 * @package Nip\I18n
 */
class Translator
{
    use HasLoaderTrait;
    use HasCataloguesTrait;
    use HasLocaleTrait;
    use HasResourcesTrait;
    use HasRequestTrait;
    use TranslateTrait;
    use HasFormatterTrait;
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
        $url = function_exists('current_url') ? current_url() : url()->current();
        $queryKeys = QueryStage::QUERY_KEY;
        $queryKey = reset($queryKeys);
        $newURL = str_replace($queryKey . '=' . $this->getLocale(), '', $url);
        $newURL = $newURL . (strpos($newURL, '?') == false ? '?' : '&') . $queryKey . '=' . $lang;

        return $newURL;
    }
}
