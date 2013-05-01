<?php

namespace Jfsimon\Datagrid\Infra\Handler;

use Jfsimon\Datagrid\Exception\ConfigurationException;
use Jfsimon\Datagrid\Infra\Extension\ActionsExtension;
use Jfsimon\Datagrid\Model\Content\Actions;
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
            ->addAllowedTypes(array(ActionsExtension::NAME => 'Jfsimon\Datagrid\Model\Content\Actions'))
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
            throw ConfigurationException::undefinedOption('options');
        }

        return $options['actions'];
    }
}
