@php($title = 'Global Dashboard')
@php($daysgone = [120, 95, 140, 80, 110, 75, 130, 90, 150, 100, 125, 105, 160, 115])
@extends('layouts.app')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <div class="md:mx-12">
        <div class="flex gap-2">
            <div><img class="rounded-4xl" src="{{auth()->user()->avatar ?? 'https://yt3.ggpht.com/f0uZg4v91xpYmJP3AKRjmIlBqh6dLhhFDklUgZ555Y7Bb5oHQY1FdANQmptt2XcugN3yqiwDjw=s48-c-k-c0x00ffffff-no-rj'}}"></div>
            <div>
                <div class="text-xl font-bold">Hello Jhon Smith</div>
                <div class=" opacity-70">Welcome Back !</div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-xl p-4 mt-6 ">
            <div>
                <p class="font-bold text-cerulean-700">Expense . last days</p>
                <div class="flex gap-2"><p class="font-bold">{{ $count ?? '2914.00' }}</p>
                    <p>MAD</p></div>
            </div>
            <div class="mt-8 rounded-2xl p-4 bg-cerulean-50 shadow">
            <div id="weeklyExpenseChart" class="h-42.5 p-0" ></div>
            <script>
                let lastDaysMate = @json($daysgone);

                function getEcranSize(){

                    if (window.innerWidth < 768){

                         return lastDaysMate.slice(-7);
                    } else {
                        return lastDaysMate;
                    }
                }


                window.addEventListener('resize', () => {
                    chart.updateSeries([{ name: 'Expense', data: getEcranSize() }]);
                })

                const options = {
                    chart: {
                        type: "bar",
                        height: 170,
                        toolbar: { show: false },
                        sparkline: { enabled: true }, // removes axes and padding (dashboard style)
                    },
                    series: [{ name: "Expense", data: getEcranSize() }],
                    plotOptions: {
                        bar: {
                            columnWidth: "55%",
                            borderRadius: 4, // rounded bars
                        },
                    },
                    dataLabels: { enabled: false },
                    tooltip: {
                        x: { show: false },
                    },
                    grid: { show: false },
                    colors: ["#7EA3B1"], // teal-ish like your design
                };

                const chart = new ApexCharts(document.querySelector("#weeklyExpenseChart"), options);
                chart.render();
            </script>
            </div>
        </div>
        <div class="flex">
            <div class="bg-cerulean-200 text-white rounded-2xl p-5">
                <div class="flex"><h3>Total Paid</h3></div>
                <div class="flex gap-2 "><h3 class="text-2xl">{{ $count ?? '2049' }}</h3><span class="text-sm">MAD</span></div>
                <div>You Paid for Others</div>
            </div>
        </div>
    </div>

@endsection
