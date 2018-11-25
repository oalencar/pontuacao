@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.partner.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.partner.fields.company')</th>
                            <td field-key='company'>{{ $partner->company->nome or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.partner.fields.user')</th>
                            <td field-key='user'>{{ $partner->user->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.partner.fields.partner-type')</th>
                            <td field-key='partner_type'>{{ $partner->partner_type->description or '' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.partners.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop


