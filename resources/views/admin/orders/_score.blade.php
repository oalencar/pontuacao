<hr>

<div class="row">
    <div class="col-xs-12 col-md-6 form-group">
        {!! Form::label('score', trans('quickadmin.orders.fields.score').'', ['class' => 'control-label']) !!}
        <table id="myTable" class="table score-list">
            <thead>
            <tr>
                <td>Descrição</td>
                <td>Data</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="col-sm-4">
                    <select name="pontuacao" class="form-control pontuacaoSelect" />
                </td>
                <td class="col-sm-4">
                    <input type="text" name="score" class="form-control"/>
                </td>
                <td class="col-sm-2">
                    <a class="deleteRow"></a>
                </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5" style="text-align: left;">
                    <input type="button" class="btn btn-success" id="addScore" value="Adicionar Pontuação" />
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
