<?php
/*
 * This file is part of the CleverAge/EAVManager package.
 *
 * Copyright (c) 2015-2018 Clever-Age
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CleverAge\EAVManager\AdminBundle\DependencyInjection;

use Sidus\BaseBundle\DependencyInjection\SidusBaseExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\BadMethodCallException;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @see http://symfony.com/doc/current/cookbook/bundles/extension.html
 *
 * @author Vincent Chalnot <vchalnot@clever-age.com>
 */
class CleverAgeEAVManagerAdminExtension extends SidusBaseExtension
{
    /** @var array */
    protected $globalConfig;

    /** @var string */
    protected $rootAlias;

    /**
     * @param string $rootAlias
     */
    public function __construct($rootAlias)
    {
        $this->rootAlias = $rootAlias;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->rootAlias;
    }

    /**
     * {@inheritdoc}
     *
     * @throws BadMethodCallException
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->createConfiguration();
        $this->globalConfig = $this->processConfiguration($configuration, $configs);

        $container->setParameter($this->rootAlias.'.configuration', $this->globalConfig);

        parent::load($configs, $container);
    }

    /**
     * @return Configuration
     *
     * @throws BadMethodCallException
     */
    protected function createConfiguration()
    {
        return new Configuration($this->getAlias());
    }
}
