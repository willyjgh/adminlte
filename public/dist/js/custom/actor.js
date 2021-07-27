
// clear modal form
function resetFormModal(str) {

    var _modal = "#" + str + "-modal";
    var _form = "#" + str + "-form";

    var html = $(_modal).on('hidden.bs.modal', function () {
        $(this).find(_form)[0].reset();
        $(this).find('span.error-text').text('');
    });

    return html;
}

// ADD NEW {{ store }}
function addActor() {
    resetFormModal("add");

    $('#add-form').on('submit', function (e) {
        e.preventDefault();

        var form = this;
        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: new FormData(form),
            processData: false,
            dataType: 'json',
            contentType: false,
            success: function (data) {
                // console.log(data)
                if (data.code == 0) {
                    $.each(data.error, function (prefix, val) {
                        $(form).find('span.' + prefix + '_error').text(val[0]);
                    });
                } else {
                    $('#add-modal').modal('hide');
                    $('#tbl-actor').DataTable().ajax.reload(null, false);

                    setTimeout(function () {
                        // toastr.success('The process has been saved.', 'Success');
                        // {"code":1,"msg":"Success update data."}
                        toastr.success(data.msg, data.title);

                    }, 1000);
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
}

// SHOW EDIT {{ show id }}
$(document).on('click', '#edit-btn', function () {
    var actor_id = $(this).data('id');
    $.get('/actor/get-actor-details', { actor_id: actor_id }, function (data) {
        // console.log(data.details.actor_id);
        $('#edit-form').find('input[name="actor_id"]').val(data.details.actor_id);
        $('#edit-form').find('input[name="first_name"]').val(data.details.first_name);
        $('#edit-form').find('input[name="last_name"]').val(data.details.last_name);
        $('#edit-modal').modal('show');
    }, 'json');
});

// UPDATE {{ update }}
function updateActor() {
    resetFormModal("edit");

    $('#edit-form').on('submit', function (e) {
        e.preventDefault();
        var form = this;
        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: new FormData(form),
            processData: false,
            dataType: 'json',
            contentType: false,
            success: function (data) {
                // console.log(data)
                if (data.code == 0) {
                    $.each(data.error, function (prefix, val) {
                        $(form).find('span.' + prefix + '_error').text(val[0]);
                    });
                } else {
                    $('#edit-modal').modal('hide');
                    $('#tbl-actor').DataTable().ajax.reload(null, false);

                    setTimeout(function () {
                        toastr.info(data.msg, data.title);
                    }, 1000);
                }
            },
            error: function (error) {
                console.log(error);
            }
        })
    });
}

// DELETE {{ destroy }}
$(document).on('click', '#delete-btn', function () {
    var actor_id = $(this).data('id');
    // console.log(actor_id);
    var url = "/actor/delete-actor";

    swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        allowOutsideClick: false
    }).then(function (result) {
        if (result.value) {
            $.post(url, { actor_id: actor_id }, function (data) {
                if (data.code == 1) {
                    $('#tbl-actor').DataTable().ajax.reload(null, false);
                    toastr.info(data.msg, data.title)
                } else {
                    toastr.error(data.error, data.title);
                }
            }, 'json');
        }
    })
})


$(function () {

    // GET ALL {{ index }}
    $('#tbl-actor').DataTable({
        processing: true,
        info: true,
        pageLength: 5,
        aLengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, "All"]],
        ajax: '/actor/get-actor-list',
        columnDefs: [{ targets: [0, 4], orderable: false }],
        columns: [
            // {data: 'country_id', name: 'country_id'},
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'first_name', name: 'FIRSTNAME' },
            { data: 'last_name', name: 'LASTNAME' },
            { data: 'last_update', name: 'UPDATED AT' },
            { data: 'actions', name: 'actions' }
        ],
    });

    // ADD NEW
    addActor();

    // UPDATE
    updateActor();

});
