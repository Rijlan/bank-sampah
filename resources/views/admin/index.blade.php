@extends('layouts.layout')

@section('stats')
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Total Sampah</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $total }} Kg</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                            <i class="ni ni-archive-2"></i>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
                    <a href="{{ route('catatan.index') }}">
                        <span class="text-primary mr-2"><i class="fa fa-arrow-right"></i> </span>
                        <span class="text-nowrap">Read More</span>
                    </a>
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Terjual</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $sudah }} Kg</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                            <i class="ni ni-delivery-fast"></i>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
                    <a href="{{ route('penjualan.index') }}">
                        <span class="text-primary mr-2"><i class="fa fa-arrow-right"></i> </span>
                        <span class="text-nowrap">Read More</span>
                    </a>
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Tersedia</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $belum }} Kg</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-blue text-white rounded-circle shadow">
                            <i class="ni ni-box-2"></i>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
                    <a href="#tersedia">
                        <span class="text-primary mr-2"><i class="fa fa-arrow-right"></i> </span>
                        <span class="text-nowrap">Read More</span>
                    </a>
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Saldo</h5>
                        <span class="h2 font-weight-bold mb-0">Rp. {{ number_format($saldo) }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                            <i class="ni ni-money-coins"></i>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
                    <a href="{{ route('keuangan.index') }}">
                        <span class="text-primary mr-2"><i class="fa fa-arrow-right"></i> </span>
                        <span class="text-nowrap">Read More</span>
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8" id="tersedia">
            <div class="row align-items-center">
                <div class="col mb-5">
                    <h5 class="h3 mb-0 text-muted">Sampah Tersedia</h5>
                </div>
            </div>
            <!-- Chart -->
            <div class="chart">
                <canvas id="chart-bars-tersedia" class="chart-canvas"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="leaderboard">
                <div class="leaderboard-header p-3 mb-0">
                    <h3 class="mb-0 text-center"><span class="ni ni-trophy mr-1"></span> LEADERBOARD</h3>
                </div>
                <div class="leaderboard-body">
                    <ol class="leaderboard-list mb-0">
                        @php
                        $i = 1;
                        @endphp
                        @foreach($peringkat as $key => $peringkat)                        
                        @if ($peringkat->total_berat == 0 || $peringkat->total_harga == 0)
                            @php
                            continue;
                            @endphp
                        @endif
                            <li class="d-flex bd-highlight p-2">
                                <p class="bd-highlight mr-2 m-0 font-weight-bold">{{ $i++ }}.</p>
                                <p class="bd-highlight mb-0">{{ ucwords($peringkat->name) }}</p>
                                <small class="ml-auto bd-highlight">Rp. {{ number_format($peringkat->total_harga) }}
                                    ({{ $peringkat->total_berat }} Kg)</small>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        var data = @json($tersedia);
        var Jenis = new Array();
        var Berat = new Array();
        
        data.forEach(data => {
            Jenis.push(data.jenis);
            Berat.push(data.berat);
        });            

        var $chart = $('#chart-bars-tersedia');
        var tersediaChart = new Chart($chart, {
            type: 'bar',
            data: {
                labels: Jenis,
                datasets: [{
                    label: 'Tersedia',
                    data: Berat
                }]
            }
        });
            
    </script>
@endsection