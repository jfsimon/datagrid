<?php

namespace Jfsimon\Datagrid\Tests\Acceptance;

use Jfsimon\Datagrid\Infra\Factory\Factory;
use Jfsimon\Datagrid\Model\Data\Collection;
use Jfsimon\Datagrid\Model\Schema;

class QuarksTest extends AcceptanceTest
{
    protected static $quarks = array(
        array('id' => 1, 'name' => 'Up',      'generation' => 'first',  'charge' => '+2/3', 'antiparticle' => 'Antiup'),
        array('id' => 2, 'name' => 'Down',    'generation' => 'first',  'charge' => '-1/3', 'antiparticle' => 'Antidown'),
        array('id' => 3, 'name' => 'Charm',   'generation' => 'second', 'charge' => '+2/3', 'antiparticle' => 'Anticharm'),
        array('id' => 4, 'name' => 'Strange', 'generation' => 'second', 'charge' => '-1/3', 'antiparticle' => 'Antistrange'),
        array('id' => 5, 'name' => 'Top',     'generation' => 'third',  'charge' => '+2/3', 'antiparticle' => 'Antitop'),
        array('id' => 6, 'name' => 'Bottom',  'generation' => 'third',  'charge' => '-1/3', 'antiparticle' => 'Antibottom'),
    );

    public function testICanRenderACollectionOfStringsAsHtmlTable()
    {
        $factory = new Factory();
        $grid = $factory->createGrid(new Collection(self::$quarks), array('schema' => $this->getSchema()));
        $html = $this->getTwig()->render('{{ datagrid(grid) }}', array('grid' => $grid));

        $this->assertFixtureEquals('quarks.html', $html);
    }

    public function testICanRenderACollectionOfStringsAsHtmlTableWithoutLabels()
    {
        $factory = new Factory();
        $grid = $factory->createGrid(new Collection(self::$quarks), array('schema' => $this->getSchema(), 'label' => false));
        $html = $this->getTwig()->render('{{ datagrid(grid) }}', array('grid' => $grid));

        $this->assertFixtureEquals('quarks_without_labels.html', $html);
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

    private function getSchema()
    {
        $schema = new Schema();
        $schema
            ->add('name', 'string')
            ->add('generation', 'string')
            ->add('charge', 'string')
            ->add('antiparticle', 'string')
        ;

        return $schema;
    }
}
