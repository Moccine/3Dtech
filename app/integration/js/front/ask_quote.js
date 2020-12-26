let $ = require('jquery');

const {getRoute, trans, httpRequest} = require('../common');
let $submit = $("button#ask_of_quote_submit");
import 'bootstrap-datepicker';
$(document).ready(function () {
    $('.js-datepicker').datepicker({
        format: 'dd-mm-yyyy',
        language: 'fr'
    });
$('.quotation-form').find('select').css('display', 'block');
$('.quotation-form').find('.nice-select').css('display', 'none');

    deleteOption();
    addNewOption();

})
const addQuotationOptionForm = ($collectionHolder, $newOptionLi) => {
    let prototype = $collectionHolder.data('prototype');
    let index = $collectionHolder.data('index');
    let newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);
    $collectionHolder.data('index', index + 1);
    let $newFormLi = $('<li class="list-unstyled"></li>').append(newForm);
    $newOptionLi.before($newFormLi);
    addOptionFormDeleteLink($newFormLi)

};
const addNewOption = () => {
    // Add new quotation line
    var $collectionHolder;
    var $addOptionButton = $(` 
           <button type="button" 
            class="add-another-collection-option btn btn-primary-outline"
            data-list-selector="#option-fields-list"> Ajouter iune ligne </button> `);
    var $newOptionLi = $('<li class="list-unstyled"></li>').append($addOptionButton);
    $collectionHolder = $('ul.options-block');
    $collectionHolder.append($newOptionLi);
    $collectionHolder.data('index', $collectionHolder.find(':input').length);
    $addOptionButton.on('click', function (e) {
        addQuotationOptionForm($collectionHolder, $newOptionLi);
    });
};
const deleteOption = () => {
    $(".delete-link-edit").click((e) => {  // suppresion de quotation option
        $((e).target).closest('li.list-unstyled').fadeOut().remove();
    });
};
const addOptionFormDeleteLink = ($tagFormLi) => {
    let $removeFormButton = $(`
       <a href="javacript:void(0)" class="delete-link" style="float: right">
                                                <i class="icon-trash" data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="{{ 'app.label.product_delete'|trans }}"></i>
                                            </a>
    `);
    $tagFormLi.append($removeFormButton);
    $removeFormButton.on('click', function (e) {
        $tagFormLi.remove();
    });
};