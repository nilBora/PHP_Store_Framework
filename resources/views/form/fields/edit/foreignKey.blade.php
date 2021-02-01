<div class="form-group">
    <label>{{$options['caption']}}:</label>
    <select name="{{$options['name']}}" id="{{$options['name']}}_" class="form-control select2" style="width: 100%;">
        @foreach($selectRows as $row)
            <option value="{{ $row->{$options['foreignKeyField']} }}"
            @if($row->{$options['foreignKeyField']} == $options['value']) selected="selected" @endif>{{  $row->{$options['foreignValueField']} }}</option>
        @endforeach
    </select>
    <span class="error invalid-feedback"></span>
</div>
<script>
    jQuery(function() {
        jQuery('.select2').select2();
    });
</script>
