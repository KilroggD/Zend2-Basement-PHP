/**
 * Select2 Russian translation
 */
(function ($) {
    "use strict";

    $.extend($.fn.select2.defaults, {
        formatNoMatches: function () { return "Совпадений не найдено"; },
        formatInputTooShort: function (input, min) { var n = min - input.length; return "Пожалуйста, введите еще " + n + " символ" + (n == 1 ? "" : ((n > 1)&&(n < 5) ? "а" : "ов")); },
        formatInputTooLong: function (input, max) { var n = input.length - max; return "Пожалуйста, введите на " + n + " символ" + (n == 1 ? "" : ((n > 1)&&(n < 5)? "а" : "ов")) + " меньше"; },
        formatSelectionTooBig: function (limit) { return "Вы можете выбрать не более " + limit + " элемент" + (limit == 1 ? "а" : "ов"); },
        formatLoadMore: function (pageNumber) { return "Загрузка данных..."; },
        formatSearching: function () { return "Поиск..."; },
      createContainer:function(){
               var container = $(document.createElement("div")).attr({
                "class": "select2-container select2-container-multi"
            }).html([
                "    <input type='text' autocomplete='off' autocorrect='off' autocapitalize='off' spellcheck='false' class='select2-input'>",
                "<ul class='select2-choices'>",
                "  <li class='select2-search-field'>",
                "    <label for='' class='select2-offscreen'></label>",
                "  </li>",
                "</ul>",
                "<div class='select2-drop select2-drop-multi select2-display-none'>",
                "   <ul class='select2-results'>",
                "   </ul>",
                "</div>"].join(""));
            return container;
      }


        
    });
    /*
      Select2.class.multi.prototype.createContainer=function(){
               var container = $(document.createElement("div")).attr({
                "class": "select2-container select2-container-multi"
            }).html([
                "    <input type='text' autocomplete='off' autocorrect='off' autocapitalize='off' spellcheck='false' class='select2-input'>",
                "<ul class='select2-choices'>",
                "  <li class='select2-search-field'>",
                "    <label for='' class='select2-offscreen'></label>",
                "  </li>",
                "</ul>",
                "<div class='select2-drop select2-drop-multi select2-display-none'>",
                "   <ul class='select2-results'>",
                "   </ul>",
                "</div>"].join(""));
            return container;
      }
   */


  
})(jQuery);



