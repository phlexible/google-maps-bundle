<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\GoogleMapsBundle\EventListener;

use Phlexible\Bundle\GuiBundle\Event\ViewEvent;

/**
 * View frame listener
 *
 * @author Marcus Stöhr <mstoehr@brainbits.net>
 */
class ViewFrameListener
{
    /**
     * @param ViewEvent $event
     */
    public function onViewFrame(ViewEvent $event)
    {
        $request = $event->getRequest();

        $protocol = 'http://';
        if ($request instanceof \Zend_Controller_Request_Http && $request->isSecure()) {
            $protocol = 'https://';
        }

        $view = $event->getView();
        $view->addScript($protocol . 'maps.google.com/maps/api/js?sensor=false', 'text/javascript');
    }
}
