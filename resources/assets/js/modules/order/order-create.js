import {Order} from "./Order";

let empresaId = null;
let selectPartnersData = [];

const order = new Order();


/***********************************************
 SCORE
 ************************************************/

let counterScore = 0;

$("#addScore").on("click", function () {
    order.addScoreRow();
    order.createSelect(selectPartnersData);
});

$("table#score-list").on("click", ".ibtnDel", function (event) {
    order.removeRow(event.target)
});

$('#companySelect').on('select2:select', function (e) {
    const self = this;
    var data = e.params.data;
    if (!data.id) return;
    order.getPartnersCompany(data.id).subscribe(res => {
        const partnersDataTransformed = order.transformResponseToSelectData(res);
        order.createSelect(partnersDataTransformed);
        selectPartnersData = partnersDataTransformed;
    });
});

$("#addrow").on("click", function () {
    order.addOrderStatusRow();
});

$("table#order-status-list").on("click", ".ibtnDel", function (event) {
    order.removeRow(event.target)
});


