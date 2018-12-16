@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.companies.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.companies.fields.nome')</th>
                            <td field-key='nome'>{{ $company->nome }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.companies.fields.endereco')</th>
                            <td field-key='endereco'>{!! $company->endereco !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.companies.fields.telefone')</th>
                            <td field-key='telefone'>{{ $company->telefone }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">

<li role="presentation" class="active"><a href="#partner" aria-controls="partner" role="tab" data-toggle="tab">Parceiros</a></li>
<li role="presentation" class=""><a href="#partner_type" aria-controls="partner_type" role="tab" data-toggle="tab">Tipo de Parceiro</a></li>
<li role="presentation" class=""><a href="#orders" aria-controls="orders" role="tab" data-toggle="tab">Pedidos</a></li>
<li role="presentation" class=""><a href="#clientes" aria-controls="clientes" role="tab" data-toggle="tab">Clientes</a></li>
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
<div role="tabpanel" class="tab-pane " id="partner_type">
<table class="table table-bordered table-striped {{ count($partner_types) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
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
<div role="tabpanel" class="tab-pane " id="orders">
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
<div role="tabpanel" class="tab-pane " id="clientes">
<table class="table table-bordered table-striped {{ count($clientes) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
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
                    <td field-key='name'>{{ $cliente->name }}</td>
                                <td field-key='email'>{{ $cliente->email }}</td>
                                <td field-key='email_alternative'>{{ $cliente->email_alternative }}</td>
                                <td field-key='phone'>{{ $cliente->phone }}</td>
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

            <a href="{{ route('admin.companies.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop


