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
 * Makeweb Google Maps Plugin für Geotag Component
 *
 * @category    Makeweb
 * @package     Makeweb_Googlemaps
 * @author      Marcus Stöhr <mstoehr@brainbits.net>
 * @copyright   2010 brainbits GmbH (http://www.brainbits.net)
 */
class Makeweb_Googlemaps_Component extends MWF_Component_Abstract
{
    /**
     * Constructor
     * Initialses the Component values
     */
    public function __construct()
    {
        $this
            ->setVersion('0.6.0')
            ->setId('googlemaps')
            ->setFile(__FILE__)
            ->setPackage('makeweb');
    }

    public function initContainer(MWF_Container_ContainerBuilder $container)
    {
        $container->setParams(array(
            ':googlemaps.key' => '',
        ));

        $container->addComponents(
            array(
                'googlemapsStatic' => array(
                    'class' => 'Makeweb_Googlemaps_StaticMap',
                ),
                // listener
                'googlemapsListenerAssign' => array(
                    'tag' => array(
                        'name' => 'event.listener',
                        'event' => Makeweb_Renderers_Event::ASSIGN,
                        'callback' => array('Makeweb_Googlemaps_Callback', 'addGoogleMapsKey'),
                    ),
                ),
                'googlemapsListenerViewDefault' => array(
                    'tag' => array(
                        'name' => 'event.listener',
                        'event' => MWF_Core_Frame_Event::VIEW_FRAME,
                        'callback' => array('Makeweb_Googlemaps_Callback', 'callViewDefault'),
                    ),
                ),
                'googlemapsListenerAddPlugins' => array(
                    'tag' => array(
                        'name' => 'event.listener',
                        'event' => MWF_Core_Templating_Event::CREATE_VIEW,
                        'callback' => array('Makeweb_Googlemaps_Callback', 'callAddPlugins'),
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
            'address' => 'Makeweb_Googlemaps_Field_Address'
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
