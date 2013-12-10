<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\GoogleMapsComponent;

/**
 * Google Maps listeners
 *
 * @author Marcus Stöhr <mstoehr@brainbits.net>
 */
class Listeners
{
    /**
     * Add dwoo plugins
     *
     * @param \MWF_Core_Templating_Event_CreateView $event
     * @param array                                $params
     */
    public static function onCreateView(\MWF_Core_Templating_Event_CreateView $event, array $params)
    {
        // get view
        $view = $event->getView();
        if ('dwoo' === $event->getEngine())
        {
            // add Zend_View helper path
            $pluginPath = dirname(__FILE__)
                        . DIRECTORY_SEPARATOR
                        . '_plugins'
                        . DIRECTORY_SEPARATOR
                        . 'dwoo'
                        . DIRECTORY_SEPARATOR;

            $view->addPluginDir($pluginPath);
        }
    }

    /**
     * Assign Google Maps-Key to the view
     *
     * @param Makeweb_Renderers_Event_Assign $event
     * @param array                          $params
     */
    public static function onAssign(Makeweb_Renderers_Event_Assign $event, array $params = array())
    {
        $view = $event->getRenderer()->getView();

        $container = $params['container'];
        $mapsApiKey = $container->getParam(':googlemaps.key');

        if ($mapsApiKey)
        {
            $view->mapsApiKey = $mapsApiKey;
        }
    }

    /**
     * Add Google Maps-script to the view
     *
     * @param MWF_Core_Frame_Event_ViewFrame $event
     */
    public static function onViewFrame(MWF_Core_Frame_Event_ViewFrame $event)
    {
        $request = $event->getRequest();

        $protocol = 'http://';
        if ($request instanceof Zend_Controller_Request_Http && $request->isSecure())
        {
            $protocol = 'https://';
        }

        $view = $event->getView();
        $view->addScript($protocol . 'maps.google.com/maps/api/js?sensor=false', 'text/javascript');
    }
}
