<?php

namespace Jfsimon\Datagrid\Infra\Factory;

use Jfsimon\Datagrid\Exception\ConfigurationException;
use Jfsimon\Datagrid\Infra\Extension\ActionsExtension;
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
     * @var array
     */
    private $extensions = array();

    /**
     * @var boolean
     */
    private $sorted = true;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this
            ->register(new CoreExtension(), 100)
            ->register(new DataExtension(), 0)
            ->register(new LabelExtension(), -50)
            ->register(new ActionsExtension(), 50)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function register(ExtensionInterface $extension, $priority = 0)
    {
        $this->sorted = false;
        $this->extensions[$extension->getName()] = array(
            'extension' => $extension,
            'priority'  => $priority,
            'index'     => count($this->extensions),
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeExtension($name)
    {
        if (isset($this->extensions[$name])) {
            unset($this->extensions[$name]);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function createGrid(Collection $collection, array $options = array())
    {
        $extensions = $this->getExtensions();

        // resolve options
        $resolver = new OptionsResolver();
        foreach ($extensions as $extension) {
            $extension->configure($resolver);
        }
        $options = $resolver->resolve($options);

        // read schema
        $schema = null;
        foreach ($extensions as $extension) {
            $schema = $extension->guessSchema($collection->getPeek(), $options);
            if (null !== $schema) {
                break;
            }
        }
        if (null === $schema) {
            throw ConfigurationException::schemaNotFound(array_keys($this->extensions));
        }

        // create grid
        $grid = new Grid();
        $schema->bind($this, $grid);

        // build schema: extensions are able to manipulate schema columns
        foreach ($extensions as $extension) {
            $extension->buildSchema($schema, $collection, $options);
        }

        // build grid: extensions are responsible of adding rows
        foreach ($extensions as $extension) {
            $extension->buildGrid($grid, $schema, $collection, $options);
        }

        // visit model: visitors are able to manipulate AST
        foreach ($extensions as $extension) {
            $extension->visit($grid, $options);
        }

        return $grid;
    }

    /**
     * {@inheritdoc}
     */
    public function createColumn($type, array $globalOptions = array(), array $columnOptions = array())
    {
        $column = new Column();
        foreach ($this->getExtensions() as $extension) {
            $extension->buildColumn($column, $type, $globalOptions);
        }

        return $column->configure($columnOptions);
    }

    /**
     * Returns sorted list of extensions.
     *
     * @return ExtensionInterface[]
     */
    private function getExtensions()
    {
        if (!$this->sorted) {
            usort($this->extensions, function (array $a, array $b) {
                return $a['priority'] === $b['priority']
                    ? ($a['index'] > $b['index'] ? 1 : -1)
                    : ($a['priority'] > $b['priority'] ? -1 : 1);
            });
            $this->sorted = true;
        }

        return array_map(function (array $entry) {
            return $entry['extension'];
        }, $this->extensions);
    }
}
