let $ = require('jquery');
let select2 = require('select2');
const {getRoute, trans, httpRequest} = require('../common');
console.log(httpRequest);

$(document).ready(function () {
    let clientSelect = $('form#new-Quotation-form').find('select#Quotation_client');
    clientSelect.select2();
    clientSelect.on('select2:select', function (e) {
        console.log(clientSelect);
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
