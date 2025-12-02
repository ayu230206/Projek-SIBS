@extends('bpdpks.layouts.bpdpks_layout')

@section('title', 'Dashboard') {{-- Judul halaman spesifik --}}

@section('content')

    <div class="header" id="overview">
        <div>
            <div class="welcome">Welcome back, <span
                    style="color:var(--primary)">{{ Session::get('username') ?? 'bpdpks' }}</span></div>
            <div class="subtle">Dashboard overview & quick actions</div>
        </div>
        <div class="controls">
            <div>Today: <strong>{{ date('F j, Y') }}</strong></div>
        </div>
    </div>

    {{-- CARD SECTION (tetap sama) --}}
    <section id="keuangan" class="row g-4 mb-4">
        {{-- CARD 1: Total Recipients --}}
        <div class="col-md-4">
            <div class="card-custom p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div style="font-size:0.88rem; color:#6b776f;">Total Mahasiswa Penerima</div>
                        <div style="font-size:1.55rem; font-weight:700; color:var(--primary)" id="totalRecipients">{{ $chartData['totalRecipients'] ?? 0 }}</div>
                    </div>
                    <div style="text-align:right">
                        <div style="font-size:0.8rem; color:#7b8a82">Data Per</div>
                        <div style="font-weight:700; color:var(--accent)">Saat Ini</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD 2: Active Campuses --}}
        <div class="col-md-4">
            <div class="card-custom p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div style="font-size:0.88rem; color:#6b776f;">Kampus Aktif</div>
                        <div style="font-size:1.55rem; font-weight:700; color:var(--primary)" id="activeCampuses">{{ $chartData['activeCampuses'] ?? 0 }}</div>
                    </div>
                    <div style="text-align:right">
                        <div style="font-size:0.8rem; color:#7b8a82">Kerjasama</div>
                        <div style="font-weight:700; color:var(--accent)">Aktif</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD 3: Pending Approvals --}}
        <div class="col-md-4">
            <div class="card-custom p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div style="font-size:0.88rem; color:#6b776f;">Persetujuan Pending</div>
                        <div style="font-size:1.55rem; font-weight:700; color:var(--primary)" id="pendingApprovals">{{ $pendingApprovals ?? 0 }}</div>
                    </div>
                    <div style="text-align:right">
                        <div style="font-size:0.8rem; color:#7b8a82">Magang/Kampus</div>
                        <div style="font-weight:700; color:#e07a5f">Perlu Tindakan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <hr>

    <section id="data-mahasiswa" class="row g-4 mb-4">
        <div class="col-lg-12">
            <h2 class="section-title"><i class="fas fa-chart-line me-2"></i> Data Mahasiswa (OLAP) - Rata-rata IP per Kampus</h2>
            
            <p class="subtle mt-2 mb-4">
                Analisis visual data IPK. Untuk melihat **daftar lengkap data diri dan performa akademik mahasiswa**,
                silakan klik: <a href="{{ route('bpdpks.datamahasiswa.index') }}" class="btn btn-sm btn-outline-primary ms-2">
                    <i class="fas fa-arrow-right me-1"></i> Data Mahasiswa Penerima
                </a>
            </p>
        </div>
        
        {{-- CHART BAR (IPK by Campus) --}}
        <div class="col-lg-8">
            <div class="card-custom p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="section-title"><span id="chartTitle">Average IPK — All Campuses</span></div>
                    <div>
                        {{-- FILTER KAMPUS DINAMIS --}}
                        <select id="filterKampusChart" class="form-select form-select-sm">
                            <option value="all">Semua Kampus</option>
                            @foreach ($allKampus as $kampus)
                                <option value="{{ $kampus->id }}">
                                    {{ $kampus->nama_kampus }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="chart-box">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>

        {{-- CHART DONUT (IPK Distribution) --}}
        <div class="col-lg-4">
            <div class="card-custom p-3">
                <div class="section-title">IPK Distribution</div>
                <div class="chart-box" style="display: flex; justify-content: center;">
                    <canvas id="donutChart" style="max-width:240px;"></canvas>
                </div>
                <div style="margin-top:10px; font-size:0.95rem; color:#5f6b66;">
                    <div><strong>≥ 3.8</strong> — Excellent</div>
                    <div><strong>3.5 – 3.79</strong> — Good</div>
                    <div><strong>&lt; 3.5</strong> — Needs Attention</div>
                </div>
            </div>
        </div>
    </section>
    
    <hr>
    
    {{-- PERSISTENCE/APPROVAL SECTION (tetap sama) --}}
    <section id="persetujuan" class="mb-4">
        <div class="card-custom p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="section-title"><i class="fas fa-clipboard-list me-2"></i> Persetujuan Magang Mahasiswa</div>
                <input id="internSearch" class="form-control form-control-sm" placeholder="Cari mahasiswa atau universitas..."
                    style="width: 300px;" />
            </div>

            <div class="table-responsive">
                <table id="internTable" class="table align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>University</th>
                            <th>Department</th>
                            <th>Company (Target)</th>
                            <th>Applied On</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Data table persetujuan akan di-load di sini --}}
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section id="students" class="mb-5">
        <div class="card-custom p-4">
            {{-- Isi section students --}}
        </div>
    </section>
    
