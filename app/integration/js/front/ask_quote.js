let $ = require('jquery');
let $submit = $("button#ask_of_quote_submit");
$(document).ready(function () {
$(".faq-form.ask-quote").find('form').submit((e)=>{
    let $data = $(this).find('#ask_of_quote_materialNumber').val();
    console.log($data);
})

});
