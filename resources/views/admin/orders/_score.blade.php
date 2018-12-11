<hr>

<div class="row">
    <div class="col-xs-12 col-md-6 form-group">
        {!! Form::label('score', trans('quickadmin.orders.fields.score').'', ['class' => 'control-label']) !!}
        <table id="score-list" class="table">
            <thead>
            <tr>
                <td>Parceiro</td>
                <td>Pontos</td>
            </tr>
            </thead>
            <tbody>
            @if(isset($scores))
                @foreach($scores as $score)
                    <tr>
                        <td class="col-sm-4">
                            <select name="score-user-id[]" class="form-control pontuacaoSelect" value="{{ $score->user_id }}"/>
                        </td>
                        <td class="col-sm-4">
                            <input type="number" name="score-score[]" class="form-control" value="{{ $score->score }}"/>
                        </td>
                        <td><input type="button" class="ibtnDel btn btn-md btn-danger"  value="Delete"></td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="col-sm-4">
                        <select name="score-user-id[]" class="form-control pontuacaoSelect" />
                    </td>
                    <td class="col-sm-4">
                        <input type="number" name="score-score[]" class="form-control"/>
                    </td>
                    <td><input type="button" class="ibtnDel btn btn-md btn-danger"  value="Delete"></td>
                </tr>
            @endif
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
