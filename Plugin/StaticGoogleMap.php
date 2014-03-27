<?php

namespace Phlexible\GoogleMapsComponent\Plugin;

class StaticGoogleMap extends \Dwoo\Plugin
{
    /**
     * Customized Dwoo plugin for generation of static Google Maps Image
     * including fallback when defaultImage is provided
     *
     * @param   Dwoo    $dwoo           Dwoo instance
     * @param   string  $latitude       Latitude coordinate for marker
     * @param   string  $longitude      Longitude coordinate for marker
     * @param   string  $width          Width of defaultImage
     * @param   string  $height         Height of defaultImage
     * @param   int     $zoom           Zoomlevel of static map
     * @param   array   $rest[optional] Array of not explicit named parameters
     * @return  string  $result         Static Google Maps image
     */
    function process($latitude = '', $longitude = '', $width = '', $height = '',  $zoom = 10, array $rest = array())
    {
        if (empty($width) || empty($height))
        {
            throw new \RuntimeException('Cannot proceed: width and height are empty!');
        }

        // named parameters for the <img />-tag
        $params             = $rest;
        $params['width']    = $width;
        $params['height']   = $height;

        // We have latitude and longitude to create the static map
        if (!empty($latitude) && !empty($longitude))
        {
            try
            {
                $googlemapsStatic = \MWF_Registry::get('container')->googlemapsStatic;
                $data = $this->dwoo->getData();
                $useHttps = !empty($data['ssl']);
                $source = $googlemapsStatic->getUri($latitude, $longitude, $width, $height, $zoom, $useHttps);

                if (null !== $source)
                {
                    $params['src'] = $source;
                }
            }
            catch (\Exception $e)
            {
                $e->printStackTrace();
            }
        }

        // build <img/>-tag
        $implodedParams = '';
        foreach ($params as $key => $value)
        {
            $implodedParams .= ' ' . $key . '="' . $value .'"';
        }

        return '<img' . $implodedParams . ' />';
    }
}