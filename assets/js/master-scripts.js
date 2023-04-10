feather.replace({ width: 18, height: 18 });

// In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap-5',
    });
});