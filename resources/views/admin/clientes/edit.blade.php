@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.clientes.title')</h3>

    {!! Form::model($cliente, ['method' => 'PUT', 'route' => ['admin.clientes.update', $cliente->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name', trans('quickadmin.clientes.fields.name').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('email', trans('quickadmin.clientes.fields.email').'', ['class' => 'control-label']) !!}
                    {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('email'))
                        <p class="help-block">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('email_alternative', trans('quickadmin.clientes.fields.email-alternative').'', ['class' => 'control-label']) !!}
                    {!! Form::email('email_alternative', old('email_alternative'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('email_alternative'))
                        <p class="help-block">
                            {{ $errors->first('email_alternative') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('phone', trans('quickadmin.clientes.fields.phone').'', ['class' => 'control-label']) !!}
                    {!! Form::text('phone', old('phone'), ['class' => 'form-control phone-mask', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('phone'))
                        <p class="help-block">
                            {{ $errors->first('phone') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('company_id', trans('quickadmin.clientes.fields.company').'*', ['class' => 'control-label']) !!}
                    {!! Form::select('company_id', $companies, old('company_id'), ['class' => 'form-control select2', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('company_id'))
                        <p class="help-block">
                            {{ $errors->first('company_id') }}
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop
