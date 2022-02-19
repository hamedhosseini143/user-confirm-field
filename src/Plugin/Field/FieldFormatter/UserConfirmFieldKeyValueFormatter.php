<?php

namespace Drupal\user_conf\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\user\Entity\User;
use Drupal\user_conf\Plugin\Field\FieldType\UserConfirmFieldItem;

/**
 * Plugin implementation of the 'user_confirm_field_key_value' formatter.
 *
 * @FieldFormatter(
 *   id = "user_confirm_field_key_value",
 *   label = @Translation("Key-value"),
 *   field_types = {"user_confirm_field"}
 * )
 */
class UserConfirmFieldKeyValueFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {

    $element = [];

    foreach ($items as $delta => $item) {

      $table = [
        '#type' => 'table',
      ];

      // user.
      if ($item->confirm) {
        $allowed_values = UserConfirmFieldItem::allowedUserValues();

        $user = User::load($item->user);
        $link = Link::fromTextAndUrl($user->realname, Url::fromRoute('entity.user.canonical', ['user' => 1]));
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('user'),
              ],
            ],
            [
              'data' => [
                '#markup' => $link->toString(),
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      // Value 2.
      if ($item->confirm) {
        $table['#rows'][] = [
          'data' => [
            [
              'header' => TRUE,
              'data' => [
                '#markup' => $this->t('confirm'),
              ],
            ],
            [
              'data' => [
                '#markup' => $item->confirm ? $this->t('Yes') : $this->t('No'),
              ],
            ],
          ],
          'no_striping' => TRUE,
        ];
      }

      $element[$delta] = $table;

    }

    return $element;
  }

}
