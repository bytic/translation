<?php

namespace Nip\I18n\Middleware;

use Nip\I18n\Translator;
use Nip\Locale\Detector\Detector;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class LocalizationMiddleware
 * @package Nip\I18n\Middleware
 *
 * Inspired by https://github.com/tboronczyk/localization-middleware/blob/master/src/LocalizationMiddleware.php
 */
class LocalizationMiddleware implements MiddlewareInterface
{
    protected $translator;

    /**
     * LocalizationMiddleware constructor.
     * @param null $translator
     */
    public function __construct($translator = null)
    {
        $this->setTranslator($translator);
    }

    /**
     * @inheritdoc
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->detect($request);
        return $handler->handle($request);
    }

    public function detect(ServerRequestInterface $request)
    {
        $detected = Detector::detect($request, $this->translator);
        if ($detected) {
            /** @noinspection PhpUndefinedMethodInspection */
            $request->setLocale($detected);
            if ($this->hasTranslator()) {
                $this->getTranslator()->setLocale($detected);
            }
        }
    }

    /**
     * @return Translator
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * @param Translator $translator
     */
    public function setTranslator($translator): void
    {
        $this->translator = $translator;
    }

    /**
     * @return bool
     */
    public function hasTranslator()
    {
        return $this->getTranslator() instanceof Translator;
    }
}
