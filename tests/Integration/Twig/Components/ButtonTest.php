<?php

namespace App\Tests\Integration\Twig\Components;

use App\Twig\Components\Button;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\UX\TwigComponent\Test\InteractsWithTwigComponents;

class ButtonTest extends KernelTestCase
{
    use InteractsWithTwigComponents;

    public function testButtonRendersWithVariants()
    {
        $component = $this->mountTwigComponent('Button', [
            'variant' => 'success',
        ]);
        $this->assertInstanceOf(Button::class, $component);
        $this->assertSame('success', $component->variant);

        $rendered = $this->renderTwigComponent('Button', [
            'variant' => 'success',
        ], '<span>Click me!</span>');
        $this->assertSame('Click me!', $rendered->crawler()->filter('span')->text());
    }
}
