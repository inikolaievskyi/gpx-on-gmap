<?php
require 'Point.php';

class Activity
{

  const GPX_FOLDER = 'gpxFiles';

  protected $points = [];
  public function __construct($fileName)
  {
      $path = self::GPX_FOLDER . DIRECTORY_SEPARATOR . $fileName;

      if (file_exists($path)) {
        $xml = simplexml_load_file($path);
        foreach ($xml->trk->trkseg->trkpt as $point) {

          $attr = $point->attributes();
          $lat = (array)$attr->lat;
          $lon = (array)$attr->lon;

          $pointObj = new Point($lat[0], $lon[0], $point->ele, $point->time);

          $namespaces = $point->getNamespaces(true);
          if ($point->extensions) {
            $gpxtpx = $point->extensions->children($namespaces['gpxtpx']);
            if ($gpxtpx->TrackPointExtension->hr) {
              $pointObj->setHr((int) $gpxtpx->TrackPointExtension->hr);
            }

          }


          $this->points[] = $pointObj;
          $this->coordinates[] = '{"lat":' . $lat[0] . ', "lng":' . $lon[0] . '}';
        }
      } else {
        throw new \InvalidArgumentException("No such file or file invalid.");
      }
  }

  /**
   * @return array
   */
  public function getCoordinatesString()
  {
    return implode(",", array_map(function($value) {
      /** @var Point $value  */
      return $value->getCoordinatesString();
    }, $this->points));
  }


  public function getAltitudeValues()
  {
    $data = [];
    foreach ($this->points as $key => $value ) {
      $time = gmdate("H:i:s", $key);
        $data[] = "['$time', {$value->getAltitude()}]";
    }

    return implode(",", $data);
  }



  public function getHrValues()
  {
    $data = [];

    /**
     * @var  $key
     * @var Point $value
     */
    foreach ($this->points as $key => $value ) {
      $time = gmdate("H:i:s", $key);
      $data[] = "['$time', {$value->getHr()}]";
    }

    return implode(",", $data);
  }

  public function combineHr() {
    $data = [];

    /**
     * @var  $key
     * @var Point $value
     */
    foreach ($this->points as $key => $value ) {
      $time = gmdate("H:i:s", $key);
      $data[$time] = $value->getHr();
    }

    return $data;
  }

  public function getJson()
  {
    return json_encode(array(
      'points' => array_map(function($value){
        return $value->getJson();
      }, $this->points)
    ), JSON_NUMERIC_CHECK);
  }
}