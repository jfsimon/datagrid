<?php

namespace Jfsimon\Datagrid\Tests\Acceptance\Data;

use Jfsimon\Datagrid\Infra\Factory\Factory;
use Jfsimon\Datagrid\Model\Data\Collection;
use Jfsimon\Datagrid\Model\Schema;
use Jfsimon\Datagrid\Tests\Acceptance\AcceptanceTest;
use Jfsimon\Datagrid\Tests\Acceptance\ArrayDataProvider;

class LabelTest extends AcceptanceTest
{
    public function testWhenIRenderGridIGetLabels()
    {
        $collection = new Collection(ArrayDataProvider::getQuarksData());
        $schema = ArrayDataProvider::buildQuarksSchema(new Schema());

        $grid = $this->getFactory()->createGrid($collection, array('schema' => $schema));
        $html = $this->getTwig()->render('{{ datagrid(grid) }}', array('grid' => $grid));

        $this->assertFixtureEquals(__DIR__.'/quarks.html', $html);
    }

    public function testWhenICustomizeLabelsIGetCustomLabels()
    {
        $collection = new Collection(ArrayDataProvider::getBeatlesData());
        $schema = ArrayDataProvider::buildBeatlesSchema(new Schema())
            ->setOptions('name', array('label' => 'Member name'))
            ->setOptions('alive', array('label' => 'Is still alive?'))
        ;

        $grid = $this->getFactory()->createGrid($collection, array('schema' => $schema));
        $html = $this->getTwig()->render('{{ datagrid(grid) }}', array('grid' => $grid));

        $this->assertFixtureEquals(__DIR__.'/beatles.html', $html);
    }

    private function getFactory()
    {
        $factory = new Factory();

        return $factory->removeExtension('actions');
    }
}
