var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

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
export var Order = function () {
    _createClass(Order, [{
        key: 'codigo',
        get: function get() {
            return this._codigo;
        },
        set: function set(value) {
            this._codigo = value;
        }
    }, {
        key: 'descricao',
        get: function get() {
            return this._descricao;
        },
        set: function set(value) {
            this._descricao = value;
        }
    }, {
        key: 'company_id',
        get: function get() {
            return this._company_id;
        },
        set: function set(value) {
            this._company_id = value;
        }
    }, {
        key: 'client_id',
        get: function get() {
            return this._client_id;
        },
        set: function set(value) {
            this._client_id = value;
        }
    }, {
        key: 'score',
        get: function get() {
            return this._score;
        },
        set: function set(value) {
            this._score = value;
        }
    }, {
        key: 'orderStatus',
        get: function get() {
            return this._orderStatus;
        },
        set: function set(value) {
            this._orderStatus = value;
        }
    }]);

    function Order(codigo, descricao, company_id, client_id, score, orderStatus) {
        _classCallCheck(this, Order);

        this._codigo = codigo;
        this._descricao = descricao;
        this._company_id = company_id;
        this._client_id = client_id;
        this._score = score;
        this._orderStatus = orderStatus;
    }

    _createClass(Order, [{
        key: 'addOrderStatusRow',
        value: function addOrderStatusRow() {
            var newRow = $('<tr>');

            var rowTemplate = '\n                <td><input type="text" class="form-control" name="order-status-observacao[]"/></td>\n                <td>\n                    <div class="input-group date">\n                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>\n                    <input type="text" class="form-control pull-right datepicker" name="order-status-data[]">\n                </td>\n                <td><input type="button" class="ibtnDel btn btn-md btn-danger"  value="Delete"></td>\n            ';

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

    }, {
        key: 'removeRow',
        value: function removeRow(element) {
            $(element).closest("tr").remove();
        }

        /**
         *
         * @param companyId
         * @returns { Observable }
         */

    }, {
        key: 'getPartnersCompany',
        value: function getPartnersCompany(companyId) {
            if (!companyId) return;

            return fromPromise($.get('http://localhost:8000/api/v1/partners/company/' + companyId));
        }

        /**
         *
         * @param data
         * @returns {array}
         */

    }, {
        key: 'transformResponseToSelectData',
        value: function transformResponseToSelectData(data) {

            var newData = $.map(data, function (obj) {
                obj.id = obj.id;
                obj.text = obj.name + ' (' + obj.email + ')';

                return obj;
            });

            return newData;
        }
    }, {
        key: 'createSelect',
        value: function createSelect(data) {
            $('.pontuacaoSelect').select2({
                data: data
            });
        }

        /**
         *
         * @param element
         */

    }, {
        key: 'addScoreRow',
        value: function addScoreRow() {
            var newRow = $("<tr>");

            var templateRow = '\n        <td><select name="score-user-id[]" class="form-control pontuacaoSelect" /></td>\n        <td><input type="number" class="form-control" name="score-score[]"/></td>\n        <td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';

            newRow.append(templateRow);

            $("table#score-list").append(newRow);
        }
    }]);

    return Order;
}();
