<?php
namespace Drupal\d8_training\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\d8_training\OpenWeatherForecaster;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\Serialization\Json;

/**
 * Provides a 'WeatherBlock' Block.
 *
 * @Block(
 *   id = "weather_block",
 *   admin_label = @Translation("Weather Block"),
 * )
 */
class WeatherBlock extends BlockBase implements ContainerFactoryPluginInterface{
  
  private $weatherForecaster;
  protected $configuration;
  private $plugin_id;
  private $plugin_definition;
  
  public function __construct(array $configuration, $plugin_id, $plugin_definition, OpenWeatherForecaster $weatherForecaster) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->weatherForecaster = $weatherForecaster;
  }
  
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
        $configuration,
        $plugin_id,
        $plugin_definition,
        $container->get('d8_training.weather_forecaster')
    );
  }
  
  public function blockForm($form, FormStateInterface $form_state) {
    $form = array();

    $form['city'] = array(
      '#type' => 'select',
      '#title' => $this->t('City:'),
      '#required' => TRUE,
      '#default_value' => $this->getConfiguration('city'),
      '#options' => array('Select' => '_none', 'mumbai' => 'Mumbai', 'pune' => 'Pune', 'delhi' => 'Delhi', 'london' => 'London'),
    );
    return $form;
  }
  
  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfiguration(array('city' => $form_state->getValue('city')));
  }
    
  /**
   * {@inheritdoc}
   */
  public function build() {
    $configuration = $this->getConfiguration('city');
    $app_id = $this->weatherForecaster->getWeatherAppId();
    $data = $this->weatherForecaster->fetchWeatherData($configuration['city']);
    $response_arr = Json::decode($data);
    
    $header = array('Field','Values');
    
    $weather_data = array(
      'city' =>  strtoupper($configuration['city']),
      'temp_min' =>  $response_arr['main']['temp_min'],
      'temp_max' => $response_arr['main']['temp_max'],
      'pressure' => $response_arr['main']['pressure'],
      'humidity' => $response_arr['main']['humidity'],
      'speed' => $response_arr['wind']['speed']
    );

    /* foreach ($weather_data as $key => $value) {
      $row = array();
      $row['data'][] = $key;
      $row['data'][] = $value;
      $rows[] = $row;
    } */
    
    $build['weather_block_data'] = array(
      '#theme' => 'weather_widget',
      '#weather_data' => $weather_data,
      '#attached' => [
        'library' => ['d8_training/weather_widget']
      ]  
    );
    
    return $build;
  }
}