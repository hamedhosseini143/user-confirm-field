<?php

namespace Drupal\user_conf\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'user_confirm_field' field type.
 *
 * @FieldType(
 *   id = "user_confirm_field",
 *   label = @Translation("user confirm field"),
 *   category = @Translation("General"),
 *   default_widget = "user_confirm_field",
 *   default_formatter = "user_confirm_field_default"
 * )
 */
class UserConfirmFieldItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    if ($this->confirm !== NULL) {
      return FALSE;
    }
    elseif ($this->value_2 == 1) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {

    $properties['confirm'] = DataDefinition::create('integer')
      ->setLabel(t('user'));
    $properties['value_2'] = DataDefinition::create('boolean')
      ->setLabel(t('Value 2'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints() {
    $constraints = parent::getConstraints();

    $options['confirm']['AllowedValues'] = array_keys(UserConfirmFieldItem::allowedUserValues());

    $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();
    $constraints[] = $constraint_manager->create('ComplexData', $options);
    // @todo Add more constraints here.
    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {

    $columns = [
      'confirm' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'value_2' => [
        'type' => 'int',
        'size' => 'tiny',
      ],
    ];

    $schema = [
      'columns' => $columns,
      // @DCG Add indexes here if necessary.
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition) {

    $values['confirm'] = array_rand(self::allowedUserValues());

    $values['value_2'] = (bool) mt_rand(0, 1);

    return $values;
  }

  /**
   * Returns allowed values for 'confirm' sub-field.
   *
   * @return array
   *   The list of allowed values.
   */
  public static function allowedUserValues() {
    return [
      123 => 123,
      456 => 456,
      789 => 789,
    ];
  }

}
