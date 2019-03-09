@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.partner.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.partners.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name', trans('quickadmin.users.fields.name').'*', ['class' => 'control-label']) !!}
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
                    {!! Form::label('email', trans('quickadmin.users.fields.email').'*', ['class' => 'control-label']) !!}
                    {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
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
                    {!! Form::label('password', trans('quickadmin.users.fields.password').'*', ['class' => 'control-label']) !!}
                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('password'))
                        <p class="help-block">
                            {{ $errors->first('password') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('partner_type_id', trans('quickadmin.partner.fields.partner-type').'', ['class' => 'control-label']) !!}
                    {{--{!! Form::select('partner_type_id', $partner_types, old('partner_type_id'), ['class' => 'form-control']) !!}--}}
                    <select name="partner_type_id" id="partner_type_id" class="form-control">
                        @foreach($partner_types as $partner_type)
                            <option value="{{ $partner_type->id }}">{{ $partner_type->getFullDescription() }}</option>
                        @endforeach
                    </select>
                    <p class="help-block"></p>
                    @if($errors->has('partner_type_id'))
                        <p class="help-block">
                            {{ $errors->first('partner_type_id') }}
                        </p>
                    @endif
                </div>
            </div>

            {{ Form::hidden('role_id', $partner_role_id) }}

        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

