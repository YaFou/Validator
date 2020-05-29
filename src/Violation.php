<?php

namespace YaFou\Validator;

class Violation
{
    private $template;
    private $message;

    public function __construct(string $template, array $variables = [])
    {
        $message = $this->template = $template;

        foreach($variables as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->message = $message;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
