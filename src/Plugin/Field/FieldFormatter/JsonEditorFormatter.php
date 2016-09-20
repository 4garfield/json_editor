<?php

/**
 * @file
 * Contains \Drupal\json_editor\Plugin\Field\FieldFormatter\JsonEditorFormatter.
 */

namespace Drupal\json_editor\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Provides a default json_editor formatter.
 *
 * @FieldFormatter(
 *   id = "json_editor_default_formatter",
 *   module = "json_editor",
 *   label = @Translation("json editor dafault formatter"),
 *   field_types = {
 *     "json_editor"
 *   },
 *   quickedit = {
 *     "editor" = "disabled"
 *   }
 * )
 */
class JsonEditorFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {

    $entity_id = $items->getEntity()->id();
    
    foreach ($items as $delta => $item) {
      $values = $item->getValue();
      $element[$delta] = array(
        '#markup' => '<pre class="json_editor-render--' . $entity_id . '-' . $delta . '"></pre>',
      );
      
      $element['#attached']['drupalSettings']['json_editor'][$entity_id][$delta] = array(
          'json_data' => (!empty($values['json_data'])) ? $values['json_data'] : '',
      );
      $element['#attached']['library'][] = 'json_editor/json_editor.render';
      
    }

    return $element;
  }

}
