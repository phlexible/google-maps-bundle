<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietery
 */

/**
 * Class for fetching the static google maps uri
 *
 * @author Marcus Stöhr <ms@brainbits.net>
 */
class StaticMap
{
    /**
     * Returns the uri for the static map.
     *
     * @param   string  $latitude
     * @param   string  $longitude
     * @param   string  $width
     * @param   string  $height
     * @param   int     $zoom
     * @param   boolean $useHttps
     * @return  string  Uri of the static Google Map
     */
    public function getUri($latitude, $longitude, $width, $height, $zoom = 10, $useHttps = false)
    {
        $latitude  = (string)$latitude;
        $longitude = (string)$longitude;
        $width     = (int)$width;
        $height    = (int)$height;
        $zoom      = (int)$zoom;

        return ($useHttps ? 'https' : 'http') . '://maps.google.com/staticmap'
            . '?markers=' . (string)$latitude . ',' . (string)$longitude
            . '&size=' . $width . 'x' . $height
            . '&zoom=' . $zoom;
    }

    /**
     * Check if the google maps api-key is available
     *
     * @deprecated
     */
    public function isAvailable()
    {
        return true;
    }
}
