<?php

namespace Jfsimon\Datagrid\Tests\Acceptance\Data;

use Jfsimon\Datagrid\Infra\Factory\Factory;
use Jfsimon\Datagrid\Model\Data\Collection;
use Jfsimon\Datagrid\Model\Schema;
use Jfsimon\Datagrid\Model\Trans;
use Jfsimon\Datagrid\Tests\Acceptance\AcceptanceTest;
use Jfsimon\Datagrid\Tests\Acceptance\ArrayDataProvider;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Translator;

class LabelTest extends AcceptanceTest
{
    public function testWhenIRenderGridIGetLabels()
    {
        $collection = new Collection(ArrayDataProvider::getQuarksData());
        $schema = ArrayDataProvider::getQuarksSchema();

        $grid = $this->getFactory()->createGrid($collection, array('schema' => $schema));
        $html = $this->getTwig()->render('{{ datagrid(grid) }}', array('grid' => $grid));

        $this->assertFixtureEquals(__DIR__.'/quarks.html', $html);
    }

    public function testWhenICustomizeLabelsIGetCustomLabels()
    {
        $collection = new Collection(ArrayDataProvider::getBeatlesData());
        $schema = ArrayDataProvider::getBeatlesSchema()
            ->setOptions('name', array('label' => 'Member name'))
            ->setOptions('alive', array('label' => 'Is still alive?'))
        ;

        $grid = $this->getFactory()->createGrid($collection, array('schema' => $schema));
        $html = $this->getTwig()->render('{{ datagrid(grid) }}', array('grid' => $grid));

        $this->assertFixtureEquals(__DIR__.'/beatles.html', $html);
    }

    public function testWhenISetupTranslationIGetTranslatedLabels()
    {
        $collection = new Collection(ArrayDataProvider::getBeatlesData());
        $schema = ArrayDataProvider::getBeatlesSchema();

        $grid = $this->getFactory()->createGrid($collection, array(
            'schema'      => $schema,
            'name'        => 'beatles',
            'label_trans' => Trans::enable(),
        ));
        $html = $this
            ->getTwig('trans.html.twig', array(new TranslationExtension($this->getTranslator(__DIR__))))
            ->render('{{ datagrid(grid) }}', array('grid' => $grid));

        $this->assertFixtureEquals(__DIR__.'/beatles.html', $html);
    }

    private function getFactory()
    {
        $factory = new Factory();

        return $factory->removeExtension('actions');
    }
}
