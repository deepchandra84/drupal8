<?php
namespace Drupal\d8_training\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Drupal\views\Plugin\views\area\Title;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\dblog\Logger\DbLog;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NodelistingController extends ControllerBase {
  private $database;
  private $dblog;
  
  public function __construct(Connection $database, DbLog $dblog) {
	  $this->database = $database;
	  $this->dblog = $dblog;
  }
  
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('logger.dblog')
    );
  }
  
  public function content() {
    $nodes = $this->database->select('node', 'n')
      ->fields('n', array())
      ->execute()
      ->fetchAll();
    
    $header = array(
       'Nid',
       'Vid',
       'Type'
    );
    
    foreach ($nodes as $n) {
      $row = array();
      // Render the table columns.
      $row['data'][] = $n->nid;
      $row['data'][] = $n->vid;
      $row['data'][] = $n->type;
      $rows[] = $row;
    }
    
    $output[] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header
    ];
    
    return $output;
    /* return array(
      '#theme' => 'item_list',
      '#items' => array('Hello !! Welcome to drupal 8 world :)')  
    ); */
  }

  public function contentDetails() {
    return array(
        '#theme' => 'item_list',
        '#items' => array('Hello !! Welcome to details page of Drupal 8 world :)')
    );
  }

  public function dynamicContent($entity_type) {
    return array(
      '#theme' => 'item_list',
      '#items' => array('Hello !! Welcome to list of "' . strtoupper($entity_type) . '" content in drupal 8 world :)')
    );
  }
  
  public function loadNode(NodeInterface $node) {
    $node_json = Json::encode($node);
    $body_arrr = $node->get('body')->getValue();
    $body = $body_arrr[0]['value'];
    
    /* $body_json = Json::encode($body_arrr); */
    
    /* return array('#markup' => 'Node json: ' . $node_json . ' <br/> Body Json: ' . $body_json); */
    return array(
        '#theme' => 'item_list',
        '#items' => array('Title: "' . $node->getTitle(). '"', 'Body: ' . $body)
    );
    
    return array(
        '#markup' => '<strong>Title:</strong> "' . $node->getTitle(). '"<br/><strong>Body:</strong> ' . $body
    );
  }
}