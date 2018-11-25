@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.partner-type.title')</h3>
    @can('partner_type_create')
    <p>
        <a href="{{ route('admin.partner_types.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
        
    </p>
    @endcan

    @can('partner_type_delete')
    <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.partner_types.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_all')</a></li> |
            <li><a href="{{ route('admin.partner_types.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('quickadmin.qa_trash')</a></li>
        </ul>
    </p>
    @endcan


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($partner_types) > 0 ? 'datatable' : '' }} @can('partner_type_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr>
                        @can('partner_type_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        <th>@lang('quickadmin.partner-type.fields.description')</th>
                        <th>@lang('quickadmin.partner-type.fields.company')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($partner_types) > 0)
                        @foreach ($partner_types as $partner_type)
                            <tr data-entry-id="{{ $partner_type->id }}">
                                @can('partner_type_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan

                                <td field-key='description'>{{ $partner_type->description }}</td>
                                <td field-key='company'>{{ $partner_type->company->nome or '' }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('partner_type_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.partner_types.restore', $partner_type->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('partner_type_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.partner_types.perma_del', $partner_type->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('partner_type_view')
                                    <a href="{{ route('admin.partner_types.show',[$partner_type->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('partner_type_edit')
                                    <a href="{{ route('admin.partner_types.edit',[$partner_type->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('partner_type_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.partner_types.destroy', $partner_type->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('partner_type_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.partner_types.mass_destroy') }}'; @endif
        @endcan

    </script>
@endsection