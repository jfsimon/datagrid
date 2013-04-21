<?php

namespace Jfsimon\Datagrid\Infra\Registry;

use Jfsimon\Datagrid\Service\RegistryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class ContainerRegistry implements RegistryInterface
{
    const TYPE_COLUMN  = 'column';
    const TYPE_SCHEMA  = 'schema';
    const TYPE_HANDLER = 'handler';
    const TYPE_VISITOR = 'visitor';

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var array
     */
    private $services;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $type
     * @param string $name
     * @param string $service
     *
     * @return ContainerRegistry
     */
    public function register($type, $name, $service)
    {
        if (!isset($this->services[$type])) {
            $this->services[$type] = array();
        }

        $this->services[$type][$name] = $service;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getColumn($name)
    {
        return $this->lookup(self::TYPE_COLUMN, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getSchema($name)
    {
        return $this->lookup(self::TYPE_SCHEMA, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getHandler($name)
    {
        return $this->lookup(self::TYPE_HANDLER, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getVisitor($name)
    {
        return $this->lookup(self::TYPE_VISITOR, $name);
    }

    /**
     * Looks for service in container.
     *
     * @param string $type
     * @param string $name
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    private function lookup($type, $name)
    {
        if (!isset($this->services[$type][$name])) {
            throw new \InvalidArgumentException('Service not found.');
        }

        return $this->container->get($this->services[$type][$name]);
    }
}
