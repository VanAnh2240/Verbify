@extends('layout.admin_MainStructure')
@section('title', 'Dashboard')
@section('content')
        <div class="row align-items-start">
            <div class="col roboto-medium-italic fs-4 purple">
                Welcome! 
                {{Auth::user()->USERNAME}}
            </div>
        </div>
        <div class="row gx-2 flex-nowrap">
            <div class="col">
                <div class="card sales-card background-purple white">
                    <div class="card-body d-flex flex-column ">
                        <h6 class="card-title roboto-regular">Total sales this month</h6>
                        <div class="card-text sales-amount roboto-medium-italic align-self-center fs-3">{{$formatter->formatCurrency($totalSales,'USD')}}
                        </div>
                        <div class="align-self-center">
                            @if($totalSalesCompare>0)
                            <span class="badge text-bg-success">{{$formatter->formatCurrency($totalSalesCompare,'USD')}}</span>
                                @else
                                <span class="badge text-bg-danger">{{$formatter->formatCurrency($totalSalesCompare,'USD')}}</span>
                            @endif
                            <span class="sales-period">Compared to last month</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card sales-card background-purple white">
                    <div class="card-body d-flex flex-column ">
                        <h6 class="card-title roboto-regular">Total orders this month</h6>
                        <div class="card-text sales-amount roboto-medium-italic align-self-center fs-3">{{$totalOrders}}
                        </div>
                        <div class="align-self-center">
                            @if($totalOrdersCompare>0)
                                <span class="badge text-bg-success">{{$totalOrdersCompare}} Orders</span>
                            @else
                                <span class="badge text-bg-danger">{{$totalOrdersCompare}} Orders</span>
                            @endif
                            <span class="sales-period">Compared to last month</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card sales-card background-purple white">
                    <div class="card-body d-flex flex-column ">
                        <h6 class="card-title roboto-regular">Total customer this month</h6>
                        <div class="card-text sales-amount roboto-medium-italic align-self-center fs-3">{{$totalCustomers}}
                        </div>
                        <div class="align-self-center">
                            @if($totalCustomersCompare>=0)
                                <span class="badge text-bg-success">{{$totalCustomersCompare}} Customers</span>
                            @else
                                <span class="badge text-bg-danger">{{$totalCustomersCompare}} Customers</span>
                            @endif
                            <span class="sales-period">Compared to last month</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <canvas id="myChart"></canvas>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const ctx = document.getElementById('myChart');
            const options = {
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                }
            };

            // Tạo biểu đồ
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: @json($data),
                options: options
            });

        </script>
@endsection
