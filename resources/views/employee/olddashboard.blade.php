@extends('layouts.employee.app')
@section('content-main')
<div class="content-header">
    <h2 class="content-title"> Hi, {{ Auth::user()->first_name }} </h2>
</div>
{{-- <div class="row">
    <div class="col-lg-4">
        <div class="card card-body mb-4">
            <article class="icontext">
                <span class="icon icon-sm rounded-circle bg-primary-light"><i class="text-primary material-icons md-monetization_on"></i></span>
                <div class="text">
                    <h6 class="mb-1">Tổng lợi nhuận</h6> <span>$0</span>
                </div>
            </article>
        </div> <!-- card  end// -->
    </div> <!-- col end// -->
    <div class="col-lg-4">
        <div class="card card-body mb-4">
            <article class="icontext">
                <span class="icon icon-sm rounded-circle bg-success-light"><i class="text-success material-icons md-local_shipping"></i></span>
                <div class="text">
                    <h6 class="mb-1">Tổng đơn hàng</h6> <span>0</span>
                </div>
            </article>
        </div> <!-- card end// -->
    </div> <!-- col end// -->
    <div class="col-lg-4">
        <div class="card card-body mb-4">
            <article class="icontext">
                <span class="icon icon-sm rounded-circle bg-warning-light"><i class="text-warning material-icons md-shopping_basket"></i></span>
                <div class="text">
                    <h6 class="mb-1">Tổng sản phẩm</h6> <span>0</span>
                </div>
            </article>
        </div> <!--  end// -->
    </div> <!-- col end// -->
</div> <!-- row end// -->


<div class="row">
    <div class="col-xl-8 col-lg-12">
        <div class="card mb-4">
            <article class="card-body">
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class=" chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                </div>
                <h5 class=" card-title">Biểu đồ thống kê</h5>
                <canvas height="357" id="myChart" style="display: block; height: 258px; width: 646px;" width="895" class="chartjs-render-monitor"></canvas>
            </article> <!-- card-body end// -->
        </div> <!-- card end// -->
    </div> <!-- col end// -->

</div> <!-- row end// -->


<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Đơn hàng gần đây</h5>
        <div class="table-responsive">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <td>2323</td>
                        <td><b>ABC</b></td>
                        <td>test@example.com</td>
                        <td>0đ</td>
                        <td><span class="badge rounded-pill alert-warning">Đang giao</span></td>
                        <td>07.010.2021</td>
                        <td class="text-end">
                            <a href="#" class="btn btn-light">Chi tiết</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2323</td>
                        <td><b>CDE</b></td>
                        <td>test@example.com</td>
                        <td>0đ</td>
                        <td><span class="badge rounded-pill alert-success">Đã giao</span></td>
                        <td>07.010.2021</td>
                        <td class="text-end">
                            <a href="#" class="btn btn-light">Chi tiết</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div> <!-- table-responsive end// -->
    </div> <!-- card-body end// -->
</div> <!-- card end// -->
<!-- ChartJS files-->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<script>
    var ctx = document.getElementById("myChart").getContext("2d");
    var chart = new Chart(ctx, {
        type: "line",

        data: {
            labels: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ],
            datasets: [{
                    label: "Sales",
                    backgroundColor: "rgb(44, 120, 220)",
                    borderColor: "rgb(44, 120, 220)",
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                },
                {
                    label: "Visitors",
                    backgroundColor: "rgb(180, 200, 230)",
                    borderColor: "rgb(180, 200, 230)",
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                },
            ],
        },
        options: {},
    });
</script> --}}

<div class="">Thống kê tiền lương, ngày nghỉ của nhân viên blabla</div>
@endsection()
