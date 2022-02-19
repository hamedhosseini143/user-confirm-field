<?php

namespace Drupal\user_conf\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\user\Entity\User;

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
        $user = User::load($item->user);
        $link = Link::fromTextAndUrl($user->realname, Url::fromRoute('entity.user.canonical', ['user' => 1]));
        $element[$delta]['confirm'] = [
          '#type' => 'item',
          '#title' => $this->t('user'),
          '#markup' => $link->toString(),
        ];
      }

      $element[$delta]['confirm'] = [
        '#type' => 'item',
        '#title' => $this->t('confirm'),
        '#markup' => $item->confirm ? $this->t('Yes') : $this->t('No'),
      ];

    }

    return $element;
  }

}
