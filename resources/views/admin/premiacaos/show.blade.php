@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.premiacao.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.premiacao.fields.title')</th>
                            <td field-key='title'>{{ $premiacao->title }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.premiacao.fields.description')</th>
                            <td field-key='description'>{!! $premiacao->description !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.premiacao.fields.goal')</th>
                            <td field-key='goal'>{{ $premiacao->goal }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.premiacao.fields.start-date')</th>
                            <td field-key='start_date'>{{ $premiacao->start_date }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.premiacao.fields.finish-date')</th>
                            <td field-key='finish_date'>{{ $premiacao->finish_date }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.premiacao.fields.image')</th>
                            <td field-key='image'>@if($premiacao->image)<a href="{{ asset(env('UPLOAD_PATH').'/' . $premiacao->image) }}" target="_blank"><img src="{{ asset(env('UPLOAD_PATH').'/thumb/' . $premiacao->image) }}"/></a>@endif</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.premiacaos.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop

@section('javascript')
    @parent
    <script src="//cdn.ckeditor.com/4.5.4/full/ckeditor.js"></script>
    <script>
        $('.editor').each(function () {
                  CKEDITOR.replace($(this).attr('id'),{
                    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
                    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}'
            });
        });
    </script>

    <script src="{{ url('adminlte/plugins/datetimepicker/moment-with-locales.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(function(){
            moment.updateLocale('{{ App::getLocale() }}', {
                week: { dow: 1 } // Monday is the first day of the week
            });
            
            $('.date').datetimepicker({
                format: "{{ config('app.date_format_moment') }}",
                locale: "{{ App::getLocale() }}",
            });
            
        });
    </script>
            
@stop
