<div>

    <div class="px-4 mt-10">
        <h2 class="text-xl font-bold mb-2 text-center">Statistik Hasil Penilaian Sakip</h2>
        <div class="bg-white p-6 rounded shadow w-full h-[400px]">
            <canvas id="myUserLineChart" class="w-full h-full"></canvas>
        </div>

        @push('js')
            <script>
                // Deklarasikan variabel chart di scope global untuk menghindari "Unexpected identifier"
                window.myUserChartInstance = null; // Ubah nama variabel global agar tidak bentrok dengan myUserChart

                // Fungsi untuk membuat/memperbarui chart
                function createOrUpdateUserChart(data) {
                    var ctx = document.getElementById('myUserLineChart');

                    // Pastikan elemen canvas ditemukan
                    if (!ctx) {
                        console.error('Canvas element with ID "myUserLineChart" not found.');
                        return;
                    }

                    const chartContext = ctx.getContext('2d');

                    // Hancurkan chart yang ada jika sudah ada
                    if (window.myUserChartInstance) {
                        window.myUserChartInstance.destroy();
                    }

                    window.myUserChartInstance = new Chart(chartContext, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Nilai',
                                data: data.values,
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: false
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                datalabels: {
                                    anchor: 'end',
                                    align: 'end',
                                    color: '#000',
                                    font: {
                                        weight: 'bold'
                                    },
                                    formatter: function(value, context) {
                                        const index = context.dataIndex;
                                        const predikat = data.predikats[index] || '';
                                        return value + ' (' + predikat + ')';
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            let value = context.parsed.y;
                                            const index = context.dataIndex;
                                            const predikat = data.predikats[index] || '';
                                            return label + value + ' (' + predikat + ')';
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Tahun Penilaian'
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Nilai'
                                    }
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                }

                // Panggil fungsi untuk pertama kali saat Livewire diinisialisasi
                document.addEventListener('livewire:initialized', () => {
                    const initialData = {
                        labels: @json($chartLabels),
                        values: @json($chartValues),
                        predikats: @json($chartPredikats)
                    };
                    createOrUpdateUserChart(initialData);
                });

                // Dengarkan event 'chartUserDataUpdated' dari Livewire untuk update data
                Livewire.on('chartUserDataUpdated', (data) => {
                    // Livewire mengirimkan array data, ambil objek pertama
                    createOrUpdateUserChart(data[0]);
                });
            </script>
        @endpush

    </div>

</div>
