@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.partner.title')</h3>

    {!! Form::model($partner, ['method' => 'PUT', 'route' => ['admin.partners.update', $partner->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('company_id', trans('quickadmin.partner.fields.company').'*', ['class' => 'control-label']) !!}

                    <select name="company_id[]" id="company_id" required class="form-control select2" multiple="multiple">
                        <option value="">Selecione</option>
                        @foreach($companies as $key => $companyName)
                            <option value="{{ $key }}" {{  $partnerCompanies->contains('id', $key) ? 'selected' : '' }}>{{ $companyName }}</option>
                        @endforeach
                    </select>

                    <p class="help-block"></p>
                    @if($errors->has('company_id'))
                        <p class="help-block">
                            {{ $errors->first('company_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('user_id', trans('quickadmin.partner.fields.user').'', ['class' => 'control-label']) !!}
                    {!! Form::select('user_id', $users, old('user_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block">Vincula a um usuário do sistema</p>
                    @if($errors->has('user_id'))
                        <p class="help-block">
                            {{ $errors->first('user_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('partner_type_id', trans('quickadmin.partner.fields.partner-type').'', ['class' => 'control-label']) !!}
                    {!! Form::select('partner_type_id', $partner_types, old('partner_type_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('partner_type_id'))
                        <p class="help-block">
                            {{ $errors->first('partner_type_id') }}
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

