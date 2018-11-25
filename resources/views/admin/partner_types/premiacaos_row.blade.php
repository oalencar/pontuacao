<tr data-index="{{ $index }}">
    <td>{!! Form::text('premiacaos['.$index.'][title]', old('premiacaos['.$index.'][title]', isset($field) ? $field->title: ''), ['class' => 'form-control']) !!}</td>
<td>{!! Form::number('premiacaos['.$index.'][goal]', old('premiacaos['.$index.'][goal]', isset($field) ? $field->goal: ''), ['class' => 'form-control']) !!}</td>

    <td>
        <a href="#" class="remove btn btn-xs btn-danger">@lang('quickadmin.qa_delete')</a>
    </td>
</tr>