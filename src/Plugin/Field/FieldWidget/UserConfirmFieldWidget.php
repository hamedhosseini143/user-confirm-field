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
  public static function defaultSettings() {
    return ['foo' => 'bar'] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $settings = $this->getSettings();
    $element['foo'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Foo'),
      '#default_value' => $settings['foo'],
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $settings = $this->getSettings();
    $summary[] = $this->t('Foo: @foo', ['@foo' => $settings['foo']]);
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $element['confirm'] = [
      '#type' => 'select',
      '#title' => $this->t('user'),
      '#options' => ['' => $this->t('- None -')] + UserConfirmFieldItem::allowedUserValues(),
      '#default_value' => isset($items[$delta]->confirm) ? $items[$delta]->confirm : NULL,
    ];

    $element['value_2'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Value 2'),
      '#default_value' => isset($items[$delta]->value_2) ? $items[$delta]->value_2 : NULL,
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
      if ($value['confirm'] === '') {
        $values[$delta]['confirm'] = NULL;
      }
      if ($value['value_2'] === '') {
        $values[$delta]['value_2'] = NULL;
      }
    }
    return $values;
  }

}
