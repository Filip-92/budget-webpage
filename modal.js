$("#płatność").on("change", function () {        
    $modal = $('#myModal');
    if($(this).val() === 'custom_date'){
        $modal.modal('show');
    }
});