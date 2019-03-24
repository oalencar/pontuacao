@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">Relatório Top 10 Parceiros da {{ $company->nome }}</h3>

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
                                <th>Empresa</th>
                                <th>Parceiro</th>
                                <th>Pontuação/Premiação</th>
                                <th>Pontuação total</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($partners as $partner)
                            <tr>
                                <td>{{ $company->nome }}</td>
                                <td>{{ $partner->user->name }}</td>
                                <td>
                                    @foreach($awardService->getPartnerAwards($partner) as $award)
                                        <div>
                                            <strong>
                                                {{ $scoreService->sumOfScores($scoreService->filterPartnerScoresOfAward($partner->scores, $award)) }}
                                                ({{ $scoreService->getPercentReachedGoal($award->goal, $scoreService->sumOfScores($partner->scores)) }}%)
                                            </strong>
                                            -
                                            {{ $award->title }}
                                        </div>
                                    @endforeach
                                </td>
                                <td>{{ $scoreService->sumOfScores($partner->scores) }}</td>
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
