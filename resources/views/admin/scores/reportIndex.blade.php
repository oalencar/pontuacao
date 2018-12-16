@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.score.report')</h3>


    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <select class="form-control">
                    <option>option 1</option>
                    <option>option 2</option>
                    <option>option 3</option>
                    <option>option 4</option>
                    <option>option 5</option>
                </select>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body">

        </div>
    </div>
@stop

@section('javascript')
    <script>
    </script>
@endsection
