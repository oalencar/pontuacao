@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.score.report')</h3>


    <div class="row">
        <form method="POST" action="{{ route('admin.scores.reportByCompanyName') }}">
            <div class="col-xs-10 col-md-6">
                <div class="form-group">
                    <select class="form-control" name="company">
                        <option>Selecione </option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-2 col-md-2">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>

            {{ @csrf_field() }}
        </form>
    </div>

@stop

@section('javascript')
    <script>
    </script>
@endsection
