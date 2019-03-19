@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.orders.title')
        <small>@lang('quickadmin.qa_edit')</small>
    </h3>

    {!! Form::model($order, ['method' => 'PUT', 'route' => ['admin.orders.update', $order->id]]) !!}

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Informações</h3>
        </div>

        <div class="box-body">

            <div class="row">

                <div class="col-xs-6 form-group">
                    {!! Form::label('codigo', trans('quickadmin.orders.fields.codigo').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('codigo', old('codigo'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('codigo'))
                        <p class="help-block">
                            {{ $errors->first('codigo') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-6 form-group">
                    {!! Form::label('start_date', trans('quickadmin.award.fields.start-date').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('start_date', old('start_date'), ['class' => 'form-control date', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('start_date'))
                        <p class="help-block">
                            {{ $errors->first('start_date') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-6 form-group">
                    {!! Form::label('company_id', trans('quickadmin.orders.fields.company').'*', ['class' => 'control-label']) !!}

                    <select name="company_id" class="form-control" readonly>
                        <option value="{{ $order->company_id }}">{{ $order->company->nome }}</option>
                    </select>

                    <p class="help-block"></p>
                    @if($errors->has('company_id'))
                        <p class="help-block">
                            {{ $errors->first('company_id') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-6 form-group">
                    {!! Form::label('client_id', trans('quickadmin.orders.fields.client').'', ['class' => 'control-label']) !!}

                    <select name="client_id" class="form-control" readonly>
                        <option value="{{ $order->client_id }}">{{ $order->client->name }}</option>
                    </select>

                    <p class="help-block"></p>
                    @if($errors->has('client_id'))
                        <p class="help-block">
                            {{ $errors->first('client_id') }}
                        </p>
                    @endif
                </div>

            </div>

            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('descricao', trans('quickadmin.orders.fields.descricao').'', ['class' => 'control-label']) !!}
                    {!! Form::text('descricao', old('descricao'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('descricao'))
                        <p class="help-block">
                            {{ $errors->first('descricao') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-6" style="margin-top: 20px">
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="finished" id="finished">
                                Pedido Finalizado
                            </label>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="box-footer">
            <button type="button" class="btn btn-primary" id="btn-order-register-email">E-mail cadastro de pedido
            </button>
            <button type="button" class="btn btn-primary" id="btn-order-update-email">E-mail atualização de pedido</button>
            <button type="button" class="btn btn-primary" id="btn-order-finish-email">E-mail finalização de pedido</button>
        </div>

    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('quickadmin.orders.fields.score') }}</h3>
        </div>
        <div class="box-body">
            @include('admin.orders._score')
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <strong>{{ trans('quickadmin.order-status.title') }}</strong>
        </div>
        <div class="box-body">
            @include('admin.orders._orderstatus')
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}

    <!-- Modal -->
    <div class="modal fade" id="modalEmailResponse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('javascript')
    <script src="{{ url('adminlte/plugins/datetimepicker/moment-with-locales.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="{{ mix('js/modules/order/Order.js') }}"></script>
    <script>

        var order  = new window.order.Order;

        window.order_id = {{ $order->id }};

        var selectPartnersData = {!! $partners  !!};

        window.selectPartnersData = order.transformResponseToSelectScorePartner(selectPartnersData);

        var scores = [
                @foreach ($scores as $score)
            {
                'partner_id': {{ $score->partner_id }} },
            @endforeach
        ];

        window.scores = scores;

        setEmailModalResponseText = function(text, modal) {
            $(modal).find('.modal-body').text(text);
        };

        showEmailModalResponse = function(text, modal) {
            var newModal = $('#'+ modal).modal();
            setEmailModalResponseText(text, newModal);
            newModal.show();
        };

        $(function () {

            moment.updateLocale('{{ App::getLocale() }}', {
                week: {dow: 1} // Monday is the first day of the week
            });

            $('.datepicker').datetimepicker({
                format: "{{ config('app.date_format_moment') }}",
                locale: "{{ App::getLocale() }}",
            });

            $('.date').datetimepicker({
                format: "{{ config('app.date_format_moment') }}",
                locale: "{{ App::getLocale() }}",
            });

            $('#btn-order-register-email').on('click', function (e) {
                $.ajax(
                    {
                        url: `${window.appUrl}/admin/orders/sendEmail/orderRegister/${window.order_id}`,
                        type: 'GET',
                    }).done(function (res) {
                    showEmailModalResponse('Email enviado com sucesso!', 'modalEmailResponse');
                })
                    .fail(function (err) {
                        console.error(err);
                        alert('Houve um erro ao enviar o email');
                    });
            });

            $('#btn-order-update-email').on('click', function (e) {
                $.ajax(
                    {
                        url: `${window.appUrl}/admin/orders/sendEmail/orderUpdate/${window.order_id}`,
                        type: 'GET',
                    }).done(function (res) {1
                    showEmailModalResponse('Email enviado com sucesso!', 'modalEmailResponse');
                })
                    .fail(function (err) {
                        console.error(err);
                        alert('Houve um erro ao enviar o email');
                    });
            });

            $('#btn-order-finish-email').on('click', function (e) {
                $.ajax(
                    {
                        url: `${window.appUrl}/admin/orders/sendEmail/orderFinish/${window.order_id}`,
                        type: 'GET',
                    }).done(function (res) {
                    showEmailModalResponse('Email enviado com sucesso!', 'modalEmailResponse');
                    console.log(res)
                })
                    .fail(function (err) {
                        console.error(err);
                        alert('Houve um erro ao enviar o email');
                    });
            });



        });


    </script>
@endsection
