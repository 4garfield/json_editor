<?php

/**
 * @file
 * Contains \Drupal\json_editor\Plugin\Field\FieldWidget\JsonEditorWidget.
 */

namespace Drupal\json_editor\Plugin\Field\FieldWidget;

use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Provides a default json_editor widget.
 *
 * @FieldWidget(
 *   id = "json_editor_default_widget",
 *   module = "json_editor",
 *   label = @Translation("Json editor widget"),
 *   field_types = {
 *     "json_editor"
 *   }
 * )
 */
class JsonEditorWidget extends WidgetBase {

 /**
  * {@inheritdoc}
  */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $field_name = $items->getFieldDefinition()->getName();
    $entity = $items->getEntity();
    $values = $entity->get($field_name)->getValue();
    
    $element['#attached']['drupalSettings']['json_editor'] = array();
    $element['#attached']['library'][] = 'json_editor/lib.jsoneditor.full';
    $element['#attached']['library'][] = 'json_editor/json_editor.widget';

    $element['container'] = array(
      '#prefix' => '<div class="json_editor-embed">',
      '#suffix' => '</div>',
      '#type' => 'container',
    );
    $json_default_value = '{
        "array": [1, 2, 3],
        "boolean": true,
        "null": null,
        "number": 123,
        "object": {"a": "b", "c": "d"},
        "string": "Hello World"
      }';
    $element['json_data'] = array(
      '#type' => 'hidden',
      '#description' => $this->t('json data for editor'),
      '#default_value' => isset($values[$delta]['json_data']) ? $values[$delta]['json_data'] : $json_default_value,
      '#attributes' => array(
        'class' => array('json_editor-data'),
      ),
      '#element_validate' => array(
        array(get_called_class(), 'validateJsonDataElement')
      ),
    );
    
    $element['json_file_load'] = array(
      '#type' => 'file',
      '#size' => 1048576,
      '#title' => t('Load JSON file'),
      '#attributes' => array(
        'accept' => array('.json'),
        'id' => array('json_editor-load_json_file'),
      ),
    );
    
    return $element;
  }

  public static function validateJsonDataElement($element, FormstateInterface $form_state) {
    $json_value = $element['#value'];
    if( empty($json_value) || strcmp($json_value, '{}')===0 ) {
      $form_state->setError($element, t('Please construct a JSON before saving.'));
    }
  }

}
