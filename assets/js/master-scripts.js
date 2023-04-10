feather.replace({ width: 18, height: 18 });

// In your Javascript (external .js resource or <script> tag)
$(document).ready(function () {
    if ($('.select2').length) {
        $('.select2').select2({
            theme: 'bootstrap-5',
        });
    }
});
