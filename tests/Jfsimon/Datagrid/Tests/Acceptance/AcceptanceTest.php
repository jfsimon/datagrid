<?php

namespace Jfsimon\Datagrid\Tests\Acceptance;

use Jfsimon\Datagrid\Bridge\Twig\Extension\DatagridExtension;
use Jfsimon\Datagrid\Infra\Factory\Factory;
use Jfsimon\Datagrid\Infra\Renderer\TwigRenderer;
use Jfsimon\Datagrid\Model\Data\Collection;
use Jfsimon\Datagrid\Model\Schema;

class AcceptanceTest extends \PHPUnit_Framework_TestCase
{
    public function testICanRenderACollectionOfStringsAsHtmlTable()
    {
        $quarks = array(
            array('name' => 'Up',      'generation' => 'first',  'charge' => '+2/3', 'antiparticle' => 'Antiup'),
            array('name' => 'Down',    'generation' => 'first',  'charge' => '-1/3', 'antiparticle' => 'Antidown'),
            array('name' => 'Charm',   'generation' => 'second', 'charge' => '+2/3', 'antiparticle' => 'Anticharm'),
            array('name' => 'Strange', 'generation' => 'second', 'charge' => '-1/3', 'antiparticle' => 'Antistrange'),
            array('name' => 'Top',     'generation' => 'third',  'charge' => '+2/3', 'antiparticle' => 'Antitop'),
            array('name' => 'Bottom',  'generation' => 'third',  'charge' => '-1/3', 'antiparticle' => 'Antibottom'),
        );

        $schema = new Schema();
        $schema
            ->add('name', 'string')
            ->add('generation', 'string')
            ->add('charge', 'string')
            ->add('antiparticle', 'string')
        ;

        $factory = new Factory();
        $html = $factory
            ->createGrid(new Collection($quarks), array('schema' => $schema))
            ->render(new TwigRenderer($this->getTwig(), 'default.html.twig'));

        $this->assertEquals(trim(file_get_contents(__DIR__.'/Fixtures/quarks.html')), $html);
    }

    private function getTwig()
    {
        $loader = new \Twig_Loader_Filesystem(realpath(__DIR__.'/../../../../../src/Jfsimon/Datagrid/Bridge/Twig/Resources'));
        $twig = new \Twig_Environment($loader);
        $twig->addExtension(new DatagridExtension('default.html.twig'));

        return $twig;
    }
}
