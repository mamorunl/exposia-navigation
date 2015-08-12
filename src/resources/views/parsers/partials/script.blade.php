<script>
    $('#{{ $modal_type }}_modal_{{ $key }}').on('hide.bs.modal', function (e) {
        $('div[data-target=#{{ $modal_type }}_modal_{{ $key }}]').html(
                $('#{{ $modal_type }}_input_{{ $key }}').val()
        );
    });
</script>