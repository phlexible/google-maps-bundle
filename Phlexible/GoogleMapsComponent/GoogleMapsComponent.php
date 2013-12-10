<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\GoogleMapsComponent;

use MWF_Component_Abstract as AbstractComponent;
use Phlexible\Container\ContainerBuilder;

/**
 * Google Maps component
 *
 * @author Marcus Stöhr <mstoehr@brainbits.net>
 */
class GoogleMapsComponent extends AbstractComponent
{
    public function __construct()
    {
        $this
            ->setVersion('0.6.0')
            ->setId('googlemaps')
            ->setFile(__FILE__)
            ->setPackage('phlexible');
    }

    public function initContainer(ContainerBuilder $container)
    {
        $container->setParameters(
            array(
                ':googlemaps.key' => '',
            )
        );

        $container->addComponents(
            array(
                'googlemapsStatic' => array(
                    'class' => 'Phlexible\GoogleMapsComponent\StaticMap',
                ),
                // dwoo plugins
                'googlemapsPluginStatisGoogleMap' => array(
                    'tag'   => array(
                        'name'  => 'dwoo.plugin',
                        'class' => 'Phlexible\DwooRenderer\Plugin\StaticGoogleMap',
                        'alias' => 'mwStaticGoogleMaps'
                    ),
                ),
                // listener
                'googlemapsListenerAssign' => array(
                    'tag' => array(
                        'name' => 'event.listener',
                        'event' => \Makeweb_Renderers_Event::ASSIGN,
                        'callback' => array('Phlexible\GoogleMapsComponent\Listeners', 'onAssign'),
                    ),
                ),
                'googlemapsListenerViewDefault' => array(
                    'tag' => array(
                        'name' => 'event.listener',
                        'event' => \MWF_Core_Frame_Event::VIEW_FRAME,
                        'callback' => array('Phlexible\GoogleMapsComponent\Listeners', 'onViewFrame'),
                    ),
                ),
                'googlemapsListenerAddPlugins' => array(
                    'tag' => array(
                        'name' => 'event.listener',
                        'event' => \MWF_Core_Templating_Event::CREATE_VIEW,
                        'callback' => array('Phlexible\GoogleMapsComponent\Listeners', 'onCreateView'),
                    ),
                ),
            )
        );
    }

    /**
     * Return fields
     *
     * @return array
     */
    public function getFields()
    {
        $fields = array(
            'address' => 'Phlexible\GoogleMapsComponent\Field\AddressField',
        );

        return $fields;
    }

    /**
     * Return scripts
     *
     * @return array
     */
    public function getScripts()
    {
        $path = $this->getPath().'/_scripts/';

        return array(
            $path . 'Definitions.js',
            $path . 'MapWindow.js',
            $path . 'AddressSearch.js',
            $path . 'fields/AddressField.js',
        );
    }

    /**
     * Return translations
     *
     * @return array
     */
    public function getTranslations()
    {
        $t9n  = $this->getContainer()->t9n;
        $page = $t9n->googlemaps->toArray();

        return array(
            'Makeweb.strings.Googlemaps' => $page
        );
    }
}
