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
     * @var string
     */
    private $apiKey;

    /**
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param ViewEvent $event
     */
    public function onViewFrame(ViewEvent $event)
    {
        $uri = '//maps.google.com/maps/api/js';
        if ($this->apiKey) {
            $uri .= '?key='.$this->apiKey;
        }

        $view = $event->getView();
        $view->addScript($uri, 'text/javascript');
    }
}
