<?php
namespace Drupal\d8_training\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class WeatherConfigForm extends ConfigFormBase {
  
  protected  function  getEditableConfigNames() {
    return [
      'd8_training.app_id'
    ];
  }
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'weather_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('d8_training.app_id');
    $default = $config->get('appid');
    $form['app_id'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('App Id:'),
      '#required' => TRUE,
      '#default_value' => $default,
    );
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state){
    $this->config('d8_training.app_id')
      ->set('appid', $form_state->getValue('app_id'))
      ->save();
    return parent::submitForm($form, $form_state);
  }
}

