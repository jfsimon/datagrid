<?php

namespace Jfsimon\Datagrid\Tests\Infra\Factory;

use Jfsimon\Datagrid\Infra\Extension\AbstractExtension;

class NamedExtension extends AbstractExtension
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
