<?php

/*
 * This file is part of the phlexible google maps package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\GoogleMapsBundle\EventListener;

use Phlexible\Bundle\GuiBundle\Event\ViewEvent;

/**
 * View frame listener.
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
