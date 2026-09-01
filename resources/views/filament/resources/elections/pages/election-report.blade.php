<x-filament-panels::page>
    @php
        $election = $this->record;
        $election->load(['candidates.votes']);
        $totalVotes = $election->votes()->count();
    @endphp

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Top Cards: Election Details & Results Summary with robust spacing --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.75rem; margin-bottom: 2rem;">
        <x-filament::section>
            <x-slot name="heading">
                Election Details
            </x-slot>
            <div class="space-y-3" style="display: flex; flex-direction: column; gap: 0.75rem;">
                <div class="flex justify-between py-2 border-b border-gray-100 dark:border-gray-800" style="display: flex; justify-content: space-between; border-bottom: 1px solid rgba(156, 163, 175, 0.2); padding-bottom: 0.5rem;">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Title</span>
                    <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $election->title }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100 dark:border-gray-800" style="display: flex; justify-content: space-between; border-bottom: 1px solid rgba(156, 163, 175, 0.2); padding-bottom: 0.5rem;">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $election->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                        {{ $election->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100 dark:border-gray-800" style="display: flex; justify-content: space-between; border-bottom: 1px solid rgba(156, 163, 175, 0.2); padding-bottom: 0.5rem;">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Year</span>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $election->year ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between py-2" style="display: flex; justify-content: space-between; padding-top: 0.25rem;">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Votes Cast</span>
                    <span class="text-base font-bold text-primary-600 dark:text-primary-400" style="font-size: 1.125rem; font-weight: 700; color: #10b981;">{{ $totalVotes }}</span>
                </div>
            </div>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                Results Summary
            </x-slot>
            <div class="space-y-4" style="display: flex; flex-direction: column; gap: 1rem;">
                @forelse($election->candidates as $candidate)
                    @php
                        $votes = $candidate->votes->count();
                        $percentage = $totalVotes > 0 ? round(($votes / $totalVotes) * 100, 1) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between mb-1.5 text-sm font-medium" style="display: flex; justify-content: space-between; margin-bottom: 0.35rem;">
                            <span class="text-gray-800 dark:text-gray-200 font-semibold">{{ $candidate->full_name }}</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $votes }} votes ({{ $percentage }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 dark:bg-gray-700 overflow-hidden" style="background-color: rgba(156, 163, 175, 0.25); border-radius: 9999px; height: 0.75rem; overflow: hidden;">
                            <div class="bg-primary-600 h-3 rounded-full" style="width: {{ $percentage }}%; background-color: #10b981; height: 100%; border-radius: 9999px; transition: width 0.5s ease-in-out;"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 italic">No candidates registered for this election.</p>
                @endforelse
            </div>
        </x-filament::section>
    </div>

    {{-- Chart Section with Dropdown to Toggle Between Pie, Bar, and Line --}}
    <div style="margin-top: 1.5rem;">
        <x-filament::section>
            <x-slot name="heading">
                Votes Distribution
            </x-slot>

            <x-slot name="afterHeader">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <label for="chartTypeSelect" style="font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase;">Chart Type:</label>
                    <select
                        id="chartTypeSelect"
                        onchange="window.switchReportChart(this.value)"
                        style="padding: 0.35rem 2rem 0.35rem 0.75rem; font-size: 0.875rem; border-radius: 0.5rem; border: 1px solid #d1d5db; cursor: pointer;"
                        class="rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm font-medium"
                    >
                        <option value="pie" selected>Pie Chart</option>
                        <option value="bar">Bar Chart</option>
                        <option value="line">Line Chart</option>
                    </select>
                </div>
            </x-slot>

            <div id="pieContainer" style="position: relative; height: 380px; width: 100%;">
                <canvas id="reportPieCanvas"></canvas>
            </div>

            <div id="barContainer" style="position: relative; height: 380px; width: 100%; display: none;">
                <canvas id="reportBarCanvas"></canvas>
            </div>

            <div id="lineContainer" style="position: relative; height: 380px; width: 100%; display: none;">
                <canvas id="reportLineCanvas"></canvas>
            </div>
        </x-filament::section>
    </div>

    <script>
        let pieChartInstance = null;
        let barChartInstance = null;
        let lineChartInstance = null;

        window.switchReportChart = function(type) {
            const pie = document.getElementById('pieContainer');
            const bar = document.getElementById('barContainer');
            const line = document.getElementById('lineContainer');

            if (pie) pie.style.display = (type === 'pie') ? 'block' : 'none';
            if (bar) bar.style.display = (type === 'bar') ? 'block' : 'none';
            if (line) line.style.display = (type === 'line') ? 'block' : 'none';

            if (type === 'pie' && pieChartInstance) pieChartInstance.resize();
            if (type === 'bar' && barChartInstance) barChartInstance.resize();
            if (type === 'line' && lineChartInstance) lineChartInstance.resize();
        };

        function initAllReportCharts() {
            const chartLabels = @json($chartLabels);
            const chartData = @json($chartData);
            const chartColors = @json($chartColors);
            const lineLabels = @json($lineLabels);
            const lineData = @json($lineData);

            const pieCtx = document.getElementById('reportPieCanvas');
            if (pieCtx && !pieChartInstance) {
                pieChartInstance = new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: chartLabels.length ? chartLabels : ['No votes recorded'],
                        datasets: [{
                            data: chartData.length ? chartData : [1],
                            backgroundColor: chartColors.length ? chartColors : ['#9ca3af'],
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 14,
                                    padding: 16
                                }
                            }
                        }
                    }
                });
            }

            const barCtx = document.getElementById('reportBarCanvas');
            if (barCtx && !barChartInstance) {
                barChartInstance = new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: chartLabels.length ? chartLabels : ['No candidates'],
                        datasets: [{
                            label: 'Votes',
                            data: chartData.length ? chartData : [0],
                            backgroundColor: chartColors.length ? chartColors : ['#008751'],
                            borderRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
                            }
                        },
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            }

            const lineCtx = document.getElementById('reportLineCanvas');
            if (lineCtx && !lineChartInstance) {
                lineChartInstance = new Chart(lineCtx, {
                    type: 'line',
                    data: {
                        labels: lineLabels.length ? lineLabels : ['No timeline data'],
                        datasets: [{
                            label: 'Votes Cast',
                            data: lineData.length ? lineData : [0],
                            borderColor: '#008751',
                            backgroundColor: 'rgba(0, 135, 81, 0.15)',
                            borderWidth: 3,
                            tension: 0.3,
                            fill: true,
                            pointBackgroundColor: '#008751',
                            pointRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
                            }
                        }
                    }
                });
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initAllReportCharts);
        } else {
            initAllReportCharts();
        }
        document.addEventListener('livewire:navigated', initAllReportCharts);
    </script>
</x-filament-panels::page>
