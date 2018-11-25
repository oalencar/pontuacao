@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.order-status.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.order-status.fields.observacao')</th>
                            <td field-key='observacao'>{!! $order_status->observacao !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.order-status.fields.data')</th>
                            <td field-key='data'>{{ $order_status->data }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.order_statuses.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop

@section('javascript')
    @parent

    <script src="{{ url('adminlte/plugins/datetimepicker/moment-with-locales.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(function(){
            moment.updateLocale('{{ App::getLocale() }}', {
                week: { dow: 1 } // Monday is the first day of the week
            });
            
            $('.datetime').datetimepicker({
                format: "{{ config('app.datetime_format_moment') }}",
                locale: "{{ App::getLocale() }}",
                sideBySide: true,
            });
            
        });
    </script>
            
@stop
