<?php

/**
 * @file
 * Contains \Drupal\json_editor\Plugin\Field\FieldType\JsonEditorItem.
 */

namespace Drupal\json_editor\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;


/**
 * Plugin implementation of the json_editor field type.
 *
 * @FieldType(
 *   id = "json_editor",
 *   module = "json_editor",
 *   label = @Translation("JSON editor"),
 *   category = @Translation("JSON editor item"),
 *   default_widget = "json_editor_default_widget",
 *   default_formatter = "json_editor_default_formatter"
 * )
 */
class JsonEditorItem extends FieldItemBase {

    /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    
    $properties['json_data'] = DataDefinition::create('string')->setLabel(t('JSON'));
    return $properties;
  }

 /**
  * {@inheritdoc}
  */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return array(
      'columns' => array(
        'json_data' => array(
          'type' => 'text',
          'size' => 'big',
          'description' => 'json data for editor',
          'not null' => FALSE,
        ),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('json_data')->getValue();
    return $value === NULL || $value === '';
  }

}
