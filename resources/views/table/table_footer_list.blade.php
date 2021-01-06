@foreach ($fields as $field)
    @if (!$field->isHide())
        <th rowspan="1" colspan="1">{{ $field->getCaption() }}</th>
    @endif
@endforeach
<th>Actions</th>
