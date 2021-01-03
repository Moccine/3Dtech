let $ = require('jquery');
let select2 = require('select2');
const {getRoute, trans, httpRequest} = require('../common');
const clearContactForm = $('#clearContactForm');
$(document).ready(function () {
    let $formClear = Boolean(clearContactForm.data('clearcontactform'));
    console.log($formClear)

    if($formClear){
        clearContactForm.find('form').each((index, value)=>{
            $(value).find('input').val('')
            $(value).find('textarea').val('')
        })
    }
    let clientSelect = $('form#new-Quotation-form').find('select#Quotation_client');
    clientSelect.select2();
    clientSelect.on('select2:select', function (e) {
        $id = $(e.target).val()
        $route = getRoute('client_address', {id: $id})
        $.get($route, (data) => {
            $html = '<ul>'
            for (const property in data) {
                $html += '<li>' + data[property] + '</li>'
            }
            $html += '</ul>';
            $('#client-address').html($html)

        });

    });
});
