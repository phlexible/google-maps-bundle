<?php

/*
 * This file is part of the phlexible google maps package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\GoogleMapsBundle\Tests\EventListener;

use Phlexible\Bundle\GoogleMapsBundle\EventListener\ViewFrameListener;
use Phlexible\Bundle\GuiBundle\Event\ViewEvent;
use Phlexible\Bundle\GuiBundle\View\IndexView;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * View frame listener.
 *
 * @author Stephan Wentz <swentz@brainbits.net>
 *
 * @covers \Phlexible\Bundle\GoogleMapsBundle\EventListener\ViewFrameListener
 */
class ViewFrameListenerTest extends TestCase
{
    public function testOnViewFrameWithoutApiKey()
    {
        $dispatcher = $this->prophesize(EventDispatcherInterface::class);
        $request = $this->prophesize(Request::class);
        $view = new IndexView($dispatcher->reveal());
        $event = new ViewEvent($request->reveal(), $view);

        $listener = new ViewFrameListener(null);
        $listener->onViewFrame($event);

        $data = $view->get($request->reveal());

        $this->assertSame('<script type="text/javascript" src="//maps.google.com/maps/api/js"></script>'.PHP_EOL, $data);
    }

    public function testOnViewFrameWithApiKey()
    {
        $dispatcher = $this->prophesize(EventDispatcherInterface::class);
        $request = $this->prophesize(Request::class);
        $view = new IndexView($dispatcher->reveal());
        $event = new ViewEvent($request->reveal(), $view);

        $listener = new ViewFrameListener('testKey');
        $listener->onViewFrame($event);

        $data = $view->get($request->reveal());

        $this->assertSame('<script type="text/javascript" src="//maps.google.com/maps/api/js?key=testKey"></script>'.PHP_EOL, $data);
    }
}
