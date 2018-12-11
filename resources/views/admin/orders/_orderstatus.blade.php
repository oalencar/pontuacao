<hr>

<div class="row">
    <div class="col-xs-12 col-md-6 form-group">
        {!! Form::label('orderStatus', trans('quickadmin.order-status.title').'', ['class' => 'control-label']) !!}

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
                        <td>
                            <input
                                    type="text"
                                    class="form-control"
                                    name="order-status-observacao[]"
                                    value="{{ $orderStatus->observacao }}"/>
                        </td>
                        <td>
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input
                                    type="text"
                                    class="form-control pull-right datepicker"
                                    name="order-status-data[]"
                                    value="{{ $orderStatus->data }}">
                            </div>
                        </td>
                        <td><input type="button" class="ibtnDel btn btn-md btn-danger"  value="Delete"></td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td><input type="text" class="form-control" name="order-status-observacao[]"/></td>
                        <td>
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="text" class="form-control pull-right datepicker" name="order-status-data[]">
                            </div>
                        </td>
                        <td><input type="button" class="ibtnDel btn btn-md btn-danger"  value="Delete"></td>
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

<hr>
