let $ = require('jquery');

const {getRoute, trans, httpRequest} = require('../common');
let $submit = $("button#ask_of_quote_submit");
import 'bootstrap-datepicker';

$(document).ready(function () {
    $('#quotation-form').find('select').css('display', 'block');
    $('#quotation-form').find('.nice-select').css('display', 'none');
    updateProduct();

    $('.js-datepicker').datepicker({
        format: 'mm/dd/yyyy',
        language: 'fr',
        startDate: '"01-01-2020")'
    });


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

const updateProduct = () => {

    let selectProduct = $("select.add-product");

    selectProduct.change((event) => {
        let $thisSelectProduct = $(event.target);
        let $quotationLine  = $thisSelectProduct.parent().parent();
        let $quantityField  = $quotationLine.find('.quantity');
        let $ttcField       = $quotationLine.find('.ttc');
        let $unitPriceField = $quotationLine.find('.unitPrice');
        let $discountField  = $quotationLine.find('.discount');
        let $htField        = $quotationLine.find('.ht');
        let $vatField        = $quotationLine.find('.vat');

       let  quantityVal  = $quantityField.val();
       let  ttcVal       = $ttcField.val();
       let  unitPriceVal = $unitPriceField.val();
       let  discountVal  = $discountField.val();
       let  htVal       = $htField.val();
       let  vatVal       = $vatField.val();

            let ajaxData = {
                quantityVal,
                ttcVal,
                unitPriceVal,
                discountVal,
                htVal,
                vatVal,
            }


        let $formDatas = $('form').serialize();
        //select
        let $selectVal = $thisSelectProduct.val()
        // remise
        let $discount = $('#quotation_quotationLine_1_discount').val()
        //quantité
        let $quantity = $('this').parent().find('.quantity').val()
        console.log($quantity);
        let route = getRoute('search_product', {'id': $selectVal});

        $.ajaxSetup({
            url: route,
            global: false,
            type: "POST"
        });
        $.ajax({data: {ajaxData}});

        $.post(route, {ajaxData}, (data) => {
            console.log(data);
            $ttcField.val(data.ttc).append('ttc')
            $unitPriceField.val(data.unitPrice)
            $discountField.val()
            $htField.val(data.ht)
        })
    });
}