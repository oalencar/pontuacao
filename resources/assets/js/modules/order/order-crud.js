import {Order} from "./Order";

let empresaId = null;
let selectPartnersData = [];

const order = new Order();


/***********************************************
 SCORE
 ************************************************/

$("#addScore").on("click", function () {
    order.addScoreRow();
    order.createSelect(selectPartnersData);
});

$("table#score-list").on("click", ".ibtnDel", function (event) {
    order.deleteScore(event.target)
});

$('#companySelect').on('select2:select', function (e) {
    const self = this;
    var data = e.params.data;
    if (!data.id) return;
    order.getPartnersCompany(data.id).subscribe(res => {
        const partnersDataTransformed = order.transformResponseToSelectData(res);
        order.removeAllScoreRows();
        order.addScoreRow();
        order.createSelect(partnersDataTransformed);
        selectPartnersData = partnersDataTransformed;
    });
});

$(document).ready(function () {
    const self = this;
    const companyId = $('#companySelect').val();

    if (!companyId) return;

    order.getPartnersCompany(companyId).subscribe(res => {
        const partnersDataTransformed = order.transformResponseToSelectData(res);
        order.createSelect(partnersDataTransformed);
        selectPartnersData = partnersDataTransformed;

        const objs = $('.pontuacaoSelect');

        window.scores.map((item, key) => {
            order.updateSelectValue(item, key, objs);
        })
    });



});

$("#addrow").on("click", function () {
    order.addOrderStatusRow();
});

$("table#order-status-list").on("click", ".ibtnDel", function (event) {
    order.deleteOrderStatus(event.target);
});


