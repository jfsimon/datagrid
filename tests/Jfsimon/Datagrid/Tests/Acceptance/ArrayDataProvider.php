<?php

namespace Jfsimon\Datagrid\Tests\Acceptance;

use Jfsimon\Datagrid\Model\Schema;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class ArrayDataProvider
{
    public static function getQuarksData()
    {
        return array(
            array('id' => 1, 'name' => 'Up',      'generation' => 'first',  'charge' => '+2/3', 'antiparticle' => 'Antiup'),
            array('id' => 2, 'name' => 'Down',    'generation' => 'first',  'charge' => '-1/3', 'antiparticle' => 'Antidown'),
            array('id' => 3, 'name' => 'Charm',   'generation' => 'second', 'charge' => '+2/3', 'antiparticle' => 'Anticharm'),
            array('id' => 4, 'name' => 'Strange', 'generation' => 'second', 'charge' => '-1/3', 'antiparticle' => 'Antistrange'),
            array('id' => 5, 'name' => 'Top',     'generation' => 'third',  'charge' => '+2/3', 'antiparticle' => 'Antitop'),
            array('id' => 6, 'name' => 'Bottom',  'generation' => 'third',  'charge' => '-1/3', 'antiparticle' => 'Antibottom'),
        );
    }

    public static function buildQuarksSchema(Schema $schema)
    {
        return $schema
            ->add('name', 'string')
            ->add('generation', 'string')
            ->add('charge', 'string')
            ->add('antiparticle', 'string')
        ;
    }
}
