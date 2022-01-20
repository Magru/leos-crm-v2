"use strict";

$(document).ready(function() {

    const users = $('#user_id').select2({
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
        placeholder: 'בחר נציג',
    })

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
                rank: formData.rank,
                city: formData.city,
                address: formData.address,
                zip: formData.zip
            },
            dataType: 'json',
            success: function (data) {
                $('#remote-add-loader').removeClass('loading');
                var newOption = new Option(data.name, data.id, false, false);
                selectInstance.append(newOption).trigger('change');
                $('#new_client_modal').modal('hide');
            }
        });
    });

    tinymce.init({
        selector: '#order-notes',
        language: 'he_IL',
        directionality: 'rtl',
        height: 400
    });

    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

    elems.forEach(function(html) {
        var switchery = new Switchery(html,{ size: 'small' });
    });

    var changeCheckbox = Array.prototype.slice.call(document.querySelectorAll('.product-switch'));

    changeCheckbox.forEach(function (checkbox){
        checkbox.onchange = function() {
            if(checkbox.checked){
                $('#attr-for-' + checkbox.dataset.id).addClass('show-attribute')
            }else{
                $('#attr-for-' + checkbox.dataset.id).removeClass('show-attribute')
            }
        };
    });

    $('#new-deal-submit').click(function (e){
        e.preventDefault();

        changeCheckbox.forEach(function (checkbox){
            if(checkbox.checked){
                let arr = [];
                $('.prod-' + checkbox.dataset.id + '-attr').each(function (index, item){
                    arr.push({title: $(this).data('name'), value: $(this).val(), type: $(this).data('type')})
                });
                $('input[name="prod-'+checkbox.dataset.id+'-attr-data"]').val(JSON.stringify(arr))
            }
        })

        $('.new-deal-form').submit();
    })





});