@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.score.report')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Filtrar</strong>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('admin.scores.reportByCompanyName') }}" id="formulario-filtro">
                <div class="row">
                    <div class="col-xs-10 col-md-6">
                        <div class="form-group">
                            <label for="select-company">Empresa *</label>
                            <select class="form-control" name="company" id="select-company">
                                <option value="">Selecione</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" id="btn-filter">Filtrar</button>
                        </div>
                    </div>
                </div>

                {{ @csrf_field() }}
            </form>
        </div>
    </div>



@stop

@section('javascript')
    <script>
        $('#btn-filter').on('click', (e) => {
            let option = $('#select-company').val();
            if (!option || option === undefined) {
                alert('Necessário selecionar o campo');
                return;
            }
            $('#formulario-filtro').submit();
        })
    </script>
@endsection
