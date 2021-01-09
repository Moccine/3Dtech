let $ = require('jquery');
import 'bootstrap-datepicker';

let quotationId = $('#quotation-form').data('quotationId')

const {getRoute, trans, httpRequest} = require('../common');
let $submit = $("button#ask_of_quote_submit");
var quotationLineId = null;
let amountField = $('#quotation_amount');
let depositField = $('#quotation_deposit');
let totalHtField = $('#quotation_totalHt');
let totalAmount = 0;
let totalHt = 0;
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
    let $newFormLi = $('<li class="list-unstyled" data-quotation-line-id = "'+ quotationLineId +'"></li>').append(newForm);
    $newOptionLi.before($newFormLi);
    addOptionFormDeleteLink($newFormLi)

};
const addNewOption = () => {
    // Add new quotation line
    var $collectionHolder;
    var $addOptionButton = $(` 
<div class="row col-lg-12">
           <button type="button" 
            class="add-another-collection-option btn btn-primary-outline main-btn"
            data-list-selector="#option-fields-list"> Ajouter une ligne </button>
            </div> `);
    var $newOptionLi = $('<li class="list-unstyled"></li>').append($addOptionButton);
    $collectionHolder = $('ul.options-block');
    $collectionHolder.append($newOptionLi);
    $collectionHolder.data('index', $collectionHolder.find(':input').length);
    $addOptionButton.on('click', function (e) {
        // creation d'une quotationLine
        createNewQuotationLine().then((data) => {
            quotationLineId = data.id;
            addQuotationOptionForm($collectionHolder, $newOptionLi);
            updateProduct();
        })
    });
};

const createNewQuotationLine = () => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: getRoute('new_quotationLine', {id: quotationId}),
            type: 'GET',
            success: function (data) {
                resolve(data)
            },
            error: function (error) {
                reject(error)
            },
        })
    })
}
const removeQuotationLine = () => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: getRoute('remove_quotationLine', {id: quotationLineId}),
            type: 'GET',
            success: function (data) {
                resolve(data)
            },
            error: function (error) {
                reject(error)
            },
        })
    })
}


const deleteOption = () => {
    $(".delete-link-edit").click((e) => {  // suppresion de quotation option
        quotationLineId = $(e.target).parents(':eq(2)').data('quotationLineId');
        console.log(quotationLineId)
        removeQuotationLine().then((data) => {
            quotationLineId = data.id;
            $((e).target).closest('li.list-unstyled').fadeOut().remove();
            updateQuotationPrices(data)
            updateProduct();
        })
    });
};
const addOptionFormDeleteLink = ($tagFormLi) => {
    let $removeFormButton = $(`
       <a href="javacript:void(0)" 
            class="delete-link ">
               <i class="fa fa-4x fa-trash" style="color: red"
               data-toggle="tooltip"
               data-quotation-line-id = ${quotationLineId}
                data-placement="top"
                title="Supprimer">
               </i>
       </a>
    `);
    $tagFormLi.append($removeFormButton);
    $removeFormButton.on('click', function (e) {
        quotationLineId = $(e.target).parents(':eq(2)').data('quotationLineId');
        removeQuotationLine().then((data) => {
            quotationLineId = data.id;
            $tagFormLi.remove();
            updateQuotationPrices(data)
            updateProduct();
        })
    });
};

const calculateQuotation = () => {

    let quotationLines = $('body').find('form').find('.quotation-line-section')
    $(quotationLines).each((index, sectionsFields) => {
        let $ht = $(sectionsFields).find('.ht');
        let $ttc = $(sectionsFields).find('.ttc');
        totalAmount += parseFloat($ttc)
        totalHt += parseFloat($ht);
    });
    amountField.val(totalAmount);
    totalHtField.val(totalHt);
}
const updateProduct = () => {

    let selectProduct = $("select.add-product");

    selectProduct.change((event) => {
        let $thisSelectProduct = $(event.target);
        let $ProductId = $thisSelectProduct.val()
        let $quotationLine = $(event.target).parents(':eq(3)');
        let $quotationLineId = $quotationLine.data('quotation-line-id');
        console.log($quotationLineId,$quotationLine, $quotationLine.data() )
        let $quantityField = $quotationLine.find('.quantity');
        let $ttcField = $quotationLine.find('.ttc');
        let $unitPriceField = $quotationLine.find('.unitPrice');
        let $discountField = $quotationLine.find('.discount');
        let $htField = $quotationLine.find('.ht');
        let $vatField = $quotationLine.find('.vat');

        let quantityVal = $quantityField.val();
        let ttcVal = $ttcField.val();
        let unitPriceVal = $unitPriceField.val();
        let discountVal = $discountField.val();
        let htVal = $htField.val();
        let vatVal = $vatField.val();
        let quotationId = $('#quotation-form').data('quotationId')
        totalAmount = $ttcField.val() - ttcVal;
        totalHt = $htField.val() - htVal;

        let ajaxData = {
            quantityVal,
            ttcVal,
            unitPriceVal,
            discountVal,
            htVal,
            vatVal,
            quotationId,
        }

        let route = getRoute('search_product', {'productId': $ProductId, 'quotationLineId': $quotationLineId});

        $.ajaxSetup({
            url: route,
            global: false,
            type: "POST"
        });
        $.ajax({data: {ajaxData}});

        $.post(route, {ajaxData}, (data) => {
            console.log(data);
            updateQuotationPrices(data)
            $ttcField.val(data.quotationLineAmount).attr('value', data.quotationLineAmount)
            $unitPriceField.val(data.quotationLineUnitPrice).attr('value', data.quotationLineUnitPrice)
            $discountField.val(data.quotationLineDiscount).attr('value', data.quotationLineDiscount)
            $htField.val(data.quotationLineHt).attr('value', data.quotationLineHt)

        })
        calculateQuotation();


    });


}
const updateQuotationPrices = (data) => {
    $('#quotation_amount').val(data.quotationHt);
    $('#quotation_totalHt').val(data.quotationAmount);
}