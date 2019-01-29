@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.score.partner_report')</h3>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header">
                    <h3 class="widget-user-username" style="margin-left: 0">
                        {{ $partner->user->name }}</h3>
                    <h5 class="widget-user-desc" style="margin-left: 0">
                        {{ $partner->user->email }}</h5>
                    <span class="badge bg-grey">{{ $partner->partner_type->description }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-12">

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Premiações</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <table class="table">
                        <tbody>
                        <tr>
                            <th>Premiação</th>
                            <th>Período</th>
                            <th>Meta</th>
                            <th>Empresa</th>
                            <th style="width: 100px"></th>
                        </tr>

                        @foreach($awards as $award)
                            <tr>
                                <td>{{ $award->title }}</td>
                                <td>{{ $award->start_date }} a {{ $award->finish_date }}</td>
                                <td>{{ $award->goal }}</td>
                                <td>
                                    @foreach($award->companies as $aw_comp )
                                        {{ $aw_comp->nome }}
                                        @if(!$loop->last),@endif
                                    @endforeach
                                </td>
                                <td>
                                    {{--<a href="{{ route('admin.orders.edit', $award->order->id) }}"--}}
                                       {{--class="btn btn-info btn-xs">Detalhe do pedido</a>--}}
                                </td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>

                </div>
            </div>

        </div>


        <div class="col-md-12">

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Pedidos</h3>
                    <p></p>
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
                                <td>{{ $score->order->company_id }}</td>
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
