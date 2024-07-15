@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!} >
            @endif
            @endif

            {{-- label rendering section --}}
            @if ($showLabel && $options['label'] !== false && $options['label_show'])
                @if(array_key_exists('label_template', $options) && $options['label_template'])
                    {!! view($options['label_template'], get_defined_vars())->render() !!}
                @else
                    @php include(labelBlockPath()) @endphp
                @endif
            @endif

            @if ($showField)
                {!! Form::input($type, $name, $options['value'], $options['attr']) !!}
                @php include(helpBlockPath()) @endphp
            @endif

            @php include(errorBlockPath()) @endphp

            @if ($showLabel && $showField)
                @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif
