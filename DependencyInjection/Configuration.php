<?php

/*
 * This file is part of the phlexible google maps package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\GoogleMapsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Google maps configuration.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('phlexible_google_maps');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('api_key')->defaultNull()->end()
            ->end();

        return $treeBuilder;
    }
}
