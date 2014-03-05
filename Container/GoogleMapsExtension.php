<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\GoogleMapsComponent\Container;

use Phlexible\Container\ContainerBuilder;
use Phlexible\Container\Extension\Extension;
use Phlexible\Container\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

/**
 * Google maps extension
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class GoogleMapsExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $configs)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../_config'));
        $loader->load('services.yml');

        $container->setParameters(
            array(
                'googlemaps.asset.script_path' => __DIR__ . '/../_scripts',
                'googlemaps.api_key' => '',
            )
        );
    }
}
