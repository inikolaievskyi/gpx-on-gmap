<?php

class Point
{
  protected $lat;
  protected $lon;
  protected $altitude;
  protected $time;
  protected $cad;
  protected $hr = 0;

  public function __construct($lat, $lon, $altitude, $time)
  {
    $this->lat = $lat;
    $this->lon = $lon;
    $this->altitude = (int) $altitude;
    $this->time = $time;
  }

  public function getCoordinatesString()
  {
    return '{"lat": ' . $this->lat . ', "lng": ' . $this->lon . '}';
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

  public function getJson()
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