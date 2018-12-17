@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.score.report')</h3>


    <div class="row">
        <form method="POST" action="{{ route('admin.scores.reportByCompanyName') }}">
            <div class="col-xs-10 col-md-6">
                <div class="form-group">
                    <select class="form-control" name="company">
                        <option>Selecione </option>
                        @foreach($companies as $c)
                            @if(isset($company))
                                <option {{ $company->id == $c->id ? 'selected' : '' }} value="{{ $c->id }}">{{ $c->nome }}</option>
                            @else
                                <option value="{{ $c->id }}">{{ $c->nome }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-2 col-md-2">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>

            {{ @csrf_field() }}
        </form>
    </div>

    @foreach($awards as $award)


        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $award->title }}</h3>
                        <span class="label label-primary pull-right">{{ $award->partner_type->description }}</span>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>Nome</th>
                                <th>Pontuação</th>
                                <th style="width: 100px">Detalhes</th>
                            </tr>

                            @foreach($award->partners as $partner)
                                <tr>
                                    <td>{{ $partner->user->name }}</td>
                                    <td>{{ $partner->totalScore }}</td>
                                    <td><a href="{{ route('admin.scores.report_detail', ['id'=> $partner->user_id]) }}">Detalhe</a></td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                    </div>
                </div>
                <!-- /.box -->

            </div>
        </div>
        <!-- /.row -->


    @endforeach
@stop

@section('javascript')
    <script>
    </script>
@endsection
