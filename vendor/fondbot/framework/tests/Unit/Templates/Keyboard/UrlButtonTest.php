<?php

declare(strict_types=1);

namespace FondBot\Tests\Unit\Templates\Keyboard;

use FondBot\Tests\TestCase;
use FondBot\Templates\Keyboard\UrlButton;

class UrlButtonTest extends TestCase
{
    public function test()
    {
        $label = $this->faker()->word;
        $url = $this->faker()->url;
        $parameters = ['foo' => 'bar'];

        $button = (new UrlButton)
            ->setLabel($label)
            ->setUrl($url)
            ->setParameters($parameters);

        $this->assertSame('UrlButton', $button->getName());
        $this->assertSame($label, $button->getLabel());
        $this->assertSame($url, $button->getUrl());
        $this->assertSame($parameters, $button->getParameters());
    }
}
