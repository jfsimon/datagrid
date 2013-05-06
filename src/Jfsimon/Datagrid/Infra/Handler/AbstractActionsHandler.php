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
use Jfsimon\Datagrid\Model\Trans;
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
                ActionsExtension::NAME          => Actions::disable(),
                ActionsExtension::NAME.'_trans' => Trans::disable(),
            ))
            ->addAllowedTypes(array(
                ActionsExtension::NAME          => 'Jfsimon\Datagrid\Model\Actions',
                ActionsExtension::NAME.'_trans' => 'Jfsimon\Datagrid\Model\Trans',
            ))
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
                $this->getLabel($action['name'], $column->getGrid()->getName(), $options[ActionsExtension::NAME.'_trans']))
            );
        }

        return $collection;
    }

    /**
     * @param string $subject
     * @param string $grid
     * @param Trans  $trans
     *
     * @return Label
     */
    private function getLabel($subject, $grid, Trans $trans)
    {
        if ($trans->isEnabled()) {
            $label = $trans->resolvePattern(array(
                '{grid}'      => $grid,
                '{extension}' => ActionsExtension::NAME,
                '{subject}'   => $subject,
            ));

            return new Label($label, true, $trans->getDomain());
        }

        $formatter = new LabelFormatter();

        return new Label($formatter->format($subject));
    }
}
