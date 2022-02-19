<?php

namespace Drupal\user_conf\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\user_conf\Plugin\Field\FieldType\UserConfirmFieldItem;

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
    $header[] = $this->t('Value 2');

    $table = [
      '#type' => 'table',
      '#header' => $header,
    ];

    foreach ($items as $delta => $item) {
      $row = [];

      $row[]['#markup'] = $delta + 1;

      if ($item->confirm) {
        $allowed_values = UserConfirmFieldItem::allowedUserValues();
        $row[]['#markup'] = $allowed_values[$item->confirm];
      }
      else {
        $row[]['#markup'] = '';
      }

      $row[]['#markup'] = $item->value_2 ? $this->t('Yes') : $this->t('No');

      $table[$delta] = $row;
    }

    return [$table];
  }

}
