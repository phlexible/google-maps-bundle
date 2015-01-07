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
        $view = $event->getView();
        $view->addScript('//maps.google.com/maps/api/js?sensor=false', 'text/javascript');
    }
}
