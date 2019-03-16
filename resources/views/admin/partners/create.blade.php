@extends('layouts.app')

@section('content')

    <!-- Modal -->
    <div class="modal fade in" id="selectModal" tabindex="-1" role="dialog" aria-labelledby="selectModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="selectModalLabel">Selecione Usuário Existente</h4>
                </div>
                <div class="modal-body">
                    <select id="userSelect" class="w-100"></select>
                </div>
            </div>
        </div>
    </div>

    <h3 class="page-title">@lang('quickadmin.partner.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.partners.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>

        <div class="panel-body">

            <div class="row">
                <div class="col-xs-12 text-right">
                    <!-- Button trigger modal -->
                    <button
                        type="button"
                        class="btn btn-primary btn-sm"
                        data-toggle="modal"
                        data-target="#selectModal">
                        <i class="fa fa-user-plus"></i>
                        Associar a usuário existente
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name', trans('quickadmin.users.fields.name').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('email', trans('quickadmin.users.fields.email').'*', ['class' => 'control-label']) !!}
                    {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('email'))
                        <p class="help-block">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('password', trans('quickadmin.users.fields.password').'*', ['class' => 'control-label']) !!}
                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('password'))
                        <p class="help-block">
                            {{ $errors->first('password') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('partner_type_id', trans('quickadmin.partner.fields.partner-type').'', ['class' => 'control-label']) !!}
                    {{--{!! Form::select('partner_type_id', $partner_types, old('partner_type_id'), ['class' => 'form-control']) !!}--}}
                    <select name="partner_type_id" id="partner_type_id" class="form-control">
                        @foreach($partner_types as $partner_type)
                            <option value="{{ $partner_type->id }}">{{ $partner_type->getFullDescription() }}</option>
                        @endforeach
                    </select>
                    <p class="help-block"></p>
                    @if($errors->has('partner_type_id'))
                        <p class="help-block">
                            {{ $errors->first('partner_type_id') }}
                        </p>
                    @endif
                </div>
            </div>

            {{ Form::hidden('role_id', $partner_role_id) }}

        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    <script type="text/javascript">

        var allUsers =  [
            @foreach ($users as $user)
                {!! $user !!},
            @endforeach
        ];

        var usersSelectData = [
            @foreach ($users as $user)
                {
                    'id': {{$user->id}},
                    'text' : '{{ $user->name }} ({{ $user->email }})'
                },
            @endforeach
        ];

        $(function () {

            var inputName = $('input[name=name]');
            var inputEmail = $('input[name=email]');

           $('#userSelect').select2({
               data : usersSelectData
           });

            $('#userSelect').on('select2:select', function (e) {
                var selectedId = e.params.data.id;

                var user = allUsers.find( function (item) {
                    return item.id === parseInt(selectedId);
                });

                if (user != undefined) {
                    inputName.val(user.name);
                    inputEmail.val(user.email);
                }
                $('#selectModal').modal('hide');
            });
        });
    </script>
@endsection

