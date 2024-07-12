@if(session('success'))
    @if(is_array(session('success')))
        @foreach(session('success') as $index => $message)
            @include('components.notification-success', ['message' => $message, 'index' => $index])
        @endforeach
    @else
        @include('components.notification-success', ['message' => session('success'), 'index' => 1])
    @endif
@endif

@if(session('error'))
    @if(is_array(session('error')))
        @foreach(session('error') as $index => $message)
            @include('components.notification-error', ['message' => $message, 'index' => $index])
        @endforeach
    @else
        @include('components.notification-error', ['message' => session('error'), 'index' => 1])
    @endif
@endif

@if(session('warning'))
    @if(is_array(session('warning')))
        @foreach(session('warning') as $index => $message)
            @include('components.notification-warning', ['message' => $message, 'index' => $index])
        @endforeach
    @else
        @include('components.notification-warning', ['message' => session('warning'), 'index' => 1])
    @endif
@endif
