import { fromPromise } from 'rxjs/internal/observable/fromPromise';

/**
 * Represents a book.
 * @constructor
 * @param {string} codigo - The title of the book.
 * @param {string} descricao - The author of the book.
 * @param {integer} company_id - The author of the book.
 * @param {integer} client_id - The author of the book.
 * @param {Object[]} score - The author of the book.
 * @param {Object[]} orderStatus - The author of the book.
 */
export class Order {
    get codigo() {
        return this._codigo;
    }

    set codigo(value) {
        this._codigo = value;
    }

    get descricao() {
        return this._descricao;
    }

    set descricao(value) {
        this._descricao = value;
    }

    get company_id() {
        return this._company_id;
    }

    set company_id(value) {
        this._company_id = value;
    }

    get client_id() {
        return this._client_id;
    }

    set client_id(value) {
        this._client_id = value;
    }

    get score() {
        return this._score;
    }

    set score(value) {
        this._score = value;
    }

    get orderStatus() {
        return this._orderStatus;
    }

    set orderStatus(value) {
        this._orderStatus = value;
    }

    constructor(codigo, descricao, company_id, client_id, score, orderStatus) {

        this._codigo = codigo;
        this._descricao = descricao;
        this._company_id = company_id;
        this._client_id = client_id;
        this._score = score;
        this._orderStatus = orderStatus;
    }


    addOrderStatusRow() {
        const newRow = $('<tr>');

        const rowTemplate = `
                <td><input type="text" class="form-control" name="order-status-observacao[]"/></td>
                <td>
                    <div class="input-group date">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    <input type="text" class="form-control pull-right datepicker" name="order-status-data[]">
                </td>
                <td><input type="button" class="ibtnDel btn btn-md btn-danger"  value="Delete"></td>
            `;

        newRow.append(rowTemplate);

        $("table#order-status-list").append(newRow);

        $('.datepicker').datetimepicker({
            format: "DD/MM/YYYY",
            locale: "pt-br"
        });
    }

    /**
     *
     * @param element
     */
    removeRow(element) {
        $(element).closest("tr").remove();
    }

    deleteScore(element) {

        const self = this;

        const inputHidden = $(element).next("input:hidden");

        if (!inputHidden.val()) {
            this.removeRow(element);
            return
        };

        const resposta = window.confirm('Deseja realmente excluir esta pontuação?');

        if (!resposta) return;

        var id = inputHidden.val();
        var token = window._token;

        $.ajax(
            {
                url: `${window.appUrl}/api/v1/scores/${id}`,
                type: 'POST',
                data: {
                    "id": id,
                    "_method": 'DELETE',
                    "_token": token
                }
            }).done(function() {
                self.removeRow(element);
            })
            .fail(function() {
                console.error(err);
                alert('Houve um erro ao excluir a pontuação');
            });

    }

    deleteOrderStatus(element) {

        const self = this;

        const inputHidden = $(element).next("input:hidden");

        if (!inputHidden.val()) {
            this.removeRow(element);
            return
        };

        const resposta = window.confirm('Deseja realmente excluir este andamento?');

        if (!resposta) return;

        var id = inputHidden.val();
        var token = window._token;

        $.ajax(
            {
                url: `${window.appUrl}/api/v1/orderstatuses/${id}`,
                type: 'POST',
                data: {
                    "id": id,
                    "_method": 'DELETE',
                    "_token": token
                }
            }).done(function() {
                self.removeRow(element);
            })
            .fail(function() {
                console.error(err);
                alert('Houve um erro ao excluir a pontuação');
            });

    }

    /**
     *
     * @param companyId
     * @returns { Observable }
     */
    getPartnersCompany(companyId) {
        if (!companyId) return;

        return fromPromise(
            $.get(`${window.appUrl}/api/v1/partners/company/${companyId}`)
        );
    }

    /**
     *
     * @param companyId
     * @returns { Observable }
     */
    getClientsCompany(companyId) {
        if (!companyId) return;

        return fromPromise(
            $.get( `${window.appUrl}/api/v1/clientes/company/${companyId}`)
        );
    }

    /**
     *
     * @param data
     * @returns {array}
     */
    transformResponseToSelectData(data) {

        const newData = $.map(data, function (obj) {
            obj.id = obj.id;
            obj.text = obj.name + ' (' + obj.email + ')';

            return obj;
        });

        return newData;
    }

    createSelect(selector, data) {
        $(selector).select2({
            data: data
        })
    }

    updateSelectValue(item, key, obj) {
        const select = $(obj[key]);
        select.val(item.user_id).trigger('change');
    }

    /**
     *
     * @param element
     */
    addScoreRow() {
        var newRow = $("<tr>");

        const templateRow = `
        <td class="col-sm-6"><select name="score-user-id[]" class="form-control pontuacaoSelect" /></td>
        <td class="col-sm-5"><input type="number" class="form-control" name="score-score[]"/></td>
        <td class="col-sm-1"><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>`;

        newRow.append(templateRow);

        $("table#score-list").append(newRow);

    }

    removeAllScoreRows() {
        $("table#score-list tbody tr").remove();
    }


}
