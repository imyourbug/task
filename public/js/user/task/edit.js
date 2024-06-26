var dataTable = null;

function closeModal() {
    $("#modal").css("display", "none");
    $("body").removeClass("modal-open");
    $(".modal-backdrop").remove();
}

$(document).ready(function () {
    // solution
    dataTable = $("#table").DataTable({
        ajax: {
            url: "/api/taskdetails?user_id=" + $("#user_id").val() +"&id=" + $("#task_id").val(),
            dataSrc: "taskDetails",
        },
        columns: [
            // { data: "id" },
            { data: "task.type.name" },
            { data: "plan_date" },
            { data: "actual_date" },
            { data: "time_in" },
            { data: "time_out" },
            { data: "created_at" },
            {
                data: function (d) {
                    return `<button class="btn btn-primary btn-sm btn-edit" data-id="${d.id}" data-target="#modal" data-toggle="modal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <a class="btn btn-success btn-sm" style="padding: 4px 15px" href="/user/taskdetails/update/${d.id}">
                                                    <i class="fa-solid fa-info"></i>
                                                </a>`;
                    // return `<a class="btn btn-primary btn-sm btn-edit" data-id="${d.id}" data-target="#modal" data-toggle="modal">
                    //                                 <i class="fas fa-edit"></i>
                    //                             </a>
                    //                             <a class="btn btn-success btn-sm" style="padding: 4px 15px" href="/admin/taskdetails/update/${d.id}">
                    //                                 <i class="fa-solid fa-info"></i>
                    //                             </a>
                    //                             <button data-id="${d.id}"
                    //                                 class="btn btn-danger btn-sm btn-delete">
                    //                                 <i class="fas fa-trash"></i>
                    //                             </button>`;
                },
            },
        ],
    });
});

$(document).on("click", ".btn-edit", function () {
    $.ajax({
        type: "GET",
        url: "/api/taskdetails/" + $(this).data("id") + "/getById",
        success: function (response) {
            if (response.status == 0) {
                let taskDetail = response.taskDetail;
                $("#plan_date").val(taskDetail.plan_date);
                $("#actual_date").val(taskDetail.actual_date);
                // $("#plan_date").val(formatDate(taskDetail.plan_date));
                // $("#actual_date").val(formatDate(taskDetail.actual_date));
                $("#time_in").val(taskDetail.time_in);
                $("#time_out").val(taskDetail.time_out);
                $("#taskdetail_id").val(taskDetail.id);
                //
                $(".btn-add").css("display", "none");
                $(".btn-update").css("display", "block");
            } else {
                toastr.error(response.message);
            }
        },
    });
});

function formatDate(date) {
    const dateObj = new Date(date);
    const formattedDate = dateObj.toLocaleDateString();

    console.log(formattedDate);

    return formattedDate;
}

$(document).on("click", ".btn-update", function () {
    if (confirm("Bạn có muốn sửa")) {
        let data = {
            id: $("#taskdetail_id").val(),
            time_in: $("#time_in").val(),
            plan_date: $("#plan_date").val(),
            actual_date: $("#actual_date").val(),
            time_out: $("#time_out").val(),
        };
        console.log(data);
        $.ajax({
            type: "POST",
            url: $(this).data("url"),
            data: data,
            success: function (response) {
                if (response.status == 0) {
                    closeModal();
                    toastr.success("Cập nhật thành công");
                    dataTable.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});

$(document).on("click", ".btn-delete", function () {
    if (confirm("Bạn có muốn xóa")) {
        let id = $(this).data("id");
        $.ajax({
            type: "DELETE",
            url: `/api/taskdetails/${id}/destroy`,

            success: function (response) {
                if (response.status == 0) {
                    toastr.success("Xóa thành công");
                    dataTable.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});
