<?php

namespace Jfsimon\Datagrid\Infra\Handler;

use Jfsimon\Datagrid\Exception\ConfigurationException;
use Jfsimon\Datagrid\Infra\Extension\ActionsExtension;
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
            ->setDefaults(array(ActionsExtension::NAME => null))
            ->addAllowedTypes(array(ActionsExtension::NAME => 'Jfsimon\Datagrid\Model\Actions'))
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
     * @param array $actions
     *
     * @return Collection
     */
    protected function getContent(array $actions)
    {
        $collection = new Collection();

        foreach ($actions as $action) {
            $collection->add(new Link(new Url($action['url']), new Label($action['label'])));
        }

        return $collection;
    }
}
