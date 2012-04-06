# Google Map Geocode

Returns an object of address data from [the Google maps API](https://developers.google.com/maps/documentation/geocoding/).

## Usage

The class provides two methods to retrieve addresses:

    $geo = new Google_Map_Geocode();
    $geo->get_address('London, UK');
    $geo->get_latlong('51.535879,0.696966');

### Default URL parameters

The default parameters are:

    array(
        'query' => 'address' /* or */ 'latlng' // This is added depending on which method is called
        'type' => 'address',
        'sensor' => 'false'
    );

The following URL is substituted with the params using [vsprintf](http://php.net/manual/en/function.vsprintf.php):

    http://maps.googleapis.com/maps/api/geocode/json?%2$s=%1$s&sensor=%3$s

### Adding your own parameters

Instantiate the object with the new url as an argument. In this example the default region that is searched will be set to the UK:

    $geo = new Google_Map_Geocode('http://maps.googleapis.com/maps/api/geocode/json?%2$s=%1$s&sensor=%3$s&region=%4$s');

    $geo->get_address('London', array(
        'region' => 'uk'
    ));

## Notes

Please respect the [Google Maps API usage agreement](https://developers.google.com/maps/terms#section_10_12)

I intend to improve the way additional URL parameters are added at some point, but if you have any suggestions please make a pull request or open an issue.
Cheers


