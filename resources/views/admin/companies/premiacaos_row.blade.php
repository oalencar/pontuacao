<tr data-index="{{ $index }}">
    <td>{!! Form::text('awards['.$index.'][title]', old('awards['.$index.'][title]', isset($field) ? $field->title: ''), ['class' => 'form-control']) !!}</td>
<td>{!! Form::number('awards['.$index.'][goal]', old('awards['.$index.'][goal]', isset($field) ? $field->goal: ''), ['class' => 'form-control']) !!}</td>

    <td>
        <a href="#" class="remove btn btn-xs btn-danger">@lang('quickadmin.qa_delete')</a>
    </td>
</tr>
