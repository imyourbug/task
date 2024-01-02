$(document).ready(function () {
    var dataTable = $('#table').DataTable({
        responsive: true
    });
    $(".btn-delete").on("click", function () {
        if (confirm("Bạn có muốn xóa")) {
            let id = $(this).data("id");
            console.log(id);
            $.ajax({
                type: "DELETE",
                url: `/api/staffs/${id}/destroy`,
                success: function (response) {
                    if (response.status == 0) {
                        toastr.success("Xóa thành công");
                        $('.row' + id).remove();
                    } else {
                        toastr.error(response.message);
                    }
                },
            });
        }
    });
});
