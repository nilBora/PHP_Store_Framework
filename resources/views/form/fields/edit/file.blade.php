<div class="form-group">
    <label for="customFile">{{$field->getCaption()}}</label>
    <div class="custom-file">
        <input type="file"
               class="custom-file-input"
               id="customFile_{{$field->getName()}}"
               name="{{$field->getName()}}"
               value="{{ $field->getValue() }}" />
        <label class="custom-file-label" for="customFile_{{$field->getName()}}">Choose file</label>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        bsCustomFileInput.init();
    });
</script>
