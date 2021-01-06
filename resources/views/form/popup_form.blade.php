@foreach ($itemEntity->getFields() as $field)
    {{$field->fetchByEdit()}}
@endforeach
