@if ($isSearch)
    <form action="" method="GET">
    <tr role="row" class="odd">
    @foreach ($fieldsObjects as $field)
        @if ($field->isHide())
            @continue;
        @endif
        <td tabindex="0">
        @if ($field->hasSearch())
            <label>
                <input type="search" name="search[{{$field->getName()}}]" class="form-control form-control-sm" placeholder="" aria-controls="example1">
            </label>
        @endif
        </td>
    @endforeach
        <td>
            <button type="submit" class="btn btn-block btn-primary btn-sm">Search</button>
        </td>
    </tr>
    </form>
@endif
@foreach ($itemsObjects as $row)
    <tr role="row" class="odd">
        @foreach ($row->getFields() as $field)
            @if (!$field->isHide())
                <td tabindex="0" class="sorting_1">{{ $field->fetchByList() }}</td>
            @endif
        @endforeach
        <td>
            <div class="btn-group btn-group-sm">
                <a href="#" class="btn btn-info js-modal-form-edit-open" data-id="{{$row->getID()}}" data-toggle="modal" data-whatever="@mdo"><i class="fas fa-eye"></i></a>
                <a href="#" class="btn btn-danger js-remove-row" data-action="/api/v2/{{$storeName}}/" data-id="{{$row->getID()}}"><i class="fas fa-trash"></i></a>
            </div>
        </td>
    </tr>
@endforeach

@section('formEdit')
    <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-store_name="{{$storeName}}" data-id="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="js-modal-form" method="POST" action="/api/v2/{{$storeName}}/">
                    <div class="modal-body">
                            <!--Modal-->
                    </div>
                    <div class="modal-footer">
                        <span class="error"></span>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary js-modal-form-edit-save">Save</button>
                    </div>
                 </form>
            </div>
        </div>
    </div>
    <script>



    </script>
@endsection

{{--@foreach ($items as $row)--}}
{{--    <tr role="row" class="odd">--}}
{{--        @foreach ($fieldsObjects as $filed)--}}
{{--            @if (!$filed->isHide())--}}
{{--                <td tabindex="0" class="sorting_1">{{ isset($row[$filed->getName()]) ? $row[$filed->getName()] : '' }}</td>--}}
{{--            @endif--}}
{{--        @endforeach--}}
{{--    </tr>--}}
{{--@endforeach--}}
