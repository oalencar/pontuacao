@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.partner-type.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.partner-type.fields.description')</th>
                            <td field-key='description'>{{ $partner_type->description }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.partner-type.fields.company')</th>
                            <td field-key='company'>{{ $partner_type->company->nome or '' }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">

<li role="presentation" class="active"><a href="#partner" aria-controls="partner" role="tab" data-toggle="tab">Parceiros</a></li>
<li role="presentation" class=""><a href="#award" aria-controls="award" role="tab" data-toggle="tab">Premiação</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">

<div role="tabpanel" class="tab-pane active" id="partner">
<table class="table table-bordered table-striped {{ count($partners) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.partner.fields.company')</th>
                        <th>@lang('quickadmin.partner.fields.user')</th>
                        <th>@lang('quickadmin.partner.fields.partner-type')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($partners) > 0)
            @foreach ($partners as $partner)
                <tr data-entry-id="{{ $partner->id }}">
                    <td field-key='company'>{{ $partner->company->nome or '' }}</td>
                                <td field-key='user'>{{ $partner->user->name or '' }}</td>
                                <td field-key='partner_type'>{{ $partner->partner_type->description or '' }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('partner_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.partners.restore', $partner->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('partner_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.partners.perma_del', $partner->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('partner_view')
                                    <a href="{{ route('admin.partners.show',[$partner->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('partner_edit')
                                    <a href="{{ route('admin.partners.edit',[$partner->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('partner_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.partners.destroy', $partner->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8">@lang('quickadmin.qa_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
<div role="tabpanel" class="tab-pane " id="award">
<table class="table table-bordered table-striped {{ count($awards) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.award.fields.title')</th>
                        <th>@lang('quickadmin.award.fields.description')</th>
                        <th>@lang('quickadmin.award.fields.goal')</th>
                        <th>@lang('quickadmin.award.fields.start-date')</th>
                        <th>@lang('quickadmin.award.fields.finish-date')</th>
                        <th>@lang('quickadmin.award.fields.image')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($awards) > 0)
            @foreach ($awards as $award)
                <tr data-entry-id="{{ $award->id }}">
                    <td field-key='title'>{{ $award->title }}</td>
                                <td field-key='description'>{!! $award->description !!}</td>
                                <td field-key='goal'>{{ $award->goal }}</td>
                                <td field-key='start_date'>{{ $award->start_date }}</td>
                                <td field-key='finish_date'>{{ $award->finish_date }}</td>
                                <td field-key='image'>@if($award->image)<a href="{{ asset(env('UPLOAD_PATH').'/' . $award->image) }}" target="_blank"><img src="{{ asset(env('UPLOAD_PATH').'/thumb/' . $award->image) }}"/></a>@endif</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('award_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.awards.restore', $award->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('award_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.awards.perma_del', $award->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('award_view')
                                    <a href="{{ route('admin.awards.show',[$award->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('award_edit')
                                    <a href="{{ route('admin.awards.edit',[$award->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('award_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.awards.destroy', $award->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="13">@lang('quickadmin.qa_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
</div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.partner_types.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop


