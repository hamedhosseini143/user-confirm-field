<?php

namespace Drupal\user_conf\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\user_conf\Plugin\Field\FieldType\UserConfirmFieldItem;

/**
 * Plugin implementation of the 'user_confirm_field_default' formatter.
 *
 * @FieldFormatter(
 *   id = "user_confirm_field_default",
 *   label = @Translation("Default"),
 *   field_types = {"user_confirm_field"}
 * )
 */
class UserConfirmFieldDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    foreach ($items as $delta => $item) {

      if ($item->confirm) {
        $allowed_values = UserConfirmFieldItem::allowedUserValues();
        $element[$delta]['confirm'] = [
          '#type' => 'item',
          '#title' => $this->t('user'),
          '#markup' => $allowed_values[$item->confirm],
        ];
      }

      $element[$delta]['value_2'] = [
        '#type' => 'item',
        '#title' => $this->t('Value 2'),
        '#markup' => $item->value_2 ? $this->t('Yes') : $this->t('No'),
      ];

    }

    return $element;
  }

}
