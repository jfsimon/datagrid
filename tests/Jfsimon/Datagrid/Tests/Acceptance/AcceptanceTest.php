<?php

namespace Jfsimon\Datagrid\Tests\Acceptance;

use Jfsimon\Datagrid\Bridge\Twig\Extension\DatagridExtension;
use Jfsimon\Datagrid\Infra\Renderer\TwigRenderer;

abstract class AcceptanceTest extends \PHPUnit_Framework_TestCase
{
    protected function getTwig()
    {
        $renderer = new TwigRenderer('default.html.twig');
        $loader = new \Twig_Loader_Chain(array(
            new \Twig_Loader_Filesystem(realpath(__DIR__.'/../../../../../src/Jfsimon/Datagrid/Bridge/Twig/Resources')),
            new \Twig_Loader_String(),
        ));
        $twig = new \Twig_Environment($loader);
        $twig->addExtension(new DatagridExtension($renderer));

        return $twig;
    }

    protected function assertFixtureEquals($file, $html)
    {
        $expectation = file_get_contents(__DIR__.'/Fixtures/'.$file);
        // generated content is space-less
        $expectation = trim(preg_replace('#>\s*<#', '><', $expectation));

        $this->assertEquals($expectation, $html);
    }
}
