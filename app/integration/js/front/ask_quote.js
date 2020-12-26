let $ = require('jquery');
let $submit = $("button#ask_of_quote_submit");
import 'bootstrap-datepicker';
$(document).ready(function () {
    $('.js-datepicker').datepicker({
        format: 'dd-mm-yyyy',
        language: 'fr'
    });
})

