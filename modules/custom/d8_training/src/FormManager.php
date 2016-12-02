<?php
namespace Drupal\d8_training;
use Drupal\Core\Database\Driver\mysql\Connection;

class FormManager {
   private $database;
  
  public function __construct(Connection $database) {
    $this->database = $database;
  }
  
  public function fetchData() {
    $query = $this->database->select('d8_training_table', 'd8t');
    $query->fields('d8t', array());
    $query->range(0,1);
    $result = $query->execute()->fetchAssoc();
    return $result['d8_text'];
  }
  
  public function addData($d8_enter_text_values) {
    $insert = $this->database->insert('d8_training_table')
      ->fields(array('d8_text' => $d8_enter_text_values))
      ->execute();
  }
}