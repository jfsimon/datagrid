<?php

namespace Jfsimon\Datagrid\Tests\Acceptance\Data;

use Jfsimon\Datagrid\Infra\Factory\Factory;
use Jfsimon\Datagrid\Model\Data\Collection;
use Jfsimon\Datagrid\Model\Schema;
use Jfsimon\Datagrid\Tests\Acceptance\AcceptanceTest;
use Jfsimon\Datagrid\Tests\Acceptance\ArrayDataProvider;

class DataTest extends AcceptanceTest
{
    public function testWhenIRenderStringsCollectionIGetAnHtmlTableWithStrings()
    {
        $collection = new Collection(ArrayDataProvider::getQuarksData());
        $schema = ArrayDataProvider::getQuarksSchema();

        $grid = $this->getFactory()->createGrid($collection, array('schema' => $schema));
        $html = $this->getTwig()->render('{{ datagrid(grid) }}', array('grid' => $grid));

        $this->assertFixtureEquals(__DIR__.'/quarks.html', $html);
    }

    public function testWhenIRenderMixedDataCollectionIGetAnHtmlTableWithFormattedData()
    {
        $collection = new Collection(ArrayDataProvider::getBeatlesData());
        $schema = ArrayDataProvider::getBeatlesSchema();

        $grid = $this->getFactory()->createGrid($collection, array('schema' => $schema));
        $html = $this->getTwig()->render('{{ datagrid(grid) }}', array('grid' => $grid));

        $this->assertFixtureEquals(__DIR__.'/beatles.html', $html);
    }

    private function getFactory()
    {
        $factory = new Factory();

        return $factory
            ->removeExtension('label')
            ->removeExtension('actions')
        ;
    }
}
