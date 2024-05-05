/**
 * Select2 Chinese translation
 */
(function ($) {
    "use strict";
    $.extend($.fn.select2.defaults, {
        formatNoMatches: function () { return "Can't find it"; },
        formatInputTooShort: function (input, min) { var n = min - input.length; return "Please input" + n + "characters";},
        formatInputTooLong: function (input, max) { var n = input.length - max; return "Please delete" + n + "characters";},
        formatSelectionTooBig: function (limit) { return "You can choose" + limit ; },
        formatLoadMore: function (pageNumber) { return "loading..."; },
        formatSearching: function () { return "Searching.."; }
    });
})(jQuery);
