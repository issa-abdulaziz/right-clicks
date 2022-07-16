@extends('layout.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="m-0">Dashboard</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $completed_tasks }}</h3>

                            <p>Completed</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $InProgress_tasks }}</h3>

                            <p>In Progress</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-spinner"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $pended_tasks }}</h3>

                            <p>Pended</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-bed" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $canceled_tasks }}</h3>

                            <p>Canceled</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-times" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="myChart"></canvas>
                        </div><!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(function() {
            let monthsLabel = @json($monthsLabel);
            let task = @json($monthsData);

            const config = {
                type: 'line',
                data: {
                    labels: monthsLabel,
                    datasets: [{
                        label: 'Completed Task',
                        backgroundColor: '#38c172',
                        borderColor: '#38c172',
                        fill: false,
                        data: task,
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Completed Tasks For Over The Last 12 Month',
                            font: {
                                size: 24,
                            },
                        },
                        legend: {
                            position: 'top'
                        }
                    }
                }
            };

            const myChart = new Chart(
                $('#myChart'),
                config
            );

        });
    </script>
@endpush
