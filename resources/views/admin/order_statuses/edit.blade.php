@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.order-status.title')</h3>
    
    {!! Form::model($order_status, ['method' => 'PUT', 'route' => ['admin.order_statuses.update', $order_status->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('observacao', trans('quickadmin.order-status.fields.observacao').'*', ['class' => 'control-label']) !!}
                    {!! Form::textarea('observacao', old('observacao'), ['class' => 'form-control ', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('observacao'))
                        <p class="help-block">
                            {{ $errors->first('observacao') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('data', trans('quickadmin.order-status.fields.data').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('data', old('data'), ['class' => 'form-control datetime', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('data'))
                        <p class="help-block">
                            {{ $errors->first('data') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent

    <script src="{{ url('adminlte/plugins/datetimepicker/moment-with-locales.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(function(){
            moment.updateLocale('{{ App::getLocale() }}', {
                week: { dow: 1 } // Monday is the first day of the week
            });
            
            $('.datetime').datetimepicker({
                format: "{{ config('app.datetime_format_moment') }}",
                locale: "{{ App::getLocale() }}",
                sideBySide: true,
            });
            
        });
    </script>
            
@stop