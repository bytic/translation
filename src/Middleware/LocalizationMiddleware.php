<?php

namespace Nip\I18n\Middleware;

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
    protected $enabledLocale;

    /**
     * LocalizationMiddleware constructor.
     * @param null $enabledLocale
     */
    public function __construct($enabledLocale = null)
    {
        $this->enabledLocale = $enabledLocale;
    }

    /**
     * @inheritdoc
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $detected = Detector::detect($request, $this->enabledLocale);
        if ($detected) {
            /** @noinspection PhpUndefinedMethodInspection */
            $request->setLocale($detected);
        }
        return $handler->handle($request);
    }
}
