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
            <h2 class="text-lg font-semibold mb-4">Consommation d'Énergie (Mois)</h2>
            <div class="flex justify-center">
                <canvas id="energieChart" width="900" height="450"></canvas>
            </div>
            <div class="flex justify-between mt-4">
                <form method="GET" action="{{ route('admin.energie') }}">
                    <div class="flex">
                        <div>
                            <label for="fromDatee" class="text-sm font-semibold text-gray-600">Du:</label>
                            <input type="date" name="fromDatee" id="fromDatee" class="ml-2 border border-gray-300 rounded-md px-3 py-1" value="{{ request('fromDatee') }}">
                        </div>
                        <div class="ml-4">
                            <label for="toDatee" class="text-sm font-semibold text-gray-600">Au:</label>
                            <input type="date" name="toDatee" id="toDatee" class="ml-2 border border-gray-300 rounded-md px-3 py-1" value="{{ request('toDatee') }}">
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
    const energies = @json($energies);

    // Extract filtered date range from request or use current month
    const fromDate = '{{ request('fromDatee') }}' || new Date(new Date().getFullYear(), new Date().getMonth(), 1).toISOString().split('T')[0];
    const toDate = '{{ request('toDatee') }}' || new Date().toISOString().split('T')[0];

    // Generate labels and data for the filtered date range
    const labels = generateLabels(fromDate, toDate);
    const energieAtelieData = labels.map(day => {
        const dataPoint = energies.find(energie => new Date(energie.created_at).getDate() === day);
        return dataPoint ? dataPoint.energie_atelie : null;
    });
    const energieAdminData = labels.map(day => {
        const dataPoint = energies.find(energie => new Date(energie.created_at).getDate() === day);
        return dataPoint ? dataPoint.energie_admin : null;
    });
    const usineData = labels.map(day => {
        const dataPoint = energies.find(energie => new Date(energie.created_at).getDate() === day);
        return dataPoint ? dataPoint.usine : null;
    });
    const magasinData = labels.map(day => {
        const dataPoint = energies.find(energie => new Date(energie.created_at).getDate() === day);
        return dataPoint ? dataPoint.magasin : null;
    });

    // Prepare the data for the chart
    const energieData = {
        labels: labels,
        datasets: [
            {
                label: 'Énergie Atelie',
                data: energieAtelieData,
                borderColor: '#4299E1',
                borderWidth: 2,
                pointRadius: 3,
                spanGaps: true,
                tension: 0 // Set tension to 0 for consistent lines
            },
            {
                label: 'Énergie Admin',
                data: energieAdminData,
                borderColor: '#E53E3E',
                borderWidth: 2,
                pointRadius: 3,
                spanGaps: true,
                tension: 0 // Set tension to 0 for consistent lines
            },
            {
                label: 'Usine',
                data: usineData,
                borderColor: '#38B2AC',
                borderWidth: 2,
                pointRadius: 3,
                spanGaps: true,
                tension: 0 // Set tension to 0 for consistent lines
            },
            {
                label: 'Magasin',
                data: magasinData,
                borderColor: '#ED8936',
                borderWidth: 2,
                pointRadius: 3,
                spanGaps: true,
                tension: 0 // Set tension to 0 for consistent lines
            }
        ]
    };

    const energieConfig = {
        type: 'line',
        data: energieData,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0,
                    max: 500 // Adjust the max value as needed
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            layout: {
                padding: {
                    left: -3
                }
            }
        }
    };

    var energieChart = new Chart(
        document.getElementById('energieChart'),
        energieConfig
    );

    // Update data and labels when a new date range is selected
    function updateChartData() {
        const newLabels = generateLabels(fromDate, toDate);
        const newEnergieAtelieData = newLabels.map(day => {
            const dataPoint = energies.find(energie => new Date(energie.created_at).getDate() === day);
            return dataPoint ? dataPoint.energie_atelie : null;
        });
        const newEnergieAdminData = newLabels.map(day => {
            const dataPoint = energies.find(energie => new Date(energie.created_at).getDate() === day);
            return dataPoint ? dataPoint.energie_admin : null;
        });
        const newUsineData = newLabels.map(day => {
            const dataPoint = energies.find(energie => new Date(energie.created_at).getDate() === day);
            return dataPoint ? dataPoint.usine : null;
        });
        const newMagasinData = newLabels.map(day => {
            const dataPoint = energies.find(energie => new Date(energie.created_at).getDate() === day);
            return dataPoint ? dataPoint.magasin : null;
        });
        energieChart.data.labels = newLabels;
        energieChart.data.datasets[0].data = newEnergieAtelieData;
        energieChart.data.datasets[1].data = newEnergieAdminData;
        energieChart.data.datasets[2].data = newUsineData;
        energieChart.data.datasets[3].data = newMagasinData;
        energieChart.update();
    }

    // Call updateChartData to update the chart with the filtered data
    updateChartData();
});

</script>
@endsection
