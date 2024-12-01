<?php

declare(strict_types=1);

namespace Html;

class AppWebPage extends WebPage
{
    public function __construct(string $title="")
    {
        parent::__construct($title);
        parent::appendCssUrl("/css/style.css");
    }

    public function toHTML(): String
    {
        $this->body="<div class='header'><h1>{$this->title}</h1></div>".$this->body;
        return parent::toHTML();
    }
}
