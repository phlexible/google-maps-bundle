<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\GoogleMapsComponent;

use Phlexible\Component\Component;

/**
 * Google Maps component
 *
 * @author Marcus Stöhr <mstoehr@brainbits.net>
 */
class GoogleMapsComponent extends Component
{
    public function __construct()
    {
        $this
            ->setVersion('0.6.0')
            ->setId('googlemaps')
            ->setPackage('phlexible');
    }
}
