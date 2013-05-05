<?php

namespace Jfsimon\Datagrid\Infra\Extension;

use Jfsimon\Datagrid\Infra\Extension\AbstractExtension;
use Jfsimon\Datagrid\Infra\Handler\DataActionsHandler;
use Jfsimon\Datagrid\Infra\Handler\LabelActionsHandler;
use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Model\Data\Collection;
use Jfsimon\Datagrid\Model\Schema;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class ActionsExtension extends AbstractExtension
{
    const NAME = 'actions';

    /**
     * @var DataActionsHandler
     */
    private $dataHandler;

    /**
     * @var LabelActionsHandler
     */
    private $labelHandler;

    /**
     * @param DataActionsHandler|null  $dataHandler
     * @param LabelActionsHandler|null $labelHandler
     */
    public function __construct(DataActionsHandler $dataHandler = null, LabelActionsHandler $labelHandler = null)
    {
        $this->dataHandler = $dataHandler ?: new DataActionsHandler();
        $this->labelHandler = $labelHandler ?: new LabelActionsHandler();
    }

    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $resolver)
    {
        $this->dataHandler->configure($resolver);
        $this->labelHandler->configure($resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function buildSchema(Schema $schema, Collection $collection, array $options = array())
    {
        if (null !== $options[self::NAME]) {
            $schema->add('.'.self::NAME, self::NAME, array(self::NAME => $options[self::NAME]));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildColumn(Column $column, $type, array $options = array())
    {
        if (null !== $options[self::NAME] && self::NAME === $type) {
            $column
                ->register($this->dataHandler, true)
                ->register($this->labelHandler, true)
            ;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }
}
