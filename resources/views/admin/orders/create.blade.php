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
                    {!! Form::select('company_id', $companies, old('company_id'), ['class' => 'form-control select2', 'id' => 'company', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('company_id'))
                        <p class="help-block">
                            {{ $errors->first('company_id') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <select class="js-example-data-ajax" style="width: 100%"></select>
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
            })





            /***********************************************
            SCORE
             ************************************************/

            let counterScore = 0;

            $("#addScore").on("click", function () {
                var newRow = $("<tr>");
                var cols = "";

                cols += '<td><input type="text" class="form-control" name="observacao' + counterScore + '"/></td>';
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
                console.log(data);
                empresaId = data.id;
            });


            $(".js-example-data-ajax").select2({
                ajax: {
                    url: "https://api.github.com/search/repositories",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Search for a repository',
                escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                minimumInputLength: 1,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });

            function formatRepo (repo) {
                if (repo.loading) {
                    return repo.text;
                }

                var markup = "<div class='select2-result-repository clearfix'>" +
                    "<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
                    "<div class='select2-result-repository__meta'>" +
                    "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";

                if (repo.description) {
                    markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
                }

                markup += "<div class='select2-result-repository__statistics'>" +
                    "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + repo.forks_count + " Forks</div>" +
                    "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + repo.stargazers_count + " Stars</div>" +
                    "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> " + repo.watchers_count + " Watchers</div>" +
                    "</div>" +
                    "</div></div>";

                return markup;
            }

            function formatRepoSelection (repo) {
                return repo.full_name || repo.text;
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
