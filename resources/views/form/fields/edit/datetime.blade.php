<div class="form-group">
    <label>{{$field->getCaption()}}:</label>
    <div class="input-group date" data-target-input="nearest">
        <input type="text"
               name="{{$field->getName()}}"
               class="form-control datetimepicker-input {{$field->getClassName()}}"
               id="reservationdate"
               value="{{ $field->getValue() }}"
               data-format="{{ $field->getFormat() }}"/>
        <span class="error invalid-feedback"></span>
        <div class="input-group-append">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
    </div>
</div>

<script>
    jQuery(function() {
        let selector = jQuery('.{{$field->getClassName()}}'),
            format = selector.data('format');

        selector.datetimepicker({
            format: format,
        });
    });

</script>
