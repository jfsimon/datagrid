<?php

namespace Jfsimon\Datagrid\Infra\Registry;

use Jfsimon\Datagrid\Service\RegistryInterface;

/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class RegistryChain implements RegistryInterface
{
    /**
     * @var RegistryInterface[]
     */
    private $registries = array();

    /**
     * @param array $registries
     */
    public function __construct(array $registries = array())
    {
        foreach ($registries as $registry) {
            $this->register($registry);
        }
    }

    /**
     * @param RegistryInterface $registry
     *
     * @return RegistryChain
     */
    public function register(RegistryInterface $registry)
    {
        $this->registries[] = $registry;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getColumn($name)
    {
        return $this->lookup('getColumn', $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getSchema($name)
    {
        return $this->lookup('getColumn', $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getHandler($name)
    {
        return $this->lookup('getHandler', $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getVisitor($name)
    {
        return $this->lookup('getVisitor', $name);
    }

    /**
     * Tries given method on registries.
     *
     * @param string $method
     * @param string $name
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    private function lookup($method, $name)
    {
        foreach ($this->registries as $registry) {
            try {
                return $registry->$method($name);
            } catch (\InvalidArgumentException $e) {
                continue;
            }
        }

        throw new \InvalidArgumentException('Service not found.');
    }
}
