<?php

namespace Nip\I18n\Message\Formatter;

use Nip\I18n\Message\MessageSelector;

/**
 * @author Abdellatif Ait boudad <a.aitboudad@gmail.com>
 */
class MessageFormatter implements MessageFormatterInterface, ChoiceMessageFormatterInterface
{
    protected $selector;

    protected $variableFormat = '#{%s}';

    /**
     * @param MessageSelector $selector The message selector for pluralization
     */
    public function __construct(MessageSelector $selector = null)
    {
        $this->selector = $selector ?: new MessageSelector();
    }

    /**
     * {@inheritdoc}
     */
    public function format($message, $locale, array $parameters = [])
    {
        $parameters = $this->formatParameters($parameters);
        return $this->replaceParameters($message, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function choiceFormat($message, $number, $locale, array $parameters = [])
    {
        $parameters = array_merge(['%count%' => $number], $parameters);

        return $this->format(
            $this->selector->choose($message, (int)$number, $locale),
            $locale,
            $parameters
        );
    }

    protected function formatParameters($parameters)
    {
        $return = [];
        foreach ($parameters as $key => $value) {
            $key = sprintf($this->variableFormat, $key);
            $return[$key] = $value;
        }
        return $return;
    }

    protected function replaceParameters($message, array $parameters = [])
    {
        return strtr($message, $parameters);
    }
}
