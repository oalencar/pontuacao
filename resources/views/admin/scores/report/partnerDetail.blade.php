@inject('request', 'Illuminate\Http\Request')
@inject('scoreService', '\App\Services\ScoreService')
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
                    <span class="badge bg-grey">{{ $partner->partner_type->getFullDescription() }}</span>
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
                            <th>Empresa</th>
                            <th>Meta</th>
                            <th>Pontuação</th>
                            <th style="width: 50px"></th>
                        </tr>

                        @foreach($awards as $award)
                            <tr>
                                <td>{{ $award->title }}</td>

                                <td>{{ $award->start_date }} a {{ $award->finish_date }}</td>
                                <td>
                                    @foreach($award->getCompanies() as $aw_comp )
                                        {{ $aw_comp->nome }}
                                        @if(!$loop->last),@endif
                                    @endforeach
                                </td>
                                <td>{{ $award->goal }}</td>
                                <td>
                                    <span class="pull-left" style="display: inline-block; margin-right: 10px">
                                        {{ $scoreService->filterPartnerScoresOfAward($scores, $award)->sum('score') }}
                                    </span>

                                    <div class="progress progress-bar-background-darker" style="margin-top: 0">
                                        @php
                                            $percentGoal = $scoreService->getPercentReachedGoal(
                                                $award->goal,
                                                $scoreService->filterPartnerScoresOfAward($scores, $award)->sum('score'))
                                        @endphp

                                        <div
                                                class="progress-bar progress-bar-success "
                                                role="progressbar" aria-valuenow="40"
                                                aria-valuemin="0" aria-valuemax="100" style="width:{{$percentGoal}}%">
                                            {{ $percentGoal }}%
                                        </div>
                                    </div>

                                </td>


                                <td>

                                    <a href="{{ route('admin.scores.report_partner_award_detail', ['id' => $partner->id, 'id_award' => $award->id]) }}"
                                       class="btn btn-info btn-xs pull-right" style="width: 30px"><i class="fa fa-eye"></i></a>
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
                                <td>{{ $score->order->company->nome }}</td>
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
