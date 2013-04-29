<?php

namespace Jfsimon\Datagrid\Infra\Extension;

use Jfsimon\Datagrid\Exception\FormatterException;
use Jfsimon\Datagrid\Infra\Extension\AbstractExtension;
use Jfsimon\Datagrid\Infra\Handler\DataHandler;
use Jfsimon\Datagrid\Infra\Formatter;
use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Model\Component\Grid;
use Jfsimon\Datagrid\Model\Component\Row;
use Jfsimon\Datagrid\Model\Data\Collection;
use Jfsimon\Datagrid\Model\Schema;
use Jfsimon\Datagrid\Service\FormatterInterface;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class DataExtension extends AbstractExtension
{
    const NAME = 'data';

    /**
     * @var FormatterInterface[]
     */
    private $formatters;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this
            ->registerFormatter(new Formatter\StringFormatter())
            ->registerFormatter(new Formatter\NumberFormatter())
            ->registerFormatter(new Formatter\BooleanFormatter())
            ->registerFormatter(new Formatter\DateTimeFormatter())
        ;
    }

    /**
     * @param FormatterInterface $formatter
     *
     * @return DataExtension
     */
    public function registerFormatter(FormatterInterface $formatter)
    {
        $this->formatters[$formatter->getName()] = $formatter;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function buildGrid(Grid $grid, Schema $schema, Collection $collection, array $options = array())
    {
        $index = 0;
        while ($entity = $collection->next()) {
            $schema->build($row = new Row(self::NAME), $entity, $options);
            $grid->getBody()->add($entity->getId() ?: $index ++, $row);
        };
    }

    /**
     * {@inheritdoc}
     */
    public function buildColumn(Column $column, $type, array $options = array())
    {
        if (!isset($this->formatters[$type])) {
            throw FormatterException::notFound($type, array_keys($this->formatters));
        }

        $column->register(new DataHandler($this->formatters[$type]));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }
}
