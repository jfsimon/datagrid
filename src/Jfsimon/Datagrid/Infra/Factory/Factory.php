<?php

namespace Jfsimon\Datagrid\Infra\Factory;

use Jfsimon\Datagrid\Exception\ConfigurationException;
use Jfsimon\Datagrid\Infra\Extension\CoreExtension;
use Jfsimon\Datagrid\Infra\Extension\DataExtension;
use Jfsimon\Datagrid\Infra\Extension\LabelExtension;
use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Model\Component\Grid;
use Jfsimon\Datagrid\Model\Data\Collection;
use Jfsimon\Datagrid\Service\ExtensionInterface;
use Jfsimon\Datagrid\Service\FactoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
        $this
            ->register(new CoreExtension())
            ->register(new DataExtension())
            ->register(new LabelExtension())
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function register(ExtensionInterface $extension)
    {
        // todo: maybe add a priority system
        $this->extensions[$extension->getName()] = $extension;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function createGrid(Collection $collection, array $options = array())
    {
        $resolver = new OptionsResolver();
        foreach ($this->extensions as $extension) {
            $extension->configure($resolver);
        }
        $options = $resolver->resolve($options);

        $schema = null;
        foreach ($this->extensions as $extension) {
            $schema = $extension->guessSchema($collection->getPeek(), $options);
            if (null !== $schema) {
                break;
            }
        }
        if (null === $schema) {
            throw ConfigurationException::schemaNotFound(array_keys($this->extensions));
        }

        $grid = new Grid();
        $schema->bind($this, $grid);

        foreach ($this->extensions as $extension) {
            $extension->buildSchema($schema, $collection, $options);
        }

        foreach ($this->extensions as $extension) {
            $extension->buildGrid($grid, $schema, $collection, $options);
        }

        foreach ($this->extensions as $extension) {
            $extension->visit($grid, $options);
        }

        return $grid;
    }

    /**
     * {@inheritdoc}
     */
    public function createColumn($type, array $options = array(), array $columnOptions = array())
    {
        $column = new Column();
        foreach ($this->extensions as $extension) {
            $extension->buildColumn($column, $type, $options);
        }

        return $column->configure($columnOptions);
    }
}
