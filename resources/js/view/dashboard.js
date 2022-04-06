var ctxOrder = document.getElementById("chartOrder").getContext("2d");

var chart1 = new Chart(ctxOrder, {
    type: "line",

    data: {
        datasets: [{
            label: "Đơn hàng",
            borderColor: "rgba(255, 205, 86, 0.8)",
            backgroundColor: "rgba(255, 205, 86, 0.2)",
        }],
    },
    options: {},
});

var ctxRevenue = document.getElementById("chartRevenue").getContext("2d");
var chart2 = new Chart(ctxRevenue, {
    type: "line",

    data: {
        datasets: [{
            label: "Doanh thu",
            backgroundColor: "rgba(75, 192, 192, 0.2)",
            borderColor: "rgba(75, 192, 192, 0.8)",
            data: [],
        }],
    },
    options: {},
});

$('#datepicker1').datepicker({
    format: 'yyyy/mm/dd',
}).on('change', function () {
    $('#datepicker3').val("0");
});

$('#datepicker2').datepicker({
    format: 'yyyy/mm/dd',
}).on('change', function () {
    console.log("run");
    $('#datepicker3').val("0");
});

$('#datepicker3').on('change', function () {
    $('#datepicker1').val("");
    $('#datepicker2').val("");
});

$('#filterBtn').on('click', function () {
    const from = $('#datepicker1').val();
    const to = $('#datepicker2').val();
    const option = $('#datepicker3').val();

    console.log({
        from,
        to,
        option: option || 'range'
    });
    if (!(from.length && to.length) && !option) {
        alert('Bạn chưa chọn ngày');
        return;
    }
    // console.log(from, to, option);
    // console.log({from, to});
    $.ajax({
        method: "post",
        url: "/report",
        data: {
            from,
            to,
            option: option || 'range'
        },
        success: (result) => {
            const data = result.data;
            const error = result.error;
            if (data) {
                console.log(JSON.stringify(data));
                chart1.data.labels = data.map(o => o.created_at);
                chart1.data.datasets[0].data = data.map(o => o.order_total);
                chart1.update();
                chart2.data.labels = data.map(o => o.created_at);
                chart2.data.datasets[0].data = data.map(o => o.proceeds);
                chart2.update();
            } else if (error) {
                console.log(error.code, error.message);
            }
        },
    });
}).trigger('click');

$('#downloadReport').on('click', function () {
    const from = $('#datepicker1').val();
    const to = $('#datepicker2').val();
    const option = $('#datepicker3').val();
    const data = {
        from,
        to,
        option: option || 'range'
    }

    if (!(from.length && to.length) && !option) {
        alert('Bạn chưa chọn ngày');
        return;
    }
    const url = new URLSearchParams(data);
    window.location.href = '/report/download?' + url.toString();
})
