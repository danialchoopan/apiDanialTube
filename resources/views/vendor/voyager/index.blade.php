@extends('voyager::master')

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="bg-primary p-4 rounded-lg shadow-md mb-4" style="background-color: #3b82f6; color: white; padding: 20px; border-radius: 15px;">
                                    <h4 class="m-0">مجموع بازدیدها</h4>
                                    <h2 class="mt-2">{{ number_format($totalViews) }}</h2>
                                    <p class="text-xs opacity-75">آمار زنده</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-success p-4 rounded-lg shadow-md mb-4" style="background-color: #10b981; color: white; padding: 20px; border-radius: 15px;">
                                    <h4 class="m-0">مجموع فروش</h4>
                                    <h2 class="mt-2">{{ number_format($totalSales) }} ت</h2>
                                    <p class="text-xs opacity-75">آمار زنده</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-warning p-4 rounded-lg shadow-md mb-4" style="background-color: #f59e0b; color: white; padding: 20px; border-radius: 15px;">
                                    <h4 class="m-0">دانشجویان جدید</h4>
                                    <h2 class="mt-2">{{ number_format($newStudents) }}</h2>
                                    <p class="text-xs opacity-75">۳۰ روز اخیر</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-info p-4 rounded-lg shadow-md mb-4" style="background-color: #06b6d4; color: white; padding: 20px; border-radius: 15px;">
                                    <h4 class="m-0">زمان تماشا (ساعت)</h4>
                                    <h2 class="mt-2">{{ number_format($totalWatchTime) }}</h2>
                                    <p class="text-xs opacity-75">تخمینی</p>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5" style="margin-top: 30px;">
                            <div class="col-md-8">
                                <div class="panel panel-bordered">
                                    <div class="panel-heading" style="border-bottom: 1px solid #eee;">
                                        <h3 class="panel-title">آمار فروش ماهیانه</h3>
                                    </div>
                                    <div class="panel-body">
                                        <canvas id="revenueChart" height="150"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-bordered">
                                    <div class="panel-heading" style="border-bottom: 1px solid #eee;">
                                        <h3 class="panel-title">آخرین دوره‌های بارگذاری شده</h3>
                                    </div>
                                    <div class="panel-body">
                                        <ul class="list-group list-group-flush">
                                            @foreach(\App\Models\Course::latest()->take(5)->get() as $course)
                                                <li class="list-group-item flex items-center justify-between" style="display: flex; justify-content: space-between; align-items: center; border: 0; border-bottom: 1px solid #f5f5f5;">
                                                    <span>{{ $course->name_title }}</span>
                                                    <span class="label label-info" style="background: #3b82f6;">{{ $course->created_at->format('Y/m/d') }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('revenueChart').getContext('2d');
        var monthlyData = @json($monthlySales);

        var labels = monthlyData.map(item => 'ماه ' + item.month);
        var data = monthlyData.map(item => item.total);

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels.length ? labels : ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور'],
                datasets: [{
                    label: 'فروش (تومان)',
                    data: data.length ? data : [0, 0, 0, 0, 0, 0],
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@stop
