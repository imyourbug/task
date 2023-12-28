$(document).ready(function () {
    function convertStringToMin(str) {
        let time = str.split(":");
        let hour = time[0];
        let mins = time[1];
        return parseInt(hour) * 60 + parseInt(mins);
    }

    function getAMorPM(str) {
        let time = str.split(":");
        let hour = time[0];
        return str + " " + (parseInt(hour) >= 12 ? "PM" : "AM");
    }

    function convertMinToString(mins) {
        let min = mins % 60;
        let hour = Math.round(mins / 60);
        return `${hour > 0 ? hour + "h" : ""}${min > 0 ? min + "m" : ""}`;
    }

    function getDiffHour(start_time, end_time) {
        let mins =
            convertStringToMin(end_time) - convertStringToMin(start_time);
        return convertMinToString(mins);
    }
    //
    var urlData = $("#logData").val();
    var datatable = $("#logTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: urlData,
        dom: "Bfrtip",
        buttons: [
            {
                extend: "pdfHtml5",
                orientation: "landscape",
                pageSize: "LEGAL",
            },
        ],
        columns: [
            {
                data: "date",
                name: "date",
            },
            {
                data: null,
                render: function (data, type, row, meta) {
                    return data.organization + "<br/>" + data.name;
                },
            },
            {
                data: null,
                render: function (data, type, row, meta) {
                    return (
                        getAMorPM(data.start_time) +
                        " - " +
                        getAMorPM(data.end_time)
                    );
                },
            },
            {
                data: null,
                render: function (data, type, row, meta) {
                    return getDiffHour(data.start_time, data.end_time);
                },
            },
            {
                data: null,
                render: function (data, type, row, meta) {
                    return data.phone + "<br/>" + data.email;
                },
            },
            // {
            //     data: null,
            //     render: function (data, type, row, meta) {
            //         console.log(data);
            //         return `<i class="btn-edit fa-solid fa-pen-to-square"
            //                 data-id="${data.id}" style="color: blue;"
            //                 ></i>&emsp;
            //                     <i class="btn-delete fa-solid fa-trash"
            //                     data-id=${data.id}
            //                     style="color: red;"
            //                     ></i>`;
            //     },
            // },
        ],
    });

    $("#user_id").on("change", function () {
        let id = $("#user_id").val();
        if (id == 0) {
            datatable.ajax.url('/admin/volunteers/getData/').load();
        }
        else datatable.ajax.url('/admin/volunteers/getDataById/' + $("#user_id").val()).load();
    });
});
