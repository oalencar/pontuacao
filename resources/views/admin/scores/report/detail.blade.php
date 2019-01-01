@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.score.partner_report')</h3>

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ $partner->user->name }}</h3>
                    <p>{{ $partner->user->email }}</p>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>Pedido</th>
                            <th>Data</th>
                            <th>Pontuação</th>
                            <th>Empresa</th>
                            <th style="width: 100px"></th>
                        </tr>

                        @foreach($scores as $score)
                            <tr>
                                <td>{{ $score->order->codigo }}</td>
                                <td>{{ $score->order->start_date }}</td>
                                <td>{{ $score->score }}</td>
                                <td>{{ $company->nome }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.edit', $score->order->id) }}"
                                    class="btn btn-info btn-xs">Detalhe do pedido</a>
                                </td>
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
@stop

@section('javascript')
    <script>
    </script>
@endsection
