@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.partner-type.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.partner_types.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('description', trans('quickadmin.partner-type.fields.description').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('description', old('description'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('description'))
                        <p class="help-block">
                            {{ $errors->first('description') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('company_id', trans('quickadmin.partner-type.fields.company').'*', ['class' => 'control-label']) !!}
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
    <div class="panel panel-default">
        <div class="panel-heading">
            Premiação
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>@lang('quickadmin.award.fields.title')</th>
                        <th>@lang('quickadmin.award.fields.goal')</th>

                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="award">
                    @foreach(old('awards', []) as $index => $data)
                        @include('admin.partner_types.awards_row', [
                            'index' => $index
                        ])
                    @endforeach
                </tbody>
            </table>
            <a href="#" class="btn btn-success pull-right add-new">@lang('quickadmin.qa_add_new')</a>
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent

    {{--<script type="text/html" id="award-template">--}}
        {{--@include('admin.partner_types.awards_row',--}}
                {{--[--}}
                    {{--'index' => '_INDEX_',--}}
                {{--])--}}
               {{--</script >--}}

            {{--<script>--}}
        {{--$('.add-new').click(function () {--}}
            {{--var tableBody = $(this).parent().find('tbody');--}}
            {{--var template = $('#' + tableBody.attr('id') + '-template').html();--}}
            {{--var lastIndex = parseInt(tableBody.find('tr').last().data('index'));--}}
            {{--if (isNaN(lastIndex)) {--}}
                {{--lastIndex = 0;--}}
            {{--}--}}
            {{--tableBody.append(template.replace(/_INDEX_/g, lastIndex + 1));--}}
            {{--return false;--}}
        {{--});--}}
        {{--$(document).on('click', '.remove', function () {--}}
            {{--var row = $(this).parentsUntil('tr').parent();--}}
            {{--row.remove();--}}
            {{--return false;--}}
        {{--});--}}
        {{--</script>--}}
@stop
