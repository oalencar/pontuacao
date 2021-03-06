import { Order } from "./Order";

let empresaId = null;
let selectPartnersData = [];

const order = new Order();


/***********************************************
 SCORE
 ************************************************/

$("#addScore").on("click", function () {
    order.addScoreRow();
    if (selectPartnersData.length > 0) {
        order.createSelect('.pontuacaoSelect', selectPartnersData);
        return;
    }
    order.createSelect('.pontuacaoSelect', window.selectPartnersData);
});

$("table#score-list").on("click", ".ibtnDel", function (event) {
    order.deleteScore(event.target)
});

$('#companySelect').on('select2:select', function (e) {
    const self = this;
    var data = e.params.data;
    if (!data.id) return;

    order.getPartnersCompany(data.id).subscribe(res => {
        const partnersDataTransformed = order.transformResponseToSelectScorePartner(res);
        selectPartnersData = partnersDataTransformed;
        order.removeAllScoreRows();
        order.addScoreRow();
        order.createSelect('.pontuacaoSelect', selectPartnersData);
    });

    order.getClientsCompany(data.id).subscribe(res => {
        $('#clientsSelect').empty();
        const clientsData = order.transformResponseToSelectClient(res);
        order.createSelect('#clientsSelect', clientsData);
    })

});

$("#addrow").on("click", function () {
    order.addOrderStatusRow();
});

$("table#order-status-list").on("click", ".ibtnDel", function (event) {
    order.deleteOrderStatus(event.target);
});


