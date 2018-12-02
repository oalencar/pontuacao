<hr>

<div class="row">
    <div class="col-xs-12 col-md-6 form-group">
        {!! Form::label('orderStatus', trans('quickadmin.order-status.title').'', ['class' => 'control-label']) !!}

        <table id="order-list" class="table">
            <thead>
            <tr>
                <td>Descrição</td>
                <td>Data</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="col-sm-4">
                    <input type="text" name="observacao" class="form-control" />
                </td>
                <td class="col-sm-4">

                    <div class="form-group">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right datepicker">
                        </div>
                        <!-- /.input group -->
                    </div>

                </td>
                <td class="col-sm-2">
                    <a class="deleteRow"></a>
                </td>
            </tr>
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
