@foreach ($fields as $field)
    @if (!$field->isHide())
        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="{{ $field->getCaption() }}">{{ $field->getCaption() }}</th>
    @endif
@endforeach
<th>Actions</th>
