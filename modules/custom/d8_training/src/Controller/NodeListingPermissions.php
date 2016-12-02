<?php
namespace Drupal\d8_training\Controller;
use Drupal\node\Entity\NodeType;

class NodeListingPermissions {
  public function trainingPermissions() {
    $types = NodeType::loadMultiple();
    $permissions = [];
    
    foreach($types as $type) {
      $title = $type->id();
      $permissions['d8 traiuning access for ' . $title] = array(
        'title' => 'D8 Training access for ' . $type->get('name'),
        'description' => 'D8 Training access for ' . $title
      );
    }
    return $permissions;
  }
}
