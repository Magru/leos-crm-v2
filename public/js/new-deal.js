"use strict";

$(document).ready(function() {
    let selectInstance = $('#client').select2({
        minimumInputLength: 3,
        dir: "rtl",
        initSelection: function(element, callback) {

        },
        language: {
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

    $('#new-client').click(function (e){
        e.preventDefault();
        selectInstance.val(null).trigger('change');
        $('#new_client_modal').modal('show');
    });

    $('#remote-add-client').on('submit', function (e){
        e.preventDefault();
        $('#remote-add-loader').addClass('loading');

        const formData = $('.has-repeater').repeaterVal();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('#remote-add-client [name="_token"]').val()
            },
            method: 'POST',
            url: '/clients/add-client-from-deal',
            data: {
                name: formData.name,
                contact_persons: formData.contact_persons,
                rank: formData.rank
            },
            dataType: 'json',
            success: function (data) {
                $('#remote-add-loader').removeClass('loading');
                var newOption = new Option(data.name, data.id, false, false);
                selectInstance.append(newOption).trigger('change');
                $('#new_client_modal').modal('hide');
            }
        });
    })

});
