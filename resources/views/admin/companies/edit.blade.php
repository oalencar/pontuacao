@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.companies.title')</h3>
    
    {!! Form::model($company, ['method' => 'PUT', 'route' => ['admin.companies.update', $company->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('nome', trans('quickadmin.companies.fields.nome').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('nome', old('nome'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('nome'))
                        <p class="help-block">
                            {{ $errors->first('nome') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('endereco', trans('quickadmin.companies.fields.endereco').'', ['class' => 'control-label']) !!}
                    {!! Form::textarea('endereco', old('endereco'), ['class' => 'form-control ', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('endereco'))
                        <p class="help-block">
                            {{ $errors->first('endereco') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('telefone', trans('quickadmin.companies.fields.telefone').'', ['class' => 'control-label']) !!}
                    {!! Form::text('telefone', old('telefone'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('telefone'))
                        <p class="help-block">
                            {{ $errors->first('telefone') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            Premiação
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>@lang('quickadmin.premiacao.fields.title')</th>
                        <th>@lang('quickadmin.premiacao.fields.goal')</th>
                        
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="premiacao">
                    @forelse(old('premiacaos', []) as $index => $data)
                        @include('admin.companies.premiacaos_row', [
                            'index' => $index
                        ])
                    @empty
                        @foreach($company->premiacaos as $item)
                            @include('admin.companies.premiacaos_row', [
                                'index' => 'id-' . $item->id,
                                'field' => $item
                            ])
                        @endforeach
                    @endforelse
                </tbody>
            </table>
            <a href="#" class="btn btn-success pull-right add-new">@lang('quickadmin.qa_add_new')</a>
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent

    <script type="text/html" id="premiacao-template">
        @include('admin.companies.premiacaos_row',
                [
                    'index' => '_INDEX_',
                ])
               </script > 

            <script>
        $('.add-new').click(function () {
            var tableBody = $(this).parent().find('tbody');
            var template = $('#' + tableBody.attr('id') + '-template').html();
            var lastIndex = parseInt(tableBody.find('tr').last().data('index'));
            if (isNaN(lastIndex)) {
                lastIndex = 0;
            }
            tableBody.append(template.replace(/_INDEX_/g, lastIndex + 1));
            return false;
        });
        $(document).on('click', '.remove', function () {
            var row = $(this).parentsUntil('tr').parent();
            row.remove();
            return false;
        });
        </script>
@stop