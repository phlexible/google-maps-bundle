<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\GoogleMapsComponent;

use Phlexible\Component\AbstractComponent;

/**
 * Google Maps component
 *
 * @author Marcus Stöhr <mstoehr@brainbits.net>
 */
class GoogleMapsComponent extends AbstractComponent
{
    public function __construct()
    {
        $this
            ->setVersion('0.6.0')
            ->setId('googlemaps')
            ->setFile(__FILE__)
            ->setPackage('phlexible');
    }

    /**
     * Return fields
     *
     * @return array
     */
    public function getFields()
    {
        $fields = array(
            'address' => 'Phlexible\GoogleMapsComponent\Field\AddressField',
        );

        return $fields;
    }
}
