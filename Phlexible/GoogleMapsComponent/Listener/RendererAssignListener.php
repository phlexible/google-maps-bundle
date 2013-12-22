<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\GoogleMapsComponent\Event;

/**
 * Google Maps listeners
 *
 * @author Marcus Stöhr <mstoehr@brainbits.net>
 */
class RendererAssignListener
{
    /**
     * @var string
     */
    private $googleMapsApiKey;

    /**
     * @param string $googleMapsApiKey
     */
    public function __construct($googleMapsApiKey)
    {
        $this->googleMapsApiKey = $googleMapsApiKey;
    }

    /**
     * Assign Google Maps-Key to the view
     *
     * @param \Makeweb_Renderers_Event_Assign $event
     */
    public function onRendererAssign(\Makeweb_Renderers_Event_Assign $event)
    {
        $view = $event->getRenderer()->getView();

        if ($this->googleMapsApiKey)
        {
            $view->mapsApiKey = $this->googleMapsApiKey;
        }
    }
}
