<?php

    /*
     * Usage:
     *     $geo = new Google_Map_Geocode();
     *     $geo->get_address('London, UK');
     *     $geo->get_latlong('51.535879,0.696966');
     *
     *     Simon Smith - http://blink-design.net
     */

    class Google_Map_Geocode {

        private $url = 'http://maps.googleapis.com/maps/api/geocode/json?%2$s=%1$s&sensor=%3$s';

        /**
         * @var array URL parameters.
         */
        private $default_params = array(
            'type' => 'address',
            'sensor' => 'false'
        );

        /**
         * @param string $url_override
         */
        function __construct($url_override = '') {

            if (!empty($url_override)) $this->url = $url_override;

        }

        /**
         * @param string $address e.g 'London, UK'
         * @param array $params Merges with $default_params
         * @return mixed
         */
        public function get_address($address, $params = array()) {

            $params['type'] = 'address';
            $api_response = $this->fetch_url($address, $params);

            if ($api_response) {
                return json_decode($api_response);
            }

        }

        /**
         * @param $latlong string e.g. '51.535879,0.696966'
         * @param array $params Merges with $default_params
         * @return mixed
         */
        public function get_latlong($latlong, $params = array()) {

            $params['type'] = 'latlng';
            $latlong = str_replace(' ', '', $latlong);
            $api_response = $this->fetch_url($latlong, $params);

            if ($api_response) {
                return json_decode($api_response);
            }

        }

        /**
         * @param string $query Search query
         * @param $params
         * @return string
         */
        private function fetch_url($query, $params) {

            $url_params = $this->merge_url_params(trim($query), $params);
            $url = $this->format_url($url_params);

            return file_get_contents($url);

        }

        /**
         * @param $query
         * @param $params
         * @return array
         */
        private function merge_url_params($query, $params) {

            // Merge any user defined parameters with the defaults
            $params = (empty($params) ? $this->default_params : array_merge($this->default_params, $params));

            // Add the search query to the start of the $params array so it can
            // be replaced in the URL string with the other params
            return array_merge(array('query' => rawurlencode($query)), $params);

        }

        /**
         * @param $params
         * @return string
         */
        private function format_url($params) {

            return vsprintf($this->url, $params);

        }

    }