@endsection

@section('scripts')
    <script>
        // Data PHP yang di-pass ke JavaScript (Inisialisasi)
        const initialBarLabels = @json($chartData['barLabels']);
        const initialBarData = @json($chartData['barData']);
        const initialDonutData = @json($chartData['donutData']);
        const initialDonutLabels = @json($chartData['donutLabels']);
        
        let barChart;
        let donutChart;

        function getCssVar(el) {
            return window.getComputedStyle(el);
        }
        
        // Ambil warna dari CSS
        const primaryColor = getCssVar(document.documentElement).getPropertyValue('--primary').trim()  || '#0b3a2e';
        const secondaryColor = getCssVar(document.documentElement).getPropertyValue('--secondary').trim() || '#bfa15a';
        const dangerColor = getCssVar(document.documentElement).getPropertyValue('--danger').trim() || '#e07a5f';
        
        // Fungsi untuk menginisialisasi/mengupdate grafik
        function initializeCharts(barLabels, barData, donutData, donutLabels) {
             // Bar Chart
            const barCtx = document.getElementById('barChart');
            if (barChart) {
                barChart.destroy(); // Hancurkan chart lama jika ada
            }
            barChart = new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: barLabels, 
                    datasets: [{
                        label: 'Rata-rata IPK',
                        data: barData, 
                        backgroundColor: primaryColor,
                        borderColor: primaryColor,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: false,
                            max: 4.0,
                            min: 3.0
                        }
                    },
                     plugins: {
                         legend: { display: false }
                     }
                }
            });

            // Donut Chart
            const donutCtx = document.getElementById('donutChart');
             if (donutChart) {
                donutChart.destroy(); // Hancurkan chart lama jika ada
            }
            donutChart = new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: donutLabels, 
                    datasets: [{
                        data: donutData, 
                        backgroundColor: [
                            primaryColor,
                            secondaryColor,
                            dangerColor
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
        
        // Fungsi AJAX untuk mengambil data baru berdasarkan filter
        function updateCharts(kampusId) {
            // Tampilkan loading state jika perlu
            $('#chartTitle').text('Loading data...');

            $.ajax({
                url: "{{ route('bpdpks.chartdata.api') }}", // Panggil rute baru
                method: 'GET',
                data: { kampus_id: kampusId },
                success: function(data) {
                    // Update judul chart
                    const selectedKampus = $('#filterKampusChart option:selected').text();
                    $('#chartTitle').text(`Average IPK — ${selectedKampus}`);
                    
                    // Update Card
                    $('#totalRecipients').text(data.totalRecipients);
                    
                    // Re-inisialisasi/update grafik
                    initializeCharts(data.barLabels, data.barData, data.donutData, data.donutLabels);
                },
                error: function(xhr) {
                    console.error('Error fetching chart data:', xhr);
                    $('#chartTitle').text('Average IPK — Error Loading Data');
                }
            });
        }

        $(document).ready(function() {
            
            $('#internTable').DataTable({});

            // 1. Inisialisasi Grafik dengan data dari Controller saat load
            initializeCharts(initialBarLabels, initialBarData, initialDonutData, initialDonutLabels);
            
            // Set Judul Awal
            $('#chartTitle').text('Average IPK — Semua Kampus');

            // 2. Event Listener untuk filter
            $('#filterKampusChart').on('change', function() {
                const selectedId = $(this).val();
                updateCharts(selectedId);
            });

            $('#internSearch').on('keyup', function() {
                $('#internTable').DataTable().search(this.value).draw();
            });
        });
    </script>
@endsection