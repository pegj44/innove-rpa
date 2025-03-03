@if(!empty($pairedItems))

    <div id="accordion-pairing-items" data-accordion="collapse">
        @foreach($pairedItems as $index => $pairedItemData)
            @include('dashboard.trade.play.paired-item')
        @endforeach
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const tradeBtn = document.querySelectorAll('.initiate-trade-btn');

            tradeBtn.forEach(function(btn) {
                btn.classList.remove('hidden');
            });

            const tradeForms = document.querySelectorAll('.form-trade');

            tradeForms.forEach(function(form) {
               form.addEventListener('submit', function(e) {
                   e.preventDefault();

                   form.querySelectorAll('.adaptval').forEach(function(field) {
                       const key = field.getAttribute('data-key');
                       const handler = document.getElementById(key);

                       field.value = handler.value;
                   });

                   form.submit();
               });
            });

        });

    </script>
@endif

<p id="no-paired-items" {{ (!empty($pairedItems)? 'hidden' : '') }}>No paired items.</p>
