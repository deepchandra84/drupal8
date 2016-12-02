<?php

namespace Drupal\d8_training\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use GuzzleHttp\Client;
use AntoineAugusti\Books\Fetcher;

/**
 * Provides a 'BookDetailBlock' block.
 *
 * @Block(
 *  id = "book_detail_block",
 *  admin_label = @Translation("Book detail block"),
 * )
 */
class BookDetailBlock extends BlockBase {


  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
         'isbn' => $this->t(''),
        ] + parent::defaultConfiguration();

 }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['isbn'] = [
      '#type' => 'textfield',
      '#title' => $this->t('ISBN'),
      '#description' => $this->t('ISBN of the book for which we trying to fetch the details'),
      '#default_value' => $this->configuration['isbn'],
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['isbn'] = $form_state->getValue('isbn');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $bookTitle = 'Test';
    $configuration = $this->getConfiguration('isbn');
    //$client = new Client(['base_uri' => 'https://www.googleapis.com/books/v1/']);
    //$fetcher = new Fetcher($client);
    //$book = $fetcher->forISBN($configuration['isbn']);
    //$bookTitle = $book->title;
    $build['book_detail_block_isbn']['#markup'] = '<p>' . $bookTitle . '</p>';
    return $build;
  }
}
