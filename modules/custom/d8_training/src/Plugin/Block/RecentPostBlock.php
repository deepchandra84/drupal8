<?php

namespace Drupal\d8_training\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Driver\mysql\Connection;

/**
 * Provides a 'RecentPostBlock' block.
 *
 * @Block(
 *  id = "recent_post_block",
 *  admin_label = @Translation("Recent Post Block"),
 * )
 */
class RecentPostBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;
  /**
   * Construct.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        Connection $database
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->database = $database;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('database')
    );
  }
  /**
   * {@inheritdoc}
   */
  public function build() {
    $account = \Drupal::currentUser();
    
    if ($account->getEmail()) {
      $header = $account->getEmail();   
    }
    else {
      $header = 'Anonymous';
    }
    
    $nodes = $this->database->select('node_field_data', 'n')
    ->fields('n', array('nid', 'title', 'created'))
    ->orderBy('n.created', 'desc')
    ->range(0, 3)
    ->execute()
    ->fetchAll();
    
    $header = array('Recent Nodes for ' . $header);
    $cache = array('node_list');
    foreach ($nodes as $recent_node) {
      $row = array();
      // Render the table columns.
      $row['data'][] = $recent_node->title;
      $rows[] = $row;
      $cache[] = 'node:' . $recent_node->nid;
    }
    
    $build = [];
    $build[] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
      '#cache' => ['tags' => $cache, 'contexts' => ['user']]
    ];

    return $build;
  }
}
