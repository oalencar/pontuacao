<?php /** @var $award \App\Models\Award */ ?>
@inject('request', 'Illuminate\Http\Request')
@inject('scoreService', '\App\Services\ScoreService')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">Relatório Por Premiação</h3>

    <div class="row">
        <div class="col-md-12">

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Escolha a premiação:</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="form-group">
                        <select name="companies" id="companies" class="form-control">
                            <option value="">Selecione...</option>
                            @foreach($awards as $award)
                                <option value="{{ route('admin.reports.award.detail', ['id' => $award->id]) }}">{{ $award->title }}</option>
                            @endforeach
                        </select>
                    </div>
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
