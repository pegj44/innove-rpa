@php
    $userData = session('api_user_data');
@endphp

@if($userData['isOwner'] || in_array('manage all', $userData['permissions']))
    @include('layouts.admin.sidebar')
@endif

@if(in_array('investor', $userData['permissions']))
    @include('layouts.investor.sidebar')
@endif

@php
    $currentRouteName = \Illuminate\Support\Facades\Route::currentRouteName();
    $urlSegments = request()->segments();
    $firstSegment = \Illuminate\Support\Arr::first($urlSegments);
@endphp

<script>

    const menuEls = document.querySelectorAll('#main-sidebar-ul > li[data-route]');

    menuEls.forEach(function(el) {
       let routes = el.getAttribute('data-route');
       routes = routes.split('|');

       if(routes.indexOf('{{ $firstSegment }}') !== -1) {
           const childUl = el.querySelector('ul');

           if(childUl) {
               childUl.classList.remove('hidden');
               const childLi = childUl.querySelectorAll('li');

               childLi.forEach(function(childEl) {
                   let childElRoutes = childEl.getAttribute('data-route');
                   childElRoutes = childElRoutes.split('|');

                   if(childElRoutes.indexOf('{{ $currentRouteName }}') !== -1) {
                       childEl.querySelector('a').classList.add('dark:bg-gray-900');
                   }
               });
           } else {
               el.querySelector('a').classList.add('dark:bg-gray-900');
           }
       }

    });

</script>
