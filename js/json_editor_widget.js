(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.json_editor_widget = {
    attach: function(context, settings) {

      //var $json_editor_wrapper = $('.json_editor-wrapper');
      var $json_editor_embed = $('.json_editor-embed')[0];
      var $json_editor_data = $('.json_editor-data');

      var options = {
        mode: 'tree',
        onError: function (err) {
          alert(err.toString());
        },
        onChange: function() {
          $json_editor_data.val(JSON.stringify(editor.get()));
        }
      };
      var editor = new JSONEditor($json_editor_embed, options);
      editor.set(JSON.parse( $json_editor_data.val() ));

      var json_editor_load = document.getElementById("json_editor-load_json_file");
      json_editor_load.addEventListener('change', function(e) {
        var file = json_editor_load.files[0];
        var reader = new FileReader();
        reader.onload = function(e) {
          editor.setText(reader.result);
          $json_editor_data.val(JSON.stringify(editor.get()));
        }
        reader.readAsText(file);
      });

    }
  }

})(jQuery, Drupal);
