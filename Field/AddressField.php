<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\GoogleMapsBundle\Field;

use Phlexible\Bundle\ElementtypeBundle\Field\TextField;

/**
 * Address field
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class AddressField extends TextField
{
    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return 'p-googlemaps-component-icon';
    }

    /**
     * {@inheritdoc}
     */
    public function getDataType()
    {
        return 'json';
    }
}
