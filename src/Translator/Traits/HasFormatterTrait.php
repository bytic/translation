<?php

namespace Nip\I18n\Translator\Traits;

use Nip\I18n\Message\Formatter\MessageFormatter;
use Nip\I18n\Message\Formatter\MessageFormatterInterface;

/**
 * Trait HasFormatterTrait
 * @package Nip\I18n\Translator\Traits
 */
trait HasFormatterTrait
{
    /**
     * @var MessageFormatterInterface
     */
    protected $formatter = null;

    /**
     * @return MessageFormatterInterface
     */
    public function getFormatter(): MessageFormatterInterface
    {
        $this->checkInitFormatter();
        return $this->formatter;
    }

    /**
     * @param MessageFormatterInterface $formatter
     */
    public function setFormatter(MessageFormatterInterface $formatter): void
    {
        $this->formatter = $formatter;
    }

    protected function checkInitFormatter()
    {
        if (!$this->hasFormatter()) {
            $this->setFormatter($this->generateFormatter());
        }
    }

    /**
     * @return bool
     */
    protected function hasFormatter()
    {
        return $this->formatter instanceof MessageFormatterInterface;
    }

    /**
     * @return MessageFormatter
     */
    protected function generateFormatter()
    {
        return new MessageFormatter();
    }
}