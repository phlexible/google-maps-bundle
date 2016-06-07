<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\GoogleMapsBundle\Tests\EventListener;

use Phlexible\Bundle\GoogleMapsBundle\EventListener\ViewFrameListener;
use Phlexible\Bundle\GuiBundle\Event\ViewEvent;
use Phlexible\Bundle\GuiBundle\View\IndexView;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * View frame listener
 *
 * @author Stephan Wentz <swentz@brainbits.net>
 */
class ViewFrameListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testOnViewFrame()
    {
        $dispatcher = $this->prophesize(EventDispatcherInterface::class);
        $request = $this->prophesize(Request::class);
        $view = new IndexView($dispatcher->reveal());
        $event = new ViewEvent($request->reveal(), $view);

        $listener = new ViewFrameListener();
        $listener->onViewFrame($event);

        $data = $view->get($request->reveal());

        $this->assertSame('<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script>'.PHP_EOL, $data);
    }
}
