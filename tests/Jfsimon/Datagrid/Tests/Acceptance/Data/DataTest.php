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
        $schema = ArrayDataProvider::buildQuarksSchema(new Schema());

        $grid = $this->getFactory()->createGrid($collection, array('schema' => $schema));
        $html = $this->getTwig()->render('{{ datagrid(grid) }}', array('grid' => $grid));

        $this->assertFixtureEquals(__DIR__.'/quarks.html', $html);
    }

//    todo: add actions extension & model
//    public function testICanRenderACollectionOfStringsAsHtmlTableWithActions()
//    {
//        $factory = new Factory();
//        $actions = new Actions();
//        $actions
//            ->addGlobal('Create', '/quarks/create')
//            ->addEntity('Read', '/quarks/read/{id}')
//            ->addEntity('Update', '/quarks/update/{id}')
//            ->addEntity('Delete', '/quarks/delete/{id}')
//        ;
//        $grid = $factory->createGrid(new Collection(self::$quarks), array('schema' => $this->getSchema(), 'actions' => $actions));
//        $html = $this->getTwig()->render('{{ datagrid(grid) }}', array('grid' => $grid));
//
//        $this->assertFixtureEquals('quarks.html', $html);
//    }

    private function getFactory()
    {
        $factory = new Factory();

        return $factory
            ->removeExtension('label')
            ->removeExtension('actions')
        ;
    }
}
