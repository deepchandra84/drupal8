<?php

namespace Drupal\d8_training;

use Drupal\Core\Config\ConfigFactory;
use GuzzleHttp\Client;

class OpenWeatherForecaster {
  private $config_factory;
  private $http_client;
  
  public function __construct(ConfigFactory $config_factory, Client $http_client) {
    $this->config_factory = $config_factory;
    $this->http_client = $http_client;
  }
  
  public function getWeatherAppId() {
    return $this->config_factory->get('d8_training.app_id')->get('appid');
  }
  public function fetchWeatherData($city_name) {
    $data = '';
    $api_key = $this->getWeatherAppId();
    $method = 'GET';
    $endPoint = 'http://api.openweathermap.org/data/2.5/weather?q=' . $city_name . '&appid=' . $api_key;
    //$options = array('query' => array('q' => $city_name, 'appid' => $api_key));
    //$resp = $this->http_client->request($method, $endPoint);
    
    //$data = $resp->getBody()->getContents();
    
    return $data;
  }
}