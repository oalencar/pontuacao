<tr data-index="{{ $index }}">
    <td>{!! Form::number('premiacaos['.$index.'][goal]', old('premiacaos['.$index.'][goal]', isset($field) ? $field->goal: ''), ['class' => 'form-control']) !!}</td>

    <td>
        <a href="#" class="remove btn btn-xs btn-danger">@lang('quickadmin.qa_delete')</a>
    </td>
</tr>