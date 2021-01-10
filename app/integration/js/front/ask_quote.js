let $ = require('jquery');
import 'bootstrap-datepicker';

let quotationId = $('#quotation-form').data('quotationId')
let $discount = $('.quotation-line-section').find('.discount');
let $vat = $('.quotation-line-section').find('.vat');
let $quantity = $('.quotation-line-section').find('.quantity');
const {getRoute, trans, httpRequest} = require('../common');
let $submit = $("button#ask_of_quote_submit");
var quotationLineId = null;
let amountField = $('#quotation_amount');
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
        startDate: '01-01-2021'
    });
    deleteOption();
    addNewOption();
    changeDiscount();
    changeVat();
    changeQuantity();

})
const addQuotationOptionForm = ($collectionHolder, $newOptionLi) => {
    let prototype = $collectionHolder.data('prototype');
    let index = $collectionHolder.data('index');
    let newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);
    $collectionHolder.data('index', index + 1);
    let $newFormLi = $('<li class="list-unstyled" data-quotation-line-id = "' + quotationLineId + '"></li>').append(newForm);
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
const updateProduct = () => {  // PRODUCT CHANGE
    let selectProduct = $("select.add-product");
    selectProduct.change((event) => {
        let $thisSelectProduct = $(event.target);
        let $ProductId = $thisSelectProduct.val()
        updateQuotationLine($thisSelectProduct.parents().eq(3));
    });
}
const updateQuotationPrices = (data) => {
    let quotationHt =parseFloat(data.quotationHt).toFixed(2);
    let quotationAmount =parseFloat(data.quotationAmount).toFixed(2);
    $('#quotation_amount').val(quotationHt);
    $('#quotation_totalHt').val(quotationAmount);
}
const updateQuotationLine = ($quotationLine) => { // UPDATE QUOTATION LINE
    let $quotationLineId = $quotationLine.data('quotation-line-id');
    let $productId = $quotationLine.find("select.add-product :selected").attr('value');
    if ($productId) {
        let $quantityField = $quotationLine.find('.quantity');
        let $ttcField = $quotationLine.find('.ttc');
        let $unitPriceField = $quotationLine.find('.unitPrice');
        let $discountField = $quotationLine.find('.discount');
        let $htField = $quotationLine.find('.ht');
        let $vatField = $quotationLine.find('.vat');

        let quantityVal = parseInt($quantityField.val());
        let ttcVal = $ttcField.val();
        let unitPriceVal = $unitPriceField.val();
        let discountVal = parseInt($discountField.val());
        let htVal = $htField.val();
        let vatVal = $vatField.val();
        let quotationId = $('#quotation-form').data('quotationId')
        let ajaxData = {
            quantityVal,
            ttcVal,
            unitPriceVal,
            discountVal,
            htVal,
            vatVal,
            quotationId,
        }

        let route = getRoute('search_product', {'productId': $productId, 'quotationLineId': $quotationLineId});

        $.ajaxSetup({
            url: route,
            global: false,
            type: "POST"
        });
        $.ajax({data: {ajaxData}});
        $.post(route, {ajaxData}, (data) => {
            let quotationLineAmount =parseFloat(data.quotationLineAmount).toFixed(2);
            let quotationLineUnitPrice =parseFloat(data.quotationLineUnitPrice).toFixed(2);
            let quotationLineHt =parseFloat(data.quotationLineHt).toFixed(2);
            let quotationLineDiscount =parseInt(data.quotationLineDiscount)

            console.log(data)
           $(data).each((index, value)=>{
                console.log(index, value);
            })
            updateQuotationPrices(data)
            $ttcField.val(quotationLineAmount).attr('value', quotationLineAmount)
            $unitPriceField.val(quotationLineUnitPrice).attr('value', quotationLineUnitPrice)
            $discountField.val(quotationLineDiscount).attr('value', quotationLineDiscount)
            $htField.val(quotationLineHt).attr('value', quotationLineHt)
        });
    } else {
        $htField.val(0).attr('value', 0)
        $unitPriceField.val(0).attr('value', 0)
        $ttcField.val(0).attr('value', 0)
        console.error('product id not found')
    }
}

const changeDiscount = () => {
    $discount.change((e) => {
        let $discountVal = parseInt($(e.target).val());
        let $thisSection = $(e.target).parents().eq(4);
        quotationLineId = $thisSection.data('quotation-line-id');
        updateQuotationLine($thisSection)
    })
}
const changeVat = () => {
    $vat.change((e) => {
        let $vatVal = parseInt($(e.target).val());
        console.log($vatVal)
        let $thisSection = $(e.target).parents().eq(3);
        quotationLineId = $thisSection.data('quotation-line-id');
        updateQuotationLine($thisSection)
    })
}
const changeQuantity = () => {
    $quantity.change((e) => {
        let $vatVal = parseInt($(e.target).val());
        let $thisSection = $(e.target).parents().eq(3);
        quotationLineId = $thisSection.data('quotation-line-id');
        updateQuotationLine($thisSection)
    })
}