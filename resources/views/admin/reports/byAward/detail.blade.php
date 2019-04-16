<?php
/**
 * @var $award \App\Award
 * @var $reportAward \App\Models\DTO\ReportAwardDTO
 */
?>

@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">Relatório {{ $award->title }}</h3>

    <div class="row">
        <div class="col-md-12">

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Usuário</th>
                                <th>Pontuação/Premiação</th>
                                <th>Pontuação total</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach($reportAwards as $reportAward)
                            <tr>
                                <td>{{ $reportAward->getUser()->name }}</td>
                                <td>
                                    <table>
                                        @foreach($reportAward->getPartners() as $partner)
                                            <tr>
                                                <td>{{ $partner->partner_type->getFullDescription() }}</td>
                                                <td>
                                                {{ $scoreService->formataPontuacao(
                                                    $scoreService->sumOfScores($scoreService->filterPartnerScoresOfAward($partner->scores, $award))
                                                )}}
                                                </td>
                                            </tr>

                                        @endforeach
                                    </table>
                                </td>
                                <td>{{ $scoreService->formataPontuacao($reportAward->getTotal()) }} ({{ $scoreService->getPercentReachedGoal($award->goal, $reportAward->getTotal())  }}%)</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
@stop

@section('javascript')
    <script>

        $(function () {
            $('#companies').on('change', function (e) {
               if (e.target.value != "") {
                   window.location.href = e.target.value;
               }
            });
        })
    </script>
@endsection
