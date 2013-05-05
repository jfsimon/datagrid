<?php

namespace Jfsimon\Datagrid\Infra\Handler;

use Jfsimon\Datagrid\Exception\ConfigurationException;
use Jfsimon\Datagrid\Infra\Extension\ActionsExtension;
use Jfsimon\Datagrid\Infra\Extension\LabelExtension;
use Jfsimon\Datagrid\Infra\Formatter\LabelFormatter;
use Jfsimon\Datagrid\Model\Column;
use Jfsimon\Datagrid\Model\Component\Collection;
use Jfsimon\Datagrid\Model\Component\Label;
use Jfsimon\Datagrid\Model\Component\Link;
use Jfsimon\Datagrid\Model\Component\Url;
use Jfsimon\Datagrid\Model\Actions;
use Jfsimon\Datagrid\Service\HandlerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
abstract class AbstractActionsHandler implements HandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(array(
                ActionsExtension::NAME                  => null,
                ActionsExtension::NAME.'_trans'         => false,
                ActionsExtension::NAME.'_trans_domain'  => 'datagrid',
                ActionsExtension::NAME.'_trans_pattern' => '{grid}.'.ActionsExtension::NAME.'.{action}.'.LabelExtension::NAME,
            ))
            ->addAllowedTypes(array(ActionsExtension::NAME => 'Jfsimon\Datagrid\Model\Actions'))
            ->addAllowedTypes(array(ActionsExtension::NAME => 'null'))
        ;
    }

    /**
     * @param array $options
     *
     * @throws ConfigurationException
     *
     * @return Actions
     */
    protected function getActions(array $options)
    {
        if (null === $options['actions']) {
            throw ConfigurationException::undefinedOption('actions');
        }

        return $options['actions'];
    }

    /**
     * @param array  $actions
     * @param Column $column
     * @param array  $options
     *
     * @return Collection
     */
    protected function getContent(array $actions, Column $column, array $options)
    {
        $collection = new Collection();

        foreach ($actions as $action) {
            $collection->add(
                new Link(new Url($action['url']),
                $this->getLabel($action['name'], $column->getGrid()->getName(), $options))
            );
        }

        return $collection;
    }

    /**
     * @param string $actionName
     * @param string $gridName
     * @param array  $options
     *
     * @return Label
     */
    private function getLabel($actionName, $gridName, array $options)
    {
        // translator enabled
        if ($options[ActionsExtension::NAME.'_trans']) {
            $label = strtr($options[ActionsExtension::NAME.'_trans_pattern'], array(
                '{grid}'   => $gridName,
                '{action}' => $actionName,
            ));

            return new Label($label, true, $options[ActionsExtension::NAME.'_trans_domain']);
        }

        $formatter = new LabelFormatter();

        return new Label($formatter->format($actionName));
    }
}
