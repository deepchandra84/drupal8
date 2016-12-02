<?php

namespace Drupal\d8_training;
use Drupal\Core\Database\Driver\mysql\Connection;

/**
 * Class ConsoleDemoService.
 *
 * @package Drupal\d8_training
 */
class ConsoleDemoService implements ConsoleDemoServiceInterface {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;
  /**
   * Constructor.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

}
