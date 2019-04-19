@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">Relatório por Parceiros</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Parceiros</strong>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">

                    <div class="panel-body table-responsive">
                        <table class="table table-bordered table-striped {{ count($partners) > 0 ? 'datatable' : '' }}">
                            <thead>
                            <tr>
                                <th>@lang('quickadmin.users.fields.name')</th>
                                <th>@lang('quickadmin.users.fields.email')</th>
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


                                        <td field-key='nome'>{{ $partner->user->name or '' }}</td>
                                        <td field-key='user'>{{ $partner->user->email or '' }}</td>
                                        @if( request('show_deleted') == 1 )
                                            <td>
                                                @can('score_delete')
                                                    {!! Form::open(array(
                                                        'style' => 'display: inline-block;',
                                                        'method' => 'POST',
                                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                                        'route' => ['admin.scores.restore', $partner->id])) !!}
                                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                                    {!! Form::close() !!}
                                                @endcan
                                                @can('score_delete')
                                                    {!! Form::open(array(
                                                        'style' => 'display: inline-block;',
                                                        'method' => 'DELETE',
                                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                                        'route' => ['admin.scores.perma_del', $partner->id])) !!}
                                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                                    {!! Form::close() !!}
                                                @endcan
                                            </td>
                                        @else
                                            <td>
                                                @can('score_view')
                                                    <a href="{{ route('admin.scores.report_partner_detail',[$partner->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
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
            </div>
        </div>
    </div>



@stop

@section('javascript')
    <script>
        $('#btn-filter').on('click', (e) => {
            let option = $('#select-company').val();
            if (!option || option === undefined) {
                alert('Necessário selecionar o campo');
                return;
            }
            $('#formulario-filtro').submit();
        })
    </script>
@endsection
