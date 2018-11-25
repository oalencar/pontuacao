@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.premiacao.title')</h3>
    @can('premiacao_create')
    <p>
        <a href="{{ route('admin.premiacaos.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        
    </p>
    @endcan

    @can('premiacao_delete')
    <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.premiacaos.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_all')</a></li> |
            <li><a href="{{ route('admin.premiacaos.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('quickadmin.qa_trash')</a></li>
        </ul>
    </p>
    @endcan


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($premiacaos) > 0 ? 'datatable' : '' }} @can('premiacao_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr>
                        @can('premiacao_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        <th>@lang('quickadmin.premiacao.fields.title')</th>
                        <th>@lang('quickadmin.premiacao.fields.description')</th>
                        <th>@lang('quickadmin.premiacao.fields.goal')</th>
                        <th>@lang('quickadmin.premiacao.fields.start-date')</th>
                        <th>@lang('quickadmin.premiacao.fields.finish-date')</th>
                        <th>@lang('quickadmin.premiacao.fields.image')</th>
                        <th>@lang('quickadmin.premiacao.fields.partner-type')</th>
                        <th>@lang('quickadmin.premiacao.fields.company')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($premiacaos) > 0)
                        @foreach ($premiacaos as $premiacao)
                            <tr data-entry-id="{{ $premiacao->id }}">
                                @can('premiacao_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan

                                <td field-key='title'>{{ $premiacao->title }}</td>
                                <td field-key='description'>{!! $premiacao->description !!}</td>
                                <td field-key='goal'>{{ $premiacao->goal }}</td>
                                <td field-key='start_date'>{{ $premiacao->start_date }}</td>
                                <td field-key='finish_date'>{{ $premiacao->finish_date }}</td>
                                <td field-key='image'>@if($premiacao->image)<a href="{{ asset(env('UPLOAD_PATH').'/' . $premiacao->image) }}" target="_blank"><img src="{{ asset(env('UPLOAD_PATH').'/thumb/' . $premiacao->image) }}"/></a>@endif</td>
                                <td field-key='partner_type'>{{ $premiacao->partner_type->description or '' }}</td>
                                <td field-key='company'>{{ $premiacao->company->nome or '' }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('premiacao_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.premiacaos.restore', $premiacao->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('premiacao_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.premiacaos.perma_del', $premiacao->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('premiacao_view')
                                    <a href="{{ route('admin.premiacaos.show',[$premiacao->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('premiacao_edit')
                                    <a href="{{ route('admin.premiacaos.edit',[$premiacao->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('premiacao_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.premiacaos.destroy', $premiacao->id])) !!}
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
@stop

@section('javascript') 
    <script>
        @can('premiacao_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.premiacaos.mass_destroy') }}'; @endif
        @endcan

    </script>
@endsection