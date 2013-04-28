<?php

namespace Jfsimon\Datagrid\Infra\Extension\Data;

use Jfsimon\Datagrid\Infra\Extension\DataExtension;
use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Model\Component\Cell;
use Jfsimon\Datagrid\Model\Data\Entity;
use Jfsimon\Datagrid\Service\FormatterInterface;
use Jfsimon\Datagrid\Service\HandlerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class DataHandler implements HandlerInterface
{
    /**
     * @var FormatterInterface
     */
    private $formatter;

    /**
     * @param FormatterInterface $formatter
     */
    public function __construct(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $resolver)
    {
        $this->formatter->configure($resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Column $column, Entity $entity = null, array $options = array())
    {
        $value = $entity->get($column->getName());

        return new Cell($this->formatter->format($value, $options));
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return DataExtension::NAME;
    }
}
