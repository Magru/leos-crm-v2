"use strict";

$(document).ready(function() {
    $('#client').select2({
        minimumInputLength: 3,
        dir: "rtl",
        language: {
            // You can find all of the options in the language files provided in the
            // build. They all must be functions that return the string that should be
            // displayed.
            inputTooShort: function () {
                return "הקלד לפחות 3 תווים";
            },
            errorLoading: function (){
                return 'שגיאה. נתקן מחר...'
            },
            searching: function (){
                return 'מחפש'
            },
            noResults: function (){
                return 'לא נמצא'
            },

        },
        placeholder: 'חפש לקוח קיים או הוסף חדש',
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('[name="_token"]').val()
            },
            delay: 250,
            url: '/client/fetch',
            dataType: 'json',
            processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

});
