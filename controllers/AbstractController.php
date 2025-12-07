<?php

abstract class AbstractController
{

    public function render(string $template, array $data): void
    {
        require 'templates/layout.phtml';
    }
}