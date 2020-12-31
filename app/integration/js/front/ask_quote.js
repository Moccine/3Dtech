let $ = require('jquery');

const {getRoute, trans, httpRequest} = require('../common');
let $submit = $("button#ask_of_quote_submit");
import 'bootstrap-datepicker';

$(document).ready(function () {
    updateProduct();

    $('.js-datepicker').datepicker({
        format: 'mm/dd/yyyy',
        language: 'fr',
        startDate:'"01-01-2020")'
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
            class="add-another-collection-option btn btn-primary-outline main-btn"
            data-list-selector="#option-fields-list"> Ajouter une ligne </button> `);
    var $newOptionLi = $('<li class="list-unstyled"></li>').append($addOptionButton);
    $collectionHolder = $('ul.options-block');
    $collectionHolder.append($newOptionLi);
    $collectionHolder.data('index', $collectionHolder.find(':input').length);
    $addOptionButton.on('click', function (e) {
        addQuotationOptionForm($collectionHolder, $newOptionLi);
        updateProduct();
    });
};
const deleteOption = () => {
    $(".delete-link-edit").click((e) => {  // suppresion de quotation option
        $((e).target).closest('li.list-unstyled').fadeOut().remove();
    });
};
const addOptionFormDeleteLink = ($tagFormLi) => {
    let $removeFormButton = $(`
       <a href="javacript:void(0)" 
            class="delete-link ">
               <i class="fa fa-4x fa-trash" style="color: red"
               data-toggle="tooltip"
                data-placement="top"
                title="Supprimer">
               </i>
       </a>
    `);
    $tagFormLi.append($removeFormButton);
    $removeFormButton.on('click', function (e) {
        $tagFormLi.remove();
    });
};

const updateProduct = () =>{

    let selectProduct = $("#quotation_quotationLine").find("select");
    console.log(selectProduct);

    //let selectProduct = $('.select-product');
    $('#quotation_quotationLine_0_quantity').change( (event) => {
        console.log(event);
    });
    selectProduct.change((event) => {
        let $formDatas = $('form').serialize();
        console.log($formDatas);
        //select
        let $selectVal = $(event.target).val()
        // remise
        let $discount = $('#quotation_quotationLine_1_discount').val()
        //quantité
        let $quantity = $('#quotation_quotationLine_1_quantityt').val()
        let route = getRoute('search_product', {'id': $selectVal});

        $.ajaxSetup({
            url: route,
            global: false,
            type: "GET"
        });
        $.ajax({ data: {$quantity, $discount,} });

        $.get(route, (data) => {
            console.log(data);
            $('#quotation_quotationLine_1_unitPrice').val(data.unitPrice)
            $('#quotation_quotationLine_1_totalHt').val(data.ht)
            $('#quotation_quotationLine_1_amount').val(data.ttc)
            console.log(data);
        })
    });
}