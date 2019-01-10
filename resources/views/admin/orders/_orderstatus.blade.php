<div class="row">
    <div class="col-xs-12 form-group">
        <table id="order-status-list" class="table">
            <thead>
            <tr>
                <td>Descrição</td>
                <td>Data</td>
            </tr>
            </thead>
            <tbody>
                @if(isset($orderStatuses))
                    @foreach($orderStatuses as $orderStatus)
                    <tr>
                        <td class="col-sm-8">
                            <input
                                type="text"
                                class="form-control"
                                name="order-status-observacao[]"
                                value="{{ $orderStatus->observacao }}"/>
                        </td>
                        <td class="col-sm-3">
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input
                                    type="text"
                                    class="form-control pull-right datepicker"
                                    name="order-status-data[]"
                                    value="{{ $orderStatus->data }}">
                            </div>
                        </td>
                        <td class="col-sm-1">
                            <button type="button" class="ibtnDel btn btn-md btn-danger">Delete</button>
                            <input type="hidden" name="order-status-id[]" value="{{ $orderStatus->id }}" class="edit-orderStatus"/>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="col-sm-8">
                            <input type="text" class="form-control" name="order-status-observacao[]"/>
                        </td>
                        <td class="col-sm-3">
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="text" class="form-control pull-right datepicker" name="order-status-data[]">
                            </div>
                        </td>
                        <td class="col-sm-1">
                            <input type="button" class="ibtnDel btn btn-md btn-danger"  value="Delete">
                        </td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5" style="text-align: left;">
                    <input type="button" class="btn btn-success" id="addrow" value="Adicionar acompanhamento" />
                </td>
            </tr>
            <tr>
            </tr>
            </tfoot>
        </table>

        <p class="help-block"></p>
        @if($errors->has('orderStatus'))
            <p class="help-block">
                {{ $errors->first('orderStatus') }}
            </p>
        @endif
    </div>
</div>
