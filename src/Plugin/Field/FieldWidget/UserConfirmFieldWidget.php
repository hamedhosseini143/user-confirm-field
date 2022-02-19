<?php

namespace Drupal\user_conf\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user_conf\Plugin\Field\FieldType\UserConfirmFieldItem;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Defines the 'user_confirm_field' field widget.
 *
 * @FieldWidget(
 *   id = "user_confirm_field",
 *   label = @Translation("user confirm field"),
 *   field_types = {"user_confirm_field"},
 * )
 */
class UserConfirmFieldWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $element['user'] = [
      '#type' => 'textfield',
      '#title' => $this->t('user'),
      '#default_value' => isset($items[$delta]->user) ? $items[$delta]->user : NULL,
    ];


    $element['confirm'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('confirm'),
      '#default_value' => isset($items[$delta]->confirm) ? $items[$delta]->confirm : NULL,
    ];

    $element['#theme_wrappers'] = ['container', 'form_element'];
    $element['#attributes']['class'][] = 'user-confirm-field-elements';
    $element['#attached']['library'][] = 'user_conf/user_confirm_field';

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function errorElement(array $element, ConstraintViolationInterface $violation, array $form, FormStateInterface $form_state) {
    return isset($violation->arrayPropertyPath[0]) ? $element[$violation->arrayPropertyPath[0]] : $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    foreach ($values as $delta => $value) {
      if ($value['user'] === '') {
        $values[$delta]['user'] = NULL;
      }
      if ($value['confirm'] === '') {
        $values[$delta]['confirm'] = NULL;
      }
    }
    return $values;
  }

}
