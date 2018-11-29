@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.orders.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.orders.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>


        <div class="panel-body">

            <div class="row">
                <div class="col-xs-12 col-md-12 form-group">
                    {!! Form::label('codigo', trans('quickadmin.orders.fields.codigo').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('codigo', old('codigo'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('codigo'))
                        <p class="help-block">
                            {{ $errors->first('codigo') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-12 form-group">
                    {!! Form::label('descricao', trans('quickadmin.orders.fields.descricao').'', ['class' => 'control-label']) !!}
                    {!! Form::text('descricao', old('descricao'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('descricao'))
                        <p class="help-block">
                            {{ $errors->first('descricao') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('company_id', trans('quickadmin.orders.fields.company').'*', ['class' => 'control-label']) !!}
                    {!! Form::select('company_id', $companies, old('company_id'), ['class' => 'form-control select2', 'id' => 'companySelect', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('company_id'))
                        <p class="help-block">
                            {{ $errors->first('company_id') }}
                        </p>
                    @endif
                </div>
            </div>

            @include('admin.orders._score')

            @include('admin.orders._orderstatus')

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('client_id', trans('quickadmin.orders.fields.client').'', ['class' => 'control-label']) !!}
                    {!! Form::select('client_id', $clients, old('client_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('client_id'))
                        <p class="help-block">
                            {{ $errors->first('client_id') }}
                        </p>
                    @endif
                </div>
            </div>

            </div>

        </div>
    </div>



    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    <script>


        let empresaId = null;
        let selectPartnersData = [];

        $(document).ready(function () {

            /***********************************************
             STATUS ORDER
             ************************************************/
            let counter = 0;

            $("#addrow").on("click", function () {
                var newRow = $("<tr>");
                var cols = "";

                cols += '<td><input type="text" class="form-control" name="observacao' + counter + '"/></td>';
                cols += '<td><div class="input-group date"><div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="text" class="form-control pull-right datepicker" name="data' + counter + '"></td>';

                cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
                newRow.append(cols);
                $("table.order-list").append(newRow);
                counter++;

                //Date picker
                $('.datepicker').datepicker({
                    autoclose: true
                })
            });



            $("table.order-list").on("click", ".ibtnDel", function (event) {
                $(this).closest("tr").remove();
                counter -= 1
            });

            //Date picker
            $('.datepicker').datepicker({
                autoclose: true
            });

            /***********************************************
             SCORE
             ************************************************/

            let counterScore = 0;

            $("#addScore").on("click", function () {
                var newRow = $("<tr>");
                var cols = "";

                cols += '<td><select name="pontuacao" class="form-control pontuacaoSelect" /></td>';
                cols += '<td><input type="text" class="form-control" name="score' + counterScore + '"/></td>';

                cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
                newRow.append(cols);
                $("table.score-list").append(newRow);
                counterScore++;

            });

            $("table.score-list").on("click", ".ibtnDel", function (event) {
                $(this).closest("tr").remove();
                counterScore -= 1
            });

            $('#companySelect').on('select2:select', function (e) {
                var data = e.params.data;
                if (!data.id) return;
                getPartnersCompany(data.id)
            });

            function getPartnersCompany(companyId) {
                if (!companyId) return;

                $.get('{{ url('/api/v1/partners/company') }}' + '/' + companyId, function( data ) {
                   selectPartnersData = transformResponseToSelectData(data);
                   console.log(selectPartnersData);
                   createSelect();
                });

            }

            function transformResponseToSelectData(data) {

                const newData = $.map(data, function (obj) {
                    obj.id = obj.id;
                    obj.text = obj.name + ' (' + obj.email + ')';

                    return obj;
                });

                return newData;
            }

            function createSelect() {
                $('.pontuacaoSelect').select2({
                    data: selectPartnersData
                })
            }

        });



        function calculateRow(row) {
            var price = +row.find('input[name^="price"]').val();

        }

        function calculateGrandTotal() {
            var grandTotal = 0;
            $("table.order-list").find('input[name^="price"]').each(function () {
                grandTotal += +$(this).val();
            });
            $("#grandtotal").text(grandTotal.toFixed(2));
        }




    </script>
@endsection
