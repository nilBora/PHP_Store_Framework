<div class="form-group">
    <label>{{$options['caption']}}:</label>
    <select name="{{$options['name']}}" id="{{$options['name']}}_" class="select2" multiple="multiple" style="width: 100%;">
        @foreach($selectRows as $row)
            {{ print_r($options['value']) }}

            <option value="{{ $row->{$options['foreignKeyField']} }}"
                    @if (in_array($row->{$options['foreignKeyField']}, $values)) selected="selected" @endif>{{  $row->{$options['foreignValueField']} }}</option>
        @endforeach
    </select>
    <span class="error invalid-feedback"></span>
</div>

<script>
    jQuery(function() {
        jQuery('.select2').select2();
    });
</script>
