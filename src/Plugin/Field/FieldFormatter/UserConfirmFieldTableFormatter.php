<?php

namespace Drupal\user_conf\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\user\Entity\User;

/**
 * Plugin implementation of the 'user_confirm_field_table' formatter.
 *
 * @FieldFormatter(
 *   id = "user_confirm_field_table",
 *   label = @Translation("Table"),
 *   field_types = {"user_confirm_field"}
 * )
 */
class UserConfirmFieldTableFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {

    $header[] = '#';
    $header[] = $this->t('user');
    $header[] = $this->t('confirm');

    $table = [
      '#type' => 'table',
      '#header' => $header,
    ];

    foreach ($items as $delta => $item) {
      $row = [];

      $row[]['#markup'] = $delta + 1;
      $user = User::load($item->user);
      if ($item->user) {
        $link = Link::fromTextAndUrl($user->realname, Url::fromRoute('entity.user.canonical', ['user' => 1]));
        $row[]['#markup'] = $link->toString();
      }
      else {
        $row[]['#markup'] = '';
      }

      $row[]['#markup'] = $item->confirm ? $this->t('Yes') : $this->t('No');

      $table[$delta] = $row;
    }

    return [$table];
  }

}
