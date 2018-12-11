var empresaId = null;
var selectPartnersData = [];

var order = new Order();

/***********************************************
 SCORE
 ************************************************/

$("#addScore").on("click", function () {
    order.addScoreRow();
    order.createSelect(selectPartnersData);
});

$("table#score-list").on("click", ".ibtnDel", function (event) {
    order.removeRow(event.target);
});

$('#companySelect').on('select2:select', function (e) {
    var self = this;
    var data = e.params.data;
    if (!data.id) return;
    order.getPartnersCompany(data.id).subscribe(function (res) {
        var partnersDataTransformed = order.transformResponseToSelectData(res);
        order.createSelect(partnersDataTransformed);
        selectPartnersData = partnersDataTransformed;
    });
    // getPartnersCompanyAndUpdateData(data.id);
});

$("#addrow").on("click", function () {
    order.addOrderStatusRow();
});

$("table#order-status-list").on("click", ".ibtnDel", function (event) {
    order.removeRow(event.target);
});
