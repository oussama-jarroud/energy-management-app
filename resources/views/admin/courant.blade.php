@extends('layouts.admin')

@section('content')
<div class="flex flex-col lg:flex-row min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-full lg:w-72 bg-gray-800 shadow-lg rounded-r-lg lg:rounded-r-none mb-4 lg:mb-0">
        <div class="p-8">
            <div class="text-white text-xl font-bold mb-6">{{ __('Navigation') }}</div>
            <nav class="mt-10">
                <ul>
                    <li x-data="{ open: false }" class="mb-4">
                        <a @click="open = !open" href="#" class="flex items-center justify-between text-gray-300 hover:text-white hover:bg-gray-700 px-4 py-3 rounded-lg transition duration-200">
                            <span class="font-semibold">{{ __('Gestion des données') }}</span>
                            <span>
                                <i :class="{ 'fa-chevron-up': open, 'fa-chevron-down': !open }" class="fas"></i>
                            </span>
                        </a>
                        <ul x-show="open" class="pl-4">
                            <a href="{{ route('admin.courant') }}" class="flex items-center justify-between text-gray-300 hover:text-white hover:bg-gray-700 px-4 py-3 rounded-lg transition duration-200">
                                <span class="font-semibold">{{ __('Courant') }}</span>
                            </a>
                            <a href="{{ route('admin.tension') }}" class="flex items-center justify-between text-gray-300 hover:text-white hover:bg-gray-700 px-4 py-3 rounded-lg transition duration-200">
                                <span class="font-semibold">{{ __('Tension') }}</span>
                            </a>
                            <a href="{{ route('admin.puissance') }}" class="flex items-center justify-between text-gray-300 hover:text-white hover:bg-gray-700 px-4 py-3 rounded-lg transition duration-200">
                                <span class="font-semibold">{{ __('Puissance') }}</span>
                            </a>
                            <a href="{{ route('admin.energie') }}" class="flex items-center justify-between text-gray-300 hover:text-white hover:bg-gray-700 px-4 py-3 rounded-lg transition duration-200">
                                <span class="font-semibold">{{ __('Énergie') }}</span>
                            </a>
                            <a href="{{ route('admin.facteur_puissance') }}" class="flex items-center justify-between text-gray-300 hover:text-white hover:bg-gray-700 px-4 py-3 rounded-lg transition duration-200">
                                <span class="font-semibold">{{ __('Facteur de Puissance') }}</span>
                            </a>
                            <a href="{{ route('admin.frequence') }}" class="flex items-center justify-between text-gray-300 hover:text-white hover:bg-gray-700 px-4 py-3 rounded-lg transition duration-200">
                                <span class="font-semibold">{{ __('Fréquence') }}</span>
                            </a>
                        </ul>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('admin.rapport')}}" class="flex items-center justify-between text-gray-300 hover:text-white hover:bg-gray-700 px-4 py-3 rounded-lg transition duration-200">
                            <span class="font-semibold">{{ __('Rapports') }}</span>
                            <span><i class="fas fa-chart-bar"></i></span>
                        </a>
                    </li>
                    <li x-data="{ open: false }" class="mb-4">
                        <a @click="open = !open" href="#" class="flex items-center justify-between text-gray-300 hover:text-white hover:bg-gray-700 px-4 py-3 rounded-lg transition duration-200">
                            <span class="font-semibold">{{ __('Réglage') }}</span>
                            <span>
                                <i :class="{ 'fa-chevron-up': open, 'fa-chevron-down': !open }" class="fas"></i>
                            </span>
                        </a>
                        <ul x-show="open" class="pl-4">
                            <li>
                                <a href="{{ route('admin.gestion_alarme') }}" class="flex items-center justify-between text-gray-300 hover:text-white hover:bg-gray-700 px-4 py-3 rounded-lg transition duration-200">
                                    <span class="font-semibold">{{ __('Gestion d\'alarme') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.gestion_utilisateur') }}" class="flex items-center justify-between text-gray-300 hover:text-white hover:bg-gray-700 px-4 py-3 rounded-lg transition duration-200">
                                    <span class="font-semibold">{{ __('Gestion d\'utilisateur') }}</span>
                                </a>
                            </li>   
                    </li>
                </ul>
                <li>
                    <a href="{{ route('admin.historique_alarme') }}" class="flex items-center justify-between text-gray-300 hover:text-white hover:bg-gray-700 px-4 py-3 rounded-lg transition duration-200">
                        <span class="font-semibold">{{ __('Historique Alarme') }}</span>
                    </a>
                    </li>
            </nav>
        </div>
    </aside>

<div class="px-20 py-14">
    <div class="max-w-5xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Consommation de courant (Mois)</h2>
            <div class="flex justify-center">
                <canvas id="courantChart" width="900" height="450"></canvas>
            </div>
            <div class="flex justify-between mt-4">
    <form method="GET" action="{{ route('admin.courant') }}">
        <div class="flex">
            <div>
                <label for="fromDate" class="text-sm font-semibold text-gray-600">Du:</label>
                <input type="date" name="fromDate" id="fromDate" class="ml-2 border border-gray-300 rounded-md px-3 py-1" value="{{ request('fromDate') }}">
            </div>
            <div class="ml-4">
                <label for="toDate" class="text-sm font-semibold text-gray-600">Au:</label>
                <input type="date" name="toDate" id="toDate" class="ml-2 border border-gray-300 rounded-md px-3 py-1" value="{{ request('toDate') }}">
            </div>
            <div class="ml-4">
                <button type="submit" class="ml-4 bg-blue-500 text-white px-4 py-2 rounded">Filtrer</button>
            </div>
        </div>
    </form>
</div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Function to generate labels for the date range
    function generateLabels(fromDate, toDate) {
        const start = new Date(fromDate);
        const end = new Date(toDate);
        const labels = [];
        for (let dt = new Date(start); dt <= end; dt.setDate(dt.getDate() + 1)) {
            labels.push(new Date(dt).getDate());
        }
        return labels;
    }

    // Initial data from Laravel
    const courants = @json($courants);

    // Extract filtered date range from request or use current month
    const fromDate = '{{ request('fromDate') }}' || new Date(new Date().getFullYear(), new Date().getMonth(), 1).toISOString().split('T')[0];
    const toDate = '{{ request('toDate') }}' || new Date().toISOString().split('T')[0];

    // Generate labels and data for the filtered date range
    const labels = generateLabels(fromDate, toDate);
    const courantAtelieData = labels.map(day => {
        const dataPoint = courants.find(courant => new Date(courant.created_at).getDate() === day);
        return dataPoint ? dataPoint.courant_atelie : null;
    });
    const courantAdminData = labels.map(day => {
        const dataPoint = courants.find(courant => new Date(courant.created_at).getDate() === day);
        return dataPoint ? dataPoint.courant_admin : null;
    });
    const usineData = labels.map(day => {
        const dataPoint = courants.find(courant => new Date(courant.created_at).getDate() === day);
        return dataPoint ? dataPoint.usine : null;
    });
    const magasinData = labels.map(day => {
        const dataPoint = courants.find(courant => new Date(courant.created_at).getDate() === day);
        return dataPoint ? dataPoint.magasin : null;
    });

    // Prepare the data for the chart
    const courantData = {
        labels: labels,
        datasets: [
            {
                label: 'Courant Atelie',
                data: courantAtelieData,
                borderColor: '#4299E1',
                borderWidth: 2,
                pointRadius: 3,
                spanGaps: true,
                tension: 0
            },
            {
                label: 'Courant Admin',
                data: courantAdminData,
                borderColor: '#E53E3E',
                borderWidth: 2,
                pointRadius: 3,
                spanGaps: true,
                tension: 0
            },
            {
                label: 'Usine',
                data: usineData,
                borderColor: '#38B2AC',
                borderWidth: 2,
                pointRadius: 3,
                spanGaps: true,
                tension: 0
            },
            {
                label: 'Magasin',
                data: magasinData,
                borderColor: '#ED8936',
                borderWidth: 2,
                pointRadius: 3,
                spanGaps: true,
                tension: 0
            }
        ]
    };

    // Configuration for the chart
    const courantConfig = {
        type: 'line',
        data: courantData,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0,
                    max: 50
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            layout: {
                padding: {
                    left: -2
                }
            }
        }
    };

    // Create the chart
    var courantChart = new Chart(
        document.getElementById('courantChart'),
        courantConfig
    );

    // Update data and labels when a new date range is selected
    function updateChartData() {
        const newLabels = generateLabels(fromDate, toDate);
        const newCourantAtelieData = newLabels.map(day => {
            const dataPoint = courants.find(courant => new Date(courant.created_at).getDate() === day);
            return dataPoint ? dataPoint.courant_atelie : null;
        });
        const newCourantAdminData = newLabels.map(day => {
            const dataPoint = courants.find(courant => new Date(courant.created_at).getDate() === day);
            return dataPoint ? dataPoint.courant_admin : null;
        });
        const newUsineData = newLabels.map(day => {
            const dataPoint = courants.find(courant => new Date(courant.created_at).getDate() === day);
            return dataPoint ? dataPoint.usine : null;
        });
        const newMagasinData = newLabels.map(day => {
            const dataPoint = courants.find(courant => new Date(courant.created_at).getDate() === day);
            return dataPoint ? dataPoint.magasin : null;
        });
        courantChart.data.labels = newLabels;
        courantChart.data.datasets[0].data = newCourantAtelieData;
        courantChart.data.datasets[1].data = newCourantAdminData;
        courantChart.data.datasets[2].data = newUsineData;
        courantChart.data.datasets[3].data = newMagasinData;
        courantChart.update();
    }

    // Call updateChartData to update the chart with the filtered data
    updateChartData();
});


</script>

@endsection
