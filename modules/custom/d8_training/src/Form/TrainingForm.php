<?php
namespace Drupal\d8_training\Form;

use Drupal\Core\Form\FormBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\d8_training\FormManager;

class TrainingForm extends FormBase {
  private $formManager;
  
  public function __construct(FormManager $formManager) {
    $this->formManager = $formManager;
  }
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('d8_training.form_manager')
    );
  }
  
  /**
   * {@inheritdoc}
  */
  public function getFormId() {
    return 'd8_training_form';  
  }
  
   /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $result = $this->formManager->fetchData();  
    $form = array();
    $form['d8_enter_text'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('D8 Training Text:'),
      '#required' => TRUE,
    );
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );
    return $form;
  }
  
  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $d8_enter_text_values = $form_state->getValue('d8_enter_text');
    if (strlen($d8_enter_text_values) < 5) {
      $form_state->setErrorByName('d8_enter_text', $this->t('Must be greater than 5 character.'));
    }
  }
  
  /**
   * {@inheritdoc}
  */
  public function submitForm(array &$form, FormStateInterface $form_state){
    $d8_enter_text_values = $form_state->getValue('d8_enter_text');
    drupal_set_message('You have entered : ' . $d8_enter_text_values);
    
    $result = $this->formManager->addData($d8_enter_text_values);
    //$insert = $this->database->insert('d8_training_table')->fields(array('d8_text' => $d8_enter_text_values))->execute();
  }
}