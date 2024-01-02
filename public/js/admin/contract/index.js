//list
$(".btn-delete").on("click", function () {
    if (confirm("Bạn có muốn xóa")) {
        let id = $(this).data("id");
        $.ajax({
            type: "DELETE",
            url: `/api/contracts/${id}/destroy`,
            data: {
                _token: 1,
            },
            success: function (response) {
                if (response.status == 0) {
                    toastr.success("Xóa thành công");
                    $(".row" + id).remove();
                } else {
                    toastr.error(response.message);
                }
            },
        });
    }
});

function renderDate() {
    let html = '<option value="0">Cuối tháng</option>';
    for (let index = 1; index <= 31; index++) {
        html += `<option value="${index}">${index}</option> `;
    }

    return html;
}

function renderDay() {
    return `<option value="Monday">Thứ hai</option>
            <option value="Tuesday">Thứ ba</option>
            <option value="Wednesday">Thứ tư</option>
            <option value="Thursday">Thứ năm</option>
            <option value="Friday">Thứ sáu</option>
            <option value="Saturday">Thứ bảy</option>
            <option value="Sunday">Chủ nhật</option>`;
}

function renderOption(type, className) {
    let html = `<div class="option-select-${className}">
        ${type == "day" ? "Chọn thứ (hàng tuần)" : "Chọn ngày (hàng tháng)"}
        <select class="custom-select form-control-border select-${className}">
            ${type == "day" ? renderDay() : renderDate()}
            </select>
            </div>`;
    $(".option-type-" + className).append(html);
}

function changeType(className) {
    $(".option-select-" + className).remove();
    renderOption(
        $(".select-type-" + className)
            .find(":selected")
            .val(),
        className
    );
}

//add
var type_air = $("#type_air");
var type_elec = $("#type_elec");
var type_water = $("#type_water");
//
type_elec.on("click", function () {
    if (this.checked) {
        if (!$("div.option-elec").length) {
            $(".card-body").append(`<div class="row option-elec">
                                        <div class="col-lg-12">
                                            <div class="form-group option-type-elec" style="align-items: center">
                                                <label for="menu">Đo điện theo</label>
                                                <select class="custom-select form-control-borders select-type-elec" onchange="changeType('elec')">
                                                    <option value="day">Thứ</option>
                                                    <option value="date" selected>Ngày</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>`);
            renderOption(
                $(".select-type-elec").find(":selected").val(),
                "elec"
            );
        }
    } else {
        $(".option-elec").remove();
    }
});
//
type_air.on("click", function () {
    if (this.checked) {
        if (!$("div.option-air").length) {
            $(".card-body").append(`
                <div class="row option-air">
                    <div class="col-lg-12">
                        <div class="form-group option-type-air" style="align-items: center">
                            <label for="menu">Đo không khí theo</label>
                            <select class="custom-select form-control-borders select-type-air" onchange="changeType('air')">
                                <option value="day" selected>Thứ</option>
                                <option value="date">Ngày</option>
                            </select>
                        </div>
                    </div>
                </div>`);
            renderOption($(".select-type-air").find(":selected").val(), "air");
        }
    } else {
        $(".option-air").remove();
    }
});
//
type_water.on("click", function () {
    if (this.checked) {
        if (!$("div.option-water").length) {
            $(".card-body").append(`
                <div class="row option-water">
                    <div class="col-lg-12">
                        <div class="form-group option-type-water" style="align-items: center">
                            <label for="menu">Đo nước theo</label>
                            <select class="custom-select form-control-borders select-type-water" onchange="changeType('water')">
                                <option value="day" selected>Thứ</option>
                                <option value="date">Ngày</option>
                            </select>
                        </div>
                    </div>
                </div>`);
            renderOption(
                $(".select-type-water").find(":selected").val(),
                "water"
            );
        }
    } else {
        $(".option-water").remove();
    }
});
//add
$(".btn-create").on("click", function () {
    if (confirm("Xác nhận tạo hợp đồng mới?")) {
        let params = {
            customer_id: $("#customer_id").val(),
            name: $("#name").val(),
            start: $("#start").val(),
            finish: $("#finish").val(),
            content: $("#content").val(),
            task_type: [
                ...($(".type_elec").is(":checked")
                    ? [$(".type_elec").val()]
                    : []),
                ...($(".type_water").is(":checked")
                    ? [$(".type_water").val()]
                    : []),
                ...($(".type_air").is(":checked")
                    ? [$(".type_air").val()]
                    : []),
            ],
            type_elec: $(".select-type-elec").val(),
            value_elec: $(".select-elec").val(),
            type_water: $(".select-type-water").val(),
            value_water: $(".select-water").val(),
            type_air: $(".select-type-air").val(),
            value_air: $(".select-air").val(),
        };
        $.ajax({
            type: "POST",
            url: $(this).data("url"),
            data: params,
            success: function (response) {
                response.status == 0
                    ? toastr.success(response.message)
                    : toastr.error(response.message);
            },
        });
    }
});
