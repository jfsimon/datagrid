<?php

namespace Jfsimon\Datagrid\Tests\Acceptance\Data;

use Jfsimon\Datagrid\Infra\Factory\Factory;
use Jfsimon\Datagrid\Model\Actions;
use Jfsimon\Datagrid\Model\Data\Collection;
use Jfsimon\Datagrid\Model\Schema;
use Jfsimon\Datagrid\Model\Trans;
use Jfsimon\Datagrid\Tests\Acceptance\AcceptanceTest;
use Jfsimon\Datagrid\Tests\Acceptance\ArrayDataProvider;
use Symfony\Bridge\Twig\Extension\RoutingExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;

class ActionsTest extends AcceptanceTest
{
    public function testWhenISetupActionsIGetLinksInTable()
    {
        $collection = new Collection(ArrayDataProvider::getQuarksData());
        $schema = ArrayDataProvider::getQuarksSchema();

        $actions = Actions::enable()
            ->addGlobalUrl('create', '/quarks/create')
            ->addEntityUrl('read', '/quarks/read/{id}')
            ->addEntityUrl('update', '/quarks/update/{id}')
            ->addEntityUrl('delete', '/quarks/delete/{id}')
        ;

        $grid = $this->getFactory()->createGrid($collection, array('schema' => $schema, 'actions' => $actions));
        $html = $this->getTwig()->render('{{ datagrid(grid) }}', array('grid' => $grid));

        $this->assertFixtureEquals(__DIR__.'/quarks.html', $html);
    }

    public function testWhenISetupTranslationIGetTranslatedActionLabels()
    {
        $collection = new Collection(ArrayDataProvider::getBeatlesData());
        $schema = ArrayDataProvider::getBeatlesSchema();

        $actions = Actions::enable()
            ->addGlobalUrl('create', '/beatles/create')
            ->addEntityUrl('read', '/beatles/read/{slug}')
            ->addEntityUrl('update', '/beatles/update/{slug}')
            ->addEntityUrl('delete', '/beatles/delete/{slug}')
        ;

        $grid = $this->getFactory()->createGrid($collection, array(
            'schema'        => $schema,
            'actions'       => $actions,
            'name'          => 'beatles',
            'actions_trans' => Trans::enable(),
        ));
        $html = $this
            ->getTwig('trans.html.twig', array(new TranslationExtension($this->getTranslator(__DIR__))))
            ->render('{{ datagrid(grid) }}', array('grid' => $grid));

        $this->assertFixtureEquals(__DIR__.'/beatles.html', $html);
    }

    public function testWhenISetupRouteActionsIGetRouteLinksInTable()
    {
        $collection = new Collection(ArrayDataProvider::getQuarksData());
        $schema = ArrayDataProvider::getQuarksSchema();

        $actions = Actions::enable()
            ->addGlobalRoute('create', 'quarks_create')
            ->addEntityRoute('read', 'quarks_read', array('id' => 'id'))
            ->addEntityRoute('update', 'quarks_update', array('id' => 'id'))
            ->addEntityRoute('delete', 'quarks_delete', array('id' => 'id'))
        ;

        $grid = $this->getFactory()->createGrid($collection, array('schema' => $schema, 'actions' => $actions));
        $html = $this
            ->getTwig('router.html.twig', array(new RoutingExtension($this->getRouter(__DIR__, 'routing.yml'))))
            ->render('{{ datagrid(grid) }}', array('grid' => $grid));

        $this->assertFixtureEquals(__DIR__.'/quarks.html', $html);
    }

    private function getFactory()
    {
        return new Factory();
    }
}
