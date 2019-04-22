@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.clientes.title')</h3>
    @can('cliente_create')
    <p>
        <a href="{{ route('admin.clientes.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>

    </p>
    @endcan

    @can('cliente_delete')
    <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.clientes.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_all')</a></li> |
            <li><a href="{{ route('admin.clientes.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('quickadmin.qa_trash')</a></li>
        </ul>
    </p>
    @endcan


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($clientes) > 0 ? 'datatable' : '' }} @can('cliente_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr>
                        @can('cliente_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        <th>@lang('quickadmin.clientes.fields.name')</th>
                        <th>@lang('quickadmin.clientes.fields.email')</th>
                        <th>@lang('quickadmin.clientes.fields.email-alternative')</th>
                        <th>@lang('quickadmin.clientes.fields.phone')</th>
                        <th>@lang('quickadmin.clientes.fields.company')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @if (count($clientes) > 0)
                        @foreach ($clientes as $cliente)
                            <tr data-entry-id="{{ $cliente->id }}">
                                @can('cliente_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan

                                <td field-key='name'>{{ $cliente->name }}</td>
                                <td field-key='email'>{{ $cliente->email }}</td>
                                <td field-key='email_alternative'>{{ $cliente->email_alternative }}</td>
                                <td field-key='phone'><span class="phone-mask">{{ $cliente->phone }}</span></td>
                                <td field-key='company'>{{ $cliente->company->nome or '' }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('cliente_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.clientes.restore', $cliente->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('cliente_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.clientes.perma_del', $cliente->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('cliente_view')
                                    <a href="{{ route('admin.clientes.show',[$cliente->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('cliente_edit')
                                    <a href="{{ route('admin.clientes.edit',[$cliente->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('cliente_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.clientes.destroy', $cliente->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        @can('cliente_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.clientes.mass_destroy') }}'; @endif
        @endcan

    </script>
@endsection
