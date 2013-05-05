<?php

namespace Jfsimon\Datagrid\Tests\Acceptance\Data;

use Jfsimon\Datagrid\Infra\Factory\Factory;
use Jfsimon\Datagrid\Model\Actions;
use Jfsimon\Datagrid\Model\Data\Collection;
use Jfsimon\Datagrid\Model\Schema;
use Jfsimon\Datagrid\Tests\Acceptance\AcceptanceTest;
use Jfsimon\Datagrid\Tests\Acceptance\ArrayDataProvider;

class ActionsTest extends AcceptanceTest
{
    public function testWhenISetupActionsIGetLinksInTable()
    {
        $collection = new Collection(ArrayDataProvider::getQuarksData());
        $schema = ArrayDataProvider::buildQuarksSchema(new Schema());

        $actions = Actions::create()
            ->addGlobalAction('Create', '/quarks/create')
            ->addEntityAction('Read', '/quarks/read/{id}')
            ->addEntityAction('Update', '/quarks/update/{id}')
            ->addEntityAction('Delete', '/quarks/delete/{id}')
        ;

        $grid = $this->getFactory()->createGrid($collection, array('schema' => $schema, 'actions' => $actions));
        $html = $this->getTwig()->render('{{ datagrid(grid) }}', array('grid' => $grid));

        $this->assertFixtureEquals(__DIR__.'/quarks.html', $html);
    }

    private function getFactory()
    {
        return new Factory();
    }
}
