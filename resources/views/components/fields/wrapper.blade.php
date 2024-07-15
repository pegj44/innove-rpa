
<div class="form-group {{ $options['wrapper_class'] ?? '' }}">

    @if(!empty($options['label_show']))
        {!! Form::label($name, $options['label'], $options['label_attr']) !!}
    @endif

    <div class="{{ $options['field_col_class']}}">
        @foreach($options['fields'] as $field)
            {!! form_row($field) !!}
        @endforeach
    </div>

</div>
