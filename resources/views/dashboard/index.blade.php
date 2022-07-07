@extends('layout.app')
@section('content')
    <div class="containter mt-5 rounded bg-white p-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Tasks</h3>
        </div>
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card" style="background-color: #38c172;">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <div class="me-3 align-self-center mr-3">
                                <i class="fas fa-check-circle fa-2x text-light" aria-hidden="true"></i>
                            </div>
                            <div class="align-self-center">
                                <h6 class="text-light mt-2 mb-0">Completed</h6>
                                <h2 class="mt-1 text-white">{{ $completed_tasks }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card" style="background-color: rgba(54, 162, 235, 0.9)">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <div class="me-3 align-self-center mr-3">
                                <i class="fa-solid fa-spinner fa-2x text-light"></i>
                            </div>
                            <div class="align-self-center">
                                <h6 class="text-light mt-2 mb-0">In Progress</h6>
                                <h2 class="mt-1 text-white">{{ $InProgress_tasks }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card" style="background-color: rgba(255, 206, 86, 0.9)">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <div class="me-3 align-self-center mr-3">
                                <i class="fas fa-bed fa-2x text-light" aria-hidden="true"></i>
                            </div>
                            <div class="align-self-center">
                                <h6 class="text-light mt-2 mb-0">Pended</h6>
                                <h2 class="mt-1 text-white">{{ $pended_tasks }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card" style="background-color: rgba(255, 99, 132, 0.9)">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <div class="me-3 align-self-center mr-3">
                                <i class="fas fa-calendar-times fa-2x text-light" aria-hidden="true"></i>
                            </div>
                            <div class="align-self-center">
                                <h6 class="text-light mt-2 mb-0">Canceled</h6>
                                <h2 class="mt-1 text-white">{{ $canceled_tasks }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-5">
            <div class="col-md-10 mx-auto">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
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
                                size: 28,
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
