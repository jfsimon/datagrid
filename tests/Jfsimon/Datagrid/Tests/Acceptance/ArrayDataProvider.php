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

    public static function getQuarksSchema()
    {
        return Schema::create()
            ->add('name', 'string')
            ->add('generation', 'string')
            ->add('charge', 'string')
            ->add('antiparticle', 'string')
        ;
    }

    public static function getBeatlesData()
    {
        return array(
            array('slug' => 'john',    'name' => 'John Lenon',       'birthday' => new \DateTime('1940-10-09'), 'alive' => false),
            array('slug' => 'paul',    'name' => 'Paul McCartney',   'birthday' => new \DateTime('1942-06-18'), 'alive' => true),
            array('slug' => 'georges', 'name' => 'Georges Harrison', 'birthday' => new \DateTime('1943-02-25'), 'alive' => false),
            array('slug' => 'ringo',   'name' => 'Ringo Starr',      'birthday' => new \DateTime('1940-07-07'), 'alive' => true),
        );
    }

    public static function getBeatlesSchema()
    {
        return Schema::create()
            ->add('name', 'string')
            ->add('birthday', 'datetime', array('time_format' => \IntlDateFormatter::NONE))
            ->add('alive', 'boolean', array('true_value' => 'yes :)', 'false_value' => 'no :('))
        ;
    }
}
