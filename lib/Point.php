<?php

/**
 * Class Point
 */
class Point
{
  /**
   * @var
   */
  protected $lat;
  /**
   * @var
   */
  protected $lon;
  /**
   * @var int
   */
  protected $altitude;
  /**
   * @var
   */
  protected $time;
  /**
   * @var
   */
  protected $cad;
  /**
   * @var int
   */
  protected $hr = 0;

  /**
   * @param $lat
   * @param $lon
   * @param $altitude
   * @param $time
   */
  public function __construct($lat, $lon, $altitude, $time)
  {
    $this->lat = $lat;
    $this->lon = $lon;
    $this->altitude = (int) $altitude;
    $this->time = $time;
  }

  /**
   * @return mixed
   */
  public function getAltitude()
  {
    return $this->altitude;
  }

  /**
   * @return mixed
   */
  public function getCad()
  {
    return $this->cad;
  }

  /**
   * @param mixed $cad
   */
  public function setCad($cad)
  {
    $this->cad = $cad;
  }

  /**
   * @return mixed
   */
  public function getHr()
  {
    return $this->hr;
  }

  /**
   * @param mixed $hr
   */
  public function setHr($hr)
  {
    $this->hr = $hr;
  }

  /**
   * @return array
   */
  public function getData()
  {
    return array(
      'lat' => $this->lat,
      'lng' => $this->lon,
      'alt' => $this->altitude,
      'hr'  => $this->hr,
      'time'=> $this->time,
      'LatLng' => array(
        'lat' => $this->lat,
        'lng' => $this->lon,
      )
    );
  }
}