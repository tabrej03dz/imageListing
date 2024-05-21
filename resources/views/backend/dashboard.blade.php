@extends('backend.layout.root', ['title' => 'Dashboard'])
@section('content')

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
{{--                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i--}}
{{--                            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>--}}
                </div>

                <!-- Content Row -->
                <div class="row">

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-2 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Users (All)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$customers->count()}}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users-cog fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-2 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Images</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$images->count()}}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-images fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-2 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Visits
                                        </div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$visitCounts}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-code fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    @php
                        $count = $images->filter(function ($image) {
                            return Carbon\Carbon::parse($image->date)->lt(Carbon\Carbon::now()->subDays(3));
                        })->count();

                    @endphp

                        <!-- Pending Requests Card Example -->
                    <div class="col-xl-2 col-md-6 mb-4 position-relative">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Old Images
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-bolt fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($count > 0)
                            <a href="{{ route('clearOldImage') }}" class="btn btn-danger p-1" style="position: absolute; top: 0; right: 0; ">
                                Clear
                            </a>
                        @endif
                    </div>

                    <!-- Downloads Count -->
                    <div class="col-xl-2 col-md-6 mb-4 position-relative">
                        @php
                            $count = \App\Models\DownloadTrack::whereDate('updated_at', \Carbon\Carbon::today())->count();
                        @endphp
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Downloads
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-download fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('downloads.view')}}" class="btn btn-success p-1" style="position: absolute; top: 0; right: 0; ">
                            view
                        </a>
                    </div>

                </div>

                <!-- Content Row -->

                    <div class="row justify-content-between">
                        <div class="col-md-12">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <form action="{{route('setKeys')}}" method="post">
                                        @csrf
                                        <div class="form-row align-items-center">
                                            <div class="col-sm-5 my-1 d-flex">
                                                <label  for="instance_id">Instance Id</label>
                                                <input type="text" class="form-control" id="instance_id" name="instance_id" value="{{session('instance_id') ?? ''}}" placeholder="Instance Id">
                                            </div>
                                            <div class="col-sm-5 my-1 d-flex">
                                                <label  for="access_token">Access Token</label>
                                                <input type="text" class="form-control" id="access_token" name="access_token" value="{{session('access_token') ?? ''}}" placeholder="Access Token">
                                            </div>
                                            <div class="col-auto my-1">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                <div class="row">

                    <!-- Area Chart -->
                    <div class="col-xl-8 col-lg-7">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div
                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Customer Stats</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="myAreaChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pie Chart -->
                    <div class="col-xl-4 col-lg-5">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div
                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Users</h6>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                         aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-header">Dropdown Header:</div>
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2">
                                    <canvas id="myPieChart"></canvas>
                                </div>
                                <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> All
                                        </span>
                                    <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Active
                                        </span>
                                    <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Inactive
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Row -->
                <div class="row">

                    <!-- Content Column -->
                    <div class="col-12 mb-4">

                        <!-- Project Card Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Categories</h6>
                            </div>
                            <div class="card-body">
                                @foreach($categories as $category)

                                    @php
                                        $categoryCount = \App\Models\UserCategory::where('category_id', $category->id)->count();
                                    $percentage = ($categoryCount * 100)/ $customers->count();
                                    @endphp
                                    <h4 class="small font-weight-bold">{{$category->name}} <span
                                            class="float-right">{{round($percentage)}} %</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar " role="progressbar" style="width: {{$percentage}}%; background-color: {{ '#'.\App\Http\Controllers\DashboardController::generateRandomHex()}};"
                                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>

                                @endforeach

                            </div>
                        </div>

                    </div>

                </div>

                @php
                    $months = [];
                    $counts = [];
                    foreach ($customerData as $data){
                        array_push($months, $data->month_name);
                        array_push($counts, $data->count);
                    }

                    $monthJSON = json_encode($months);
                    $countJSON = json_encode($counts);

                @endphp

                <!-- Page level plugins -->
                <script src="{{asset('assets/vendor/chart.js/Chart.min.js')}}"></script>

                <!-- Page level custom scripts -->
                <script src="{{asset('assets/js/demo/chart-area-demo.js')}}"></script>
                <script src="{{asset('assets/js/demo/chart-pie-demo.js')}}"></script>


                <!-- Area Chart -->
                <script>

                    var months = {!! $monthJSON !!};

                    var counts = {!! $countJSON !!};

                    // Area Chart Example
                    var ctx = document.getElementById("myAreaChart");
                    var myLineChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: months,
                            datasets: [{
                                label: "Customer",
                                lineTension: 0.3,
                                backgroundColor: "rgba(78, 115, 223, 0.05)",
                                borderColor: "rgba(78, 115, 223, 1)",
                                pointRadius: 3,
                                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                                pointBorderColor: "rgba(78, 115, 223, 1)",
                                pointHoverRadius: 3,
                                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                                pointHitRadius: 10,
                                pointBorderWidth: 2,
                                data: counts,
                            }],
                        },
                        options: {
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 25,
                                    top: 25,
                                    bottom: 0
                                }
                            },
                            scales: {
                                xAxes: [{
                                    time: {
                                        unit: 'date'
                                    },
                                    gridLines: {
                                        display: false,
                                        drawBorder: false
                                    },
                                    ticks: {
                                        maxTicksLimit: 7
                                    }
                                }],
                                yAxes: [{
                                    ticks: {
                                        maxTicksLimit: 5,
                                        padding: 10,
                                        // Include a dollar sign in the ticks
                                        callback: function(value, index, values) {
                                            return 'customers :' + number_format(value);
                                        }
                                    },
                                    gridLines: {
                                        color: "rgb(234, 236, 244)",
                                        zeroLineColor: "rgb(234, 236, 244)",
                                        drawBorder: false,
                                        borderDash: [2],
                                        zeroLineBorderDash: [2]
                                    }
                                }],
                            },
                            legend: {
                                display: false
                            },
                            tooltips: {
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                titleMarginBottom: 10,
                                titleFontColor: '#6e707e',
                                titleFontSize: 14,
                                borderColor: '#dddfeb',
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: false,
                                intersect: false,
                                mode: 'index',
                                caretPadding: 10,
                                callbacks: {
                                    label: function(tooltipItem, chart) {
                                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                        return datasetLabel + ':' + number_format(tooltipItem.yLabel);
                                    }
                                }
                            }
                        }
                    });
                </script>


                <script>
                    // Pie Chart Example
                    var ctx = document.getElementById("myPieChart");
                    var myPieChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ["All", "Active", "Inactive",],
                            datasets: [{
                                data: [{{$customers->count()}}, {{$customers->where('status', '1')->count()}}, {{$customers->where('status', '0')->count()}}],
                                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                                hoverBorderColor: "rgba(234, 236, 244, 1)",
                            }],
                        },
                        options: {
                            maintainAspectRatio: false,
                            tooltips: {
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                borderColor: '#dddfeb',
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: false,
                                caretPadding: 10,
                            },
                            legend: {
                                display: false
                            },
                            cutoutPercentage: 80,
                        },
                    });

                </script>

@endsection
