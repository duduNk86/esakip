<div>

    <div class="mt-8 px-4">
        <h2 class="text-xl font-bold mb-3 text-center">Hasil Penilaian Sakip Kecamatan [{{ $filteredTahun }}]</h2>
        <div class="bg-white p-6 rounded shadow" style="height: 400px;"> {{-- Tambahkan tinggi agar chart terlihat --}}
            <canvas id="myBarChartKec"></canvas> {{-- Pastikan ID ini unik --}}
        </div>
    </div>

    @push('js')
        <script>
            // Deklarasikan variabel chart di scope global atau di luar fungsi agar bisa diakses
            let myChartKec;

            // Fungsi untuk membuat/memperbarui chart
            function createOrUpdateKecChart(data) {
                var ctx = document.getElementById('myBarChartKec').getContext('2d');

                // Hancurkan chart yang ada jika sudah ada
                if (myChartKec) {
                    myChartKec.destroy();
                }

                myChartKec = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Nilai',
                            data: data.values,
                            backgroundColor: 'rgba(75, 192, 192, 0.5)', // Hijau dengan opasitas 0.5
                            borderColor: 'rgba(75, 192, 192, 1)',
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
                createOrUpdateKecChart(initialData);
            });

            // Dengarkan event 'chartKecDataUpdated' dari Livewire
            Livewire.on('chartKecDataUpdated', (data) => {
                // Livewire mengirimkan array data, ambil objek pertama
                createOrUpdateKecChart(data[0]);
            });
        </script>
    @endpush

</div>
