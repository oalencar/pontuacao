@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.orders.title') <small> @lang('quickadmin.qa_create')</small></h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.orders.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
           <strong>Informações</strong>
        </div>

        <div class="panel-body">

            <div class="row">
                <div class="col-xs-12 col-md-6 form-group">
                    {!! Form::label('codigo', trans('quickadmin.orders.fields.codigo').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('codigo', old('codigo'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('codigo'))
                        <p class="help-block">
                            {{ $errors->first('codigo') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-12 col-md-6 form-group">
                    {!! Form::label('start_date', trans('quickadmin.award.fields.start-date').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('start_date', old('start_date'), ['class' => 'form-control date', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('start_date'))
                        <p class="help-block">
                            {{ $errors->first('start_date') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-12 col-md-6 form-group">
                    {!! Form::label('company_id', trans('quickadmin.orders.fields.company').'*', ['class' => 'control-label']) !!}
                    {!! Form::select('company_id', $companies, old('company_id'), ['class' => 'form-control select2', 'id' => 'companySelect', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('company_id'))
                        <p class="help-block">
                            {{ $errors->first('company_id') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-12 col-md-6 form-group">
                    {!! Form::label('client_id', trans('quickadmin.orders.fields.client').'*', ['class' => 'control-label']) !!}
                    {!! Form::select('client_id', [], old('client_id'), ['id'=>'clientsSelect', 'class' => 'form-control select2', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('client_id'))
                        <p class="help-block">
                            {{ $errors->first('client_id') }}
                        </p>
                    @endif
                </div>

            </div>

            <div class="row">
                <div class="col-xs-12 col-md-12 form-group">
                    {!! Form::label('descricao', trans('quickadmin.orders.fields.descricao').'', ['class' => 'control-label']) !!}
                    {!! Form::text('descricao', old('descricao'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('descricao'))
                        <p class="help-block">
                            {{ $errors->first('descricao') }}
                        </p>
                    @endif
                </div>
            </div>

        </div>

    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>{{ trans('quickadmin.orders.fields.score') }}</strong>
        </div>
        <div class="panel-body">
            @include('admin.orders._score')
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>{{ trans('quickadmin.order-status.title') }}</strong>
        </div>
        <div class="panel-body">
            @include('admin.orders._orderstatus')
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    <script src="{{ url('adminlte/plugins/datetimepicker/moment-with-locales.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="{{ mix('js/modules/order/Order.js') }}"></script>
    <script>
        $(function() {

            moment.updateLocale('{{ App::getLocale() }}', {
                week: { dow: 1 } // Monday is the first day of the week
            });

            $('.datepicker').datetimepicker({
                format: "{{ config('app.date_format_moment') }}",
                locale: "{{ App::getLocale() }}",
            });

            $('.date').datetimepicker({
                format: "{{ config('app.date_format_moment') }}",
                locale: "{{ App::getLocale() }}",
            });
        });
    </script>
@endsection
