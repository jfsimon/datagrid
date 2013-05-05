<?php

namespace Jfsimon\Datagrid\Tests\Infra\Handler;

use Jfsimon\Datagrid\Infra\Renderer\TwigRenderer;

class TwigRendererTest extends \PHPUnit_Framework_TestCase
{
    public function testTwigNotDefined()
    {
        $renderer = new TwigRenderer('');

        $this->setExpectedException('Jfsimon\Datagrid\Exception\WorkflowException');
        $renderer->render(array(), array());
    }

    public function testTemplateNotFound()
    {
        $renderer = new TwigRenderer('');
        $renderer->setTwigEnvironment(new \Twig_Environment());

        $this->setExpectedException('Jfsimon\Datagrid\Exception\TemplateException');
        $renderer->render(array(), array());
    }

    public function testBlockNotFound()
    {
        $renderer = new TwigRenderer('template.html.twig');
        $renderer->setTwigEnvironment(new \Twig_Environment(new \Twig_Loader_Filesystem(__DIR__)));

        $this->setExpectedException('Jfsimon\Datagrid\Exception\TemplateException');
        $renderer->render(array('unknown'), array());
    }
}
