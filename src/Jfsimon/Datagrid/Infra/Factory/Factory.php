<?php

namespace Jfsimon\Datagrid\Infra\Factory;

use Jfsimon\Datagrid\Infra\Extension\CoreExtension;
use Jfsimon\Datagrid\Model\Schema;
use Jfsimon\Datagrid\Model\Component\Grid;
use Jfsimon\Datagrid\Model\Data\Collection;
use Jfsimon\Datagrid\Service\ExtensionInterface;
use Jfsimon\Datagrid\Service\FactoryInterface;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class Factory implements FactoryInterface
{
    /**
     * @var ExtensionInterface[]
     */
    private $extensions = array();

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->register(new CoreExtension());
    }

    /**
     * {@inheritdoc}
     */
    public function register(ExtensionInterface $extension)
    {
        // todo: extension order may matter
        $this->extensions[] = $extension;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function create(Collection $collection, array $options = array())
    {
        foreach ($this->extensions as $extension) {
            $schema = $extension->guessSchema($collection->getPeek(), $options);

            if (null !== $schema) {
                $options['schema'] = $schema;
            }
        }

        if (!$options['schema'] instanceof Schema) {
            throw new \LogicException('Unable to guess schema.');
        }

        foreach ($this->extensions as $extension) {
            $extension->buildSchema($options['schema'], $collection, $options);
        }

        $grid = new Grid();

        foreach ($this->extensions as $extension) {
            $extension->buildGrid($grid, $collection, $options);
        }

        foreach ($this->extensions as $extension) {
            $extension->visit($grid, $options);
        }

        return $grid;
    }
}
