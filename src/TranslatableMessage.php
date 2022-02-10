<?php

namespace Nip\I18n;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 *
 */
class TranslatableMessage implements \Stringable
{
    private string $message;
    private array $parameters;
    private ?string $domain;

    public function __construct(string $message, array $parameters = [], string $domain = null)
    {
        $this->message = $message;
        $this->parameters = $parameters;
        $this->domain = $domain;
    }

    public static function create(string $message, array $parameters = [], string $domain = null): self
    {
        return new self($message, $parameters, $domain);
    }

    public function __toString(): string
    {
        $translator = \Nip\I18n\Utility\Translator::instance();

        return $translator
            ? $this->trans($translator)
            : $this->getMessage();
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function trans(TranslatorInterface $translator, string $locale = null): string
    {
        return $translator->trans($this->getMessage(), array_map(
            static function ($parameter) use ($translator, $locale) {
                return $parameter instanceof TranslatableInterface ? $parameter->trans($translator,
                    $locale) : $parameter;
            },
            $this->getParameters()
        ), $this->getDomain(), $locale);
    }
}