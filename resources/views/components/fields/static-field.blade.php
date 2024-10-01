<div class="form-group {{ $options['wrapper_class'] ?? '' }}">

    @if(!empty($options['label_show']))
        {!! Form::label($name, $options['label'], $options['label_attr']) !!}
    @endif

    <div class="{{ $options['value_class']}}">
        {{ $options['value'] }}
    </div>

</div>
