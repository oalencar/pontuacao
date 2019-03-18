<div class="row">
    <div class="col-xs-12 form-group">
        <table id="score-list" class="table">
            <thead>
                <tr>
                    <th>Parceiro</th>
                    <th>Pontos</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @if(isset($scores))
                @foreach($scores as $score)
                    <tr>
                        <td class="col-sm-8">
                            <select name="score-partner-id[]" class="form-control" readonly >
                                <option value="{{ $score->partner_id }}">{{ $score->partner->user->name }} ( {{ $score->partner->user->email }} )</option>
                            </select>
                        </td>
                        <td class="col-sm-3">
                            <input type="text" name="score-score[]" class="form-control score-mask" value="{{ $score->score }}" readonly />
                        </td>
                        <td class="col-sm-1">
                            <button type="button" class="ibtnDel btn btn-md btn-danger">Delete</button>
                            <input type="hidden" name="score-id[]" value="{{ $score->id }}" class="edit-score"/>
                        </td>

                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="col-sm-8">
                        <select name="score-partner-id[]" class="form-control pontuacaoSelect" />
                    </td>
                    <td class="col-sm-3">
                        <input type="text" name="score-score[]" class="form-control score-mask"/>
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
