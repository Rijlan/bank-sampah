@extends('layouts.layout')

@section('content')
<h2 style="border-bottom: 4px solid;" class="py-2">
    Catatan
    <span class="float-right">
        <a href="#" data-target="#modalTotal" data-toggle="modal" class="btn btn-sm btn-primary"><i class="ni ni-chart-pie-35" style="font-size: 1rem;"></i></a>
    </span>
</h2>

<div class="modal fade" id="modalTotal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <button class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="text-center">Info Catatan</h2>
                <hr class="my-2">
                <div class="row mt-4 py-3">
                    <div class="col-lg-8">
                        <div class="chart">
                            <canvas class="chart-canvas" id="chart-total-catatan"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-2">
                        <h2 class="text-center text-muted">Keterangan</h2>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="sort">Jenis</th>
                                        <th class="sort">Berat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($totals as $total)
                                    <tr>
                                        <td>{{ $total->jenis }}</td>
                                        <td>{{ $total->berat }} Kg</td>
                                    </tr>
                                    @endforeach
                                    <tr class="font-weight-bold">
                                        <td>Total :</td>
                                        <td>{{ $grand_total }} Kg</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Tabel --}}
<div class="table-responsive">
    @if ($catatans->isEmpty())
        <h1 class="text-center">Data Kosong</h1>
    @else
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort">No</th>
                    <th scope="col" class="sort">Tanggal</th>
                    <th scope="col" class="sort">Jenis Sampah</th>
                    <th scope="col" class="sort">Berat</th>
                    <th scope="col" class="sort">Harga</th>
                    <th scope="col" class="sort">Nasabah</th>
                    <th scope="col" class="sort text-center">Action</th>
                </tr>
            </thead>
            <tbody class="list">
                @foreach ($catatans as $key => $catatan)
                    <tr>
                        <td>
                            {{ $key+1 }}
                        </td>
                        <td>
                            {{ $catatan->created_at }}
                        </td>
                        <td>
                            {{ ucwords($catatan->jenisSampah->jenis) }}
                        </td>
                        <td>
                            {{ $catatan->berat }} Kg
                        </td>
                        <td>
                            Rp. {{ number_format($catatan->total_harga) }}
                        </td>
                        <td>
                            {{ $catatan->user->name }}
                        </td>
                        <td class="text-center" style="font-size: 1rem;">
                            <a href="#" data-target="#modalInfo{{ $catatan->id }}" data-toggle="modal" class="mr-2">
                                <i class="ni ni-zoom-split-in"></i>
                            </a>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalInfo{{ $catatan->id }}" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h2 class="text-center">Detail Catatan</h2>
                                    <hr class="my-4">
                                    <div class="p-0">
                                        <div class="row">
                                            <div class="col-md-6 left-right">
                                                <ul class="list-group">
                                                    <li class="font-weight-bold list-group-item non-bordered">
                                                        <span>Tanggal</span>
                                                        <br>
                                                        <span class="text-muted">{{ $catatan->created_at }}</span>
                                                    </li>
                                                    <li class="font-weight-bold list-group-item non-bordered">
                                                        <span>Nasabah</span>
                                                        <br>
                                                        <span class="text-muted">{{ $catatan->user->name }}</span>
                                                    </li>
                                                    <li class="font-weight-bold list-group-item non-bordered">
                                                        <span>Telpon</span>
                                                        <br>
                                                        <span class="text-muted">{{ $catatan->user->telpon }}</span>
                                                    </li>
                                                    <li class="font-weight-bold list-group-item non-bordered">
                                                        <span>Keterangan</span>
                                                        <br>
                                                        <span class="text-muted">{{ $catatan->keterangan == 1 ? 'Dijemput' : ($catatan->keterangan == 2 ? 'Dikantor' : '')}}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="list-group">
                                                    <li class="font-weight-bold list-group-item non-bordered">
                                                        <span>Jenis Sampah</span>
                                                        <br>
                                                        <span class="text-muted">{{ $catatan->jenisSampah->jenis }}</span>
                                                    </li>
                                                    <li class="font-weight-bold list-group-item non-bordered">
                                                        <span>Harga Satuan</span>
                                                        <br>
                                                        @if ($catatan->keterangan == 1)
                                                            @if (($catatan->jenisSampah->harga_nasabah - $catatan->jenisSampah->harga_nasabah * 0.2) * $catatan->berat == $catatan->total_harga)
                                                                <span class="text-muted">Rp. {{ number_format($catatan->jenisSampah->harga_nasabah) }}</span>
                                                            @else
                                                                <span class="text-danger">
                                                                    Rp. {{ number_format($catatan->total_harga / $catatan->berat + ($catatan->jenisSampah->harga_nasabah * 0.2)) }}
                                                                </span>
                                                            @endif
                                                        @else
                                                            @if($catatan->jenisSampah->harga_nasabah * $catatan->berat == $catatan->total_harga)
                                                                <span class="text-muted">Rp. {{ number_format($catatan->jenisSampah->harga_nasabah) }}</span>
                                                            @else
                                                            <span class="text-danger">
                                                                Rp. {{ number_format($catatan->total_harga / $catatan->berat) }}
                                                            </span>
                                                            @endif
                                                        @endif
                                                    </li>
                                                    <li class="font-weight-bold list-group-item non-bordered">
                                                        <span>Berat</span>
                                                        <br>
                                                        <span class="text-muted">{{ $catatan->berat }} Kg</span>
                                                    </li>
                                                    <li class="font-weight-bold list-group-item non-bordered">
                                                        <span>Total Harga</span>
                                                        <br>
                                                        <span class="text-muted">Rp. {{ number_format($catatan->total_harga) }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>

        <div class="container py-4">
            {{ $catatans->links() }}
        </div>
    @endif
</div>

@if ($errors->any())
    <div class="message shadow-sm">
        <div class="alert alert-danger alert-dismissible fade show inner-message" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif

@if (session()->has('message'))
    <div class="message shadow-sm">
        <div class="alert alert-success alert-dismissible fade show inner-message" role="alert">
            <p style="margin-bottom: 0;"><span class="ni ni-check-bold mr-1"></span> {{ session()->get('message') }}</p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif
@endsection

@section('script')
    <script>
        var data = @json($totals);
        var Jenis = new Array();
        var Berat = new Array();
        
        data.forEach(data => {
            Jenis.push(data.jenis);
            Berat.push(data.berat);
        });

        var $chartTotal = $('#chart-total-catatan');
        var totalChart = new Chart($chartTotal, {
            type: 'pie',
            data: {
                labels: Jenis,
                datasets: [{
                    label: 'Total',
                    data: Berat,
                    borderWidth: 1,
                    backgroundColor: ['#5e72e4', '#99FF33', '#FF6600', '#FFFF33', '#9E9E9E', '#BBDEFB'],
                }]
            }
        });
            
    </script>
@endsection