<?php
namespace Drupal\d8_training\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Drupal\views\Plugin\views\area\Title;
use Drupal\Component\Serialization\Json;

class NodelistingController extends ControllerBase {
  public function content() {
    return array(
      '#theme' => 'item_list',
      '#items' => array('Hello !! Welcome to drupal 8 world :)')  
    );
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
    
    $body_json = Json::encode($body_arrr);
    return array('#markup' => 'Node json: ' . $node_json . ' <br/> Body Json: ' . $body_json);
    /* return array(
        '#theme' => 'item_list',
        '#items' => array('Title: "' . $node->getTitle(). '"', 'Body: ' . $body)
    );
     */
    return array(
        '#markup' => '<strong>Title:</strong> "' . $node->getTitle(). '"<br/><strong>Body:</strong> ' . $body
    );
  }
}