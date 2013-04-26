<?php

namespace Jfsimon\Datagrid\Infra\Extension;

use Jfsimon\Datagrid\Model\Data\Entity;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Core extension.
 *
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class CoreExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function configure(OptionsResolver $resolver)
    {
        $resolver->setAllowedTypes(array(
            'schema' => 'Jfsimon\Datagrid\Model\Schema',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function guessSchema(Entity $entity, array $options)
    {
        return isset($options['schema']) ? $options['schema'] : null;
    }
}
