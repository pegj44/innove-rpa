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

            const pairItemAccordion = document.querySelectorAll('.pair-item-accordion');

            pairItemAccordion.forEach(function(item) {

                const pair1PurchaseType = item.querySelector('#pair1_purchase_type');
                const pair2PurchaseType = item.querySelector('#pair2_purchase_type');

                const pair1PurchaseTypeOverride = item.querySelector('input#pair1_purchase_type');
                const pair2PurchaseTypeOverride = item.querySelector('input#pair2_purchase_type');

                pair1PurchaseType.addEventListener('change', function(e) {
                    if (pair1PurchaseType.value === 'buy') {
                        pair2PurchaseType.value = 'sell';
                    } else {
                        pair2PurchaseType.value = 'buy';
                    }

                    pair1PurchaseTypeOverride.value = pair1PurchaseType.value;
                    pair2PurchaseTypeOverride.value = pair2PurchaseType.value;
                });

                pair2PurchaseType.addEventListener('change', function(e) {
                    if (pair2PurchaseType.value === 'buy') {
                        pair1PurchaseType.value = 'sell';
                    } else {
                        pair1PurchaseType.value = 'buy';
                    }
                    pair1PurchaseTypeOverride.value = pair1PurchaseType.value;
                    pair2PurchaseTypeOverride.value = pair2PurchaseType.value;
                });
            });
        });

    </script>
@else
<p id="no-paired-items">No paired items.</p>
@endif
