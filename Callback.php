<?php
/**
 * MAKEweb
 *
 * PHP Version 5
 *
 * @category    Makeweb
 * @package     Makeweb_Googlemaps
 * @copyright   2010 brainbits GmbH (http://www.brainbits.net)
 * @version     SVN: $Id:$
 */

/**
 * Add Google Maps Key to the View
 *
 * @category    Makeweb
 * @package     Makeweb_Googlemaps
 * @author      Marcus Stöhr <mstoehr@brainbits.net>
 * @copyright   2010 brainbits GmbH (http://www.brainbits.net)
 */
class Makeweb_Googlemaps_Callback
{
    /**
     * Add dwoo plugins
     *
     * @param MWF_Core_Templating_Event_CreateView $event
     * @param array                                $params
     */
    public static function callAddPlugins(MWF_Core_Templating_Event_CreateView $event, array $params)
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
    public static function addGoogleMapsKey(Makeweb_Renderers_Event_Assign $event, array $params = array())
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
    public static function callViewDefault(MWF_Core_Frame_Event_ViewFrame $event)
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