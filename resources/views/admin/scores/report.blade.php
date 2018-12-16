@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.score.report')</h3>


    <div class="row">
        <div class="col-xs-12 col-md-6">
            <form action="">
                {{ @csrf_field() }}
                <div class="form-group">
                    <select class="form-control">
                        <option>Selecione </option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body">
            @isset($company)
                {{ $company->nome }}
            @endisset
        </div>
    </div>
@stop

@section('javascript')
    <script>
    </script>
@endsection
