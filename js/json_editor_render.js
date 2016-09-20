(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.easychartRender = {
    attach: function(context, settings) {

      if (settings.json_editor != undefined) {
        var json_editors = settings.json_editor;

        $.each(json_editors, function(key, value) {
          for (var i = 0; i < json_editors[key].length; i++) {
            var $container = $('.json_editor-render--' +  key  +'-' +  i)[0];
            var json_data = JSON.parse(json_editors[key][i].json_data);
            $container.innerHTML = JSON.stringify(json_data, null, 2);
          }

        });
      }
    }
  }

})(jQuery, Drupal);
