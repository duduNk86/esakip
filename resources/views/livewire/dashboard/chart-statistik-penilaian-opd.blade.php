<div>

    <div class="px-4 mt-10">
        <h2 class="text-xl font-bold mb-2 text-center">Hasil Penilaian Sakip Perangkat Daerah [{{ $filteredTahun }}]
        </h2>
        <div class="bg-white p-6 rounded shadow w-full h-[400px]">
            <canvas id="myBarChartOpd" class="w-full h-full"></canvas>
        </div>

        @push('js')
            <script>
                // Deklarasikan variabel chart di scope global atau di luar fungsi agar bisa diakses
                let myChartOpd;

                // Fungsi untuk membuat/memperbarui chart
                function createOrUpdateChart(data) {
                    var ctx = document.getElementById('myBarChartOpd').getContext('2d');

                    // Hancurkan chart yang ada jika sudah ada
                    if (myChartOpd) {
                        myChartOpd.destroy();
                    }

                    myChartOpd = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Nilai',
                                data: data.values,
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                datalabels: { // Ini untuk label di atas bar
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
                                tooltip: { // INI ADALAH BAGIAN UNTUK TOOLTIP
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
                                y: {
                                    beginAtZero: true
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                }

                // Panggil fungsi untuk pertama kali saat halaman dimuat
                // Pastikan data awal dari Livewire sudah tersedia
                document.addEventListener('livewire:initialized', () => {
                    const initialData = {
                        labels: @json($chartLabels),
                        values: @json($chartValues),
                        predikats: @json($chartPredikats)
                    };
                    createOrUpdateChart(initialData);
                });

                // Dengarkan event 'chartDataUpdated' dari Livewire
                Livewire.on('chartOpdDataUpdated', (data) => {
                    // Livewire mengirimkan array data, ambil objek pertama
                    createOrUpdateChart(data[0]);
                });
            </script>
        @endpush

    </div>

</div>
