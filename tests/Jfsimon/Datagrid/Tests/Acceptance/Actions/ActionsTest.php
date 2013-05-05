<?php

namespace Jfsimon\Datagrid\Tests\Acceptance\Data;

use Jfsimon\Datagrid\Infra\Factory\Factory;
use Jfsimon\Datagrid\Model\Actions;
use Jfsimon\Datagrid\Model\Data\Collection;
use Jfsimon\Datagrid\Model\Schema;
use Jfsimon\Datagrid\Tests\Acceptance\AcceptanceTest;
use Jfsimon\Datagrid\Tests\Acceptance\ArrayDataProvider;
use Symfony\Bridge\Twig\Extension\TranslationExtension;

class ActionsTest extends AcceptanceTest
{
    public function testWhenISetupActionsIGetLinksInTable()
    {
        $collection = new Collection(ArrayDataProvider::getQuarksData());
        $schema = ArrayDataProvider::getQuarksSchema();

        $actions = Actions::create()
            ->addGlobalAction('create', '/quarks/create')
            ->addEntityAction('read', '/quarks/read/{id}')
            ->addEntityAction('update', '/quarks/update/{id}')
            ->addEntityAction('delete', '/quarks/delete/{id}')
        ;

        $grid = $this->getFactory()->createGrid($collection, array('schema' => $schema, 'actions' => $actions));
        $html = $this->getTwig()->render('{{ datagrid(grid) }}', array('grid' => $grid));

        $this->assertFixtureEquals(__DIR__.'/quarks.html', $html);
    }

    public function testWhenISetupTranslationIGetTranslatedActionLabels()
    {
        $collection = new Collection(ArrayDataProvider::getBeatlesData());
        $schema = ArrayDataProvider::getBeatlesSchema();

        $actions = Actions::create()
            ->addGlobalAction('create', '/beatles/create')
            ->addEntityAction('read', '/beatles/read/{slug}')
            ->addEntityAction('update', '/beatles/update/{slug}')
            ->addEntityAction('delete', '/beatles/delete/{slug}')
        ;

        $grid = $this->getFactory()->createGrid($collection, array(
            'schema'        => $schema,
            'actions'       => $actions,
            'name'          => 'beatles',
            'actions_trans' => true,
        ));
        $html = $this
            ->getTwig('trans.html.twig', array(new TranslationExtension($this->getTranslator(__DIR__))))
            ->render('{{ datagrid(grid) }}', array('grid' => $grid));

        $this->assertFixtureEquals(__DIR__.'/beatles.html', $html);
    }

    private function getFactory()
    {
        return new Factory();
    }
}
