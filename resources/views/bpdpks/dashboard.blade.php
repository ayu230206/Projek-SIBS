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


    <section id="keuangan" class="row g-4 mb-4">
        {{-- CARD 1: Total Recipients --}}
        <div class="col-md-4">
            <div class="card-custom p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div style="font-size:0.88rem; color:#6b776f;">Total Recipients</div>
                        <div style="font-size:1.55rem; font-weight:700; color:var(--primary)">7.000</div>
                    </div>
                    <div style="text-align:right">
                        <div style="font-size:0.8rem; color:#7b8a82">This year</div>
                        <div style="font-weight:700; color:var(--accent)">+8.4%</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD 2: Active Campuses --}}
        <div class="col-md-4">
            <div class="card-custom p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div style="font-size:0.88rem; color:#6b776f;">Active Campuses</div>
                        <div style="font-size:1.55rem; font-weight:700; color:var(--primary)">10</div>
                    </div>
                    <div style="text-align:right">
                        <div style="font-size:0.8rem; color:#7b8a82">Monitored</div>
                        <div style="font-weight:700; color:var(--accent)">Premium</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD 3: Pending Approvals --}}
        <div class="col-md-4">
            <div class="card-custom p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div style="font-size:0.88rem; color:#6b776f;">Pending Approvals</div>
                        <div style="font-size:1.55rem; font-weight:700; color:var(--primary)">6</div>
                    </div>
                    <div style="text-align:right">
                        <div style="font-size:0.8rem; color:#7b8a82">Internships</div>
                        <div style="font-weight:700; color:#e07a5f">Action needed</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <hr>

    <section id="data-mahasiswa" class="row g-4 mb-4">
        <div class="col-lg-12">
            <h2 class="section-title"><i class="fas fa-chart-line me-2"></i> Data Mahasiswa (OLAP) - Rata-rata IP per Kampus</h2>
        </div>
        
        {{-- CHART BAR (IPK by Campus) --}}
        <div class="col-lg-8">
            <div class="card-custom p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="section-title">Average IPK — by Campus</div>
                    <div>
                        <select id="filterCampus" class="form-select form-select-sm">
                            <option value="all">All campuses</option>
                            <option value="PCR">PCR</option>
                            <option value="UNRI">UNRI</option>
                            <option value="UNILAK">UNILAK</option>
                            <option value="UIN Suska">UIN Suska</option>
                            <option value="UMRI">UMRI</option>
                            <option value="INSTIPER">INSTIPER</option>
                            <option value="UNDIP">UNDIP</option>
                            <option value="POLBANGTAN">POLBANGTAN</option>
                            <option value="IPB">IPB</option>
                            <option value="ITERA">ITERA</option>
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

    <section id="data-mahasiswa-table" class="mb-4">
        <div class="card-custom p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="section-title"><i class="fas fa-table me-2"></i> Data Detail Penerima (Filtrasi OLAP)</div>
                <div style="min-width:240px;">
                    <input id="tableSearch" class="form-control form-control-sm"
                        placeholder="Search recipients (name, campus)..." />
                </div>
            </div>

            <div class="table-responsive">
                <table id="recipientsTable" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Campus</th>
                            <th>Class</th>
                            <th>IPK</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Data table akan di-load di sini --}}
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <hr>
    
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
    {{-- Inisialisasi Chart dan DataTables diletakkan di sini --}}
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            $('#recipientsTable').DataTable({
                // Konfigurasi DataTables di sini
            });
            $('#internTable').DataTable({
                // Konfigurasi DataTables di sini
            });

            // Inisialisasi Chart Bar (BarChart)
            const barCtx = document.getElementById('barChart');
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: ['PCR', 'UNRI', 'UNILAK', 'UIN Suska', 'UMRI', 'INSTIPER', 'UNDIP', 'POLBANGTAN', 'IPB', 'ITERA'],
                    datasets: [{
                        label: 'Rata-rata IPK',
                        data: [3.85, 3.68, 3.72, 3.55, 3.79, 3.81, 3.60, 3.90, 3.75, 3.65], // Data dummy
                        backgroundColor: 'rgba(11, 58, 46, 0.8)', // var(--primary)
                        borderColor: 'rgba(11, 58, 46, 1)',
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
                    }
                }
            });

            // Inisialisasi Chart Donut (DonutChart)
            const donutCtx = document.getElementById('donutChart');
            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Excellent (≥ 3.8)', 'Good (3.5 – 3.79)', 'Needs Attention (< 3.5)'],
                    datasets: [{
                        data: [40, 50, 10], // Data dummy (40%, 50%, 10%)
                        backgroundColor: [
                            '#0b3a2e', // Primary
                            '#bfa15a', // Accent
                            '#e07a5f'  // Danger
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
@endsection