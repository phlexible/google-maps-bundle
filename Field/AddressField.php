<?php

/*
 * This file is part of the phlexible google maps package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\GoogleMapsBundle\Field;

use Phlexible\Bundle\ElementtypeBundle\Field\TextField;

/**
 * Address field.
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
