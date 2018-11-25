@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.clientes.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.clientes.fields.name')</th>
                            <td field-key='name'>{{ $cliente->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.clientes.fields.email')</th>
                            <td field-key='email'>{{ $cliente->email }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.clientes.fields.email-alternative')</th>
                            <td field-key='email_alternative'>{{ $cliente->email_alternative }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.clientes.fields.phone')</th>
                            <td field-key='phone'>{{ $cliente->phone }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.clientes.fields.company')</th>
                            <td field-key='company'>{{ $cliente->company->nome or '' }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#orders" aria-controls="orders" role="tab" data-toggle="tab">Pedidos</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="orders">
<table class="table table-bordered table-striped {{ count($orders) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.orders.fields.codigo')</th>
                        <th>@lang('quickadmin.orders.fields.descricao')</th>
                        <th>@lang('quickadmin.orders.fields.company')</th>
                        <th>@lang('quickadmin.orders.fields.client')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($orders) > 0)
            @foreach ($orders as $order)
                <tr data-entry-id="{{ $order->id }}">
                    <td field-key='codigo'>{{ $order->codigo }}</td>
                                <td field-key='descricao'>{{ $order->descricao }}</td>
                                <td field-key='company'>{{ $order->company->nome or '' }}</td>
                                <td field-key='client'>{{ $order->client->name or '' }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('order_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.orders.restore', $order->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('order_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.orders.perma_del', $order->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('order_view')
                                    <a href="{{ route('admin.orders.show',[$order->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('order_edit')
                                    <a href="{{ route('admin.orders.edit',[$order->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('order_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.orders.destroy', $order->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="9">@lang('quickadmin.qa_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
</div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.clientes.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop


