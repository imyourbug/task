$(document).ready(function () {
    var tableElec = $('#table-elec').DataTable({
        responsive: true
    });
    var tableWater = $('#table-water').DataTable({
        responsive: true
    });
    var tableAir = $('#table-air').DataTable({
        responsive: true
    });
});

$('.btn-elec').on('click', function () {
    $('#amount').val($(this).data('amount'));
    $('#id_electask').val($(this).data('id'));
})

$('.btn-save-elec').on('click', function () {
    let amount = $('#amount').val();
    let id = $('#id_electask').val();
    $.ajax({
        type: "POST",
        url: $('.url_update_elec').val(),
        data: {
            id: id,
            amount: amount,
        },
        success: function (response) {
            if (response.status == 0) {
                toastr.success(response.message);
                $('.amount-' + id).text(amount);
                closeModal('elec');
            } else {
                toastr.error(response.message);
            }
        },
    });
})

$('.btn-water').on('click', function () {
    $('#asen').val($(this).data('asen'));
    $('#stiffness').val($(this).data('stiffness'));
    $('#ph').val($(this).data('ph'));
    $('#id_watertask').val($(this).data('id'));
})

$('.btn-save-water').on('click', function () {
    let asen = $('#asen').val();
    let stiffness = $('#stiffness').val();
    let ph = $('#ph').val();
    let id = $('#id_watertask').val();
    $.ajax({
        type: "POST",
        url: $('.url_update_water').val(),
        data: {
            id: id,
            asen: asen,
            stiffness: stiffness,
            ph: ph,
        },
        success: function (response) {
            if (response.status == 0) {
                toastr.success(response.message);
                $('.asen-' + id).text(asen);
                $('.stiffness-' + id).text(stiffness);
                $('.ph-' + id).text(ph);
                closeModal('water');
            } else {
                toastr.error(response.message);
            }
        },
    });
})


$('.btn-air').on('click', function () {
    $('#fine_dust').val($(this).data('fine_dust'));
    $('#dissolve').val($(this).data('dissolve'));
    $('#id_airtask').val($(this).data('id'));
})

$('.btn-save-air').on('click', function () {
    let fine_dust = $('#fine_dust').val();
    let dissolve = $('#dissolve').val();
    let id = $('#id_airtask').val();
    $.ajax({
        type: "POST",
        url: $('.url_update_air').val(),
        data: {
            id: id,
            fine_dust: fine_dust,
            dissolve: dissolve,
        },
        success: function (response) {
            if (response.status == 0) {
                toastr.success(response.message);
                $('.fine_dust-' + id).text(fine_dust);
                $('.dissolve-' + id).text(dissolve);
                closeModal('air');
            } else {
                toastr.error(response.message);
            }
        },
    });
})


function closeModal(type) {
    $('#modal-' + type).css('display', 'none');
    console.log('#modal-' + type);
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
}

function openModal(type) {
    // console.log($('#modal-' + type).data('id'));
    switch (type) {
        case 'elec':
            $('#' + type).val();
            break;
    }
}
