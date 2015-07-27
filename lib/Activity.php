<?php
require 'Point.php';

/**
 * Class Activity
 */
class Activity
{

  /**
   *
   */
  const GPX_FOLDER = 'gpxFiles';

  /**
   * @var array
   */
  protected $points = [];

  /**
   * @param $fileName
   */
  public function __construct($fileName)
  {
      $path = __DIR__ . "\\..\\" . self::GPX_FOLDER . DIRECTORY_SEPARATOR . $fileName;

      if (file_exists($path)) {
        $xml = simplexml_load_file($path);
        foreach ($xml->trk->trkseg->trkpt as $point) {

          $attr = $point->attributes();
          $pointObj = new Point((float)$attr->lat, (float)$attr->lon, $point->ele, (string) $point->time);

          $namespaces = $point->getNamespaces(true);
          if ($point->extensions) {
            $gpxtpx = $point->extensions->children($namespaces['gpxtpx']);
            if ($gpxtpx->TrackPointExtension->hr) {
              $pointObj->setHr((int) $gpxtpx->TrackPointExtension->hr);
            }

          }

          $this->points[] = $pointObj;
        }
      } else {
        throw new \InvalidArgumentException("No such file or file invalid.");
      }
  }

  /**
   * @return string
   */
  public function getJson()
  {
    return json_encode(array(
      'points' => array_map(function($value){
        /** @var $value Point */
        return $value->getData();
      }, $this->points)
    ), JSON_NUMERIC_CHECK);
  }
}