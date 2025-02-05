<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/css/nouislider.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
@php
    if(request()->is(get_current_user_role().'/client_report') || request()->is(get_current_user_role().'/projects_report') || request()->is(get_current_user_role().'/payment_history')) {
        $max_value = App\Models\Payment_history::sum('amount');
    } elseif(request()->is(get_current_user_role().'/offline-payments')){
        $max_value = App\Models\OfflinePayment::max('total_amount');
    } else {
        $max_value = App\Models\Project::select(DB::raw('CAST(budget AS UNSIGNED) as numeric_budget'))->orderBy('numeric_budget', 'desc')->value('numeric_budget');
    }
    // $max_value = 100;
@endphp


<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/nouislider.min.js') }}"></script>
<script>
    var max = {{ isset($max_value) ? $max_value : 0 }};
    const dropdownItems = document.querySelectorAll('.dropdown-menu');
    dropdownItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent the dropdown from closing
        });
    });

    var slider = document.getElementById('budget-slider');
    var min = 0;
   
    noUiSlider.create(slider, {
        start: [min, max], // Initial range values
        connect: true,
        range: {
            'min': min,
            'max': max
        },
        tooltips: [true, true], // Show tooltips for both handles
        format: {
            to: function(value) {
                return '{{ currency() }}' + value.toFixed(0);
            },
            from: function(value) {
                return Number(value.replace('{{ currency() }}', ''));
            }
        }
    });

    slider.noUiSlider.on('update', function(values, handle) {
        document.getElementById('min-price').value = values[0];
        document.getElementById('max-price').value = values[1];
        document.getElementById('max-price').innerHTML = values[1];
        document.getElementById('min-price').innerHTML = values[0];

    });
</script>

{{-- <script>
    var max = {{ isset($max_value) ? $max_value : 100 }}; // Set your max dynamically or use a default
    var min = 0;

    var progressInput = document.getElementById('progress-input');
    var slider = document.getElementById('progress-slider');

    noUiSlider.create(slider, {
        start: [min], // Initial value
        connect: [true, false],
        range: {
            'min': min,
            'max': max
        },
        tooltips: [true], // Show tooltip for the handle
        format: {
            to: function(value) {
                return value.toFixed(0);
            },
            from: function(value) {
                return Number(value);
            }
        }
    });

    slider.noUiSlider.on('update', function(values) {
        progressInput.value = values[0];
    });

    progressInput.addEventListener('input', function() {
        var value = parseInt(this.value, 10);

        if (value >= min && value <= max) {
            slider.noUiSlider.set(value);
        }
    });
</script> --}}
