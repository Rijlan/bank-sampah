@extends('layouts.layout')

@section('content')
<h2 style="border-bottom: 4px solid;" class="py-2">
    Penjualan
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
                <h2 class="text-center">Info Penjualan</h2>
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
    @if ($penjualans->isEmpty())
        <h1 class="text-center">Data Kosong</h1>
    @else
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort">No</th>
                    <th scope="col" class="sort">Tanggal</th>
                    <th scope="col" class="sort">Nama Pengepul</th>
                    <th scope="col" class="sort">Jenis Sampah</th>
                    <th scope="col" class="sort">Berat</th>
                    <th scope="col" class="sort">Total</th>
                    <th scope="col" class="sort text-center">Action</th>
                </tr>
            </thead>
            <tbody class="list">
                @foreach ($penjualans as $key => $penjualan)
                    <tr>
                        <td>
                            {{ $key+1 }}
                        </td>
                        <td>
                            {{ $penjualan->created_at }}
                        </td>
                        <td>
                            {{ $penjualan->nama_pengepul }}
                        </td>
                        <td>
                            {{ ucwords($penjualan->jenisSampah->jenis) }}
                        </td>
                        <td>
                            {{ $penjualan->berat }} Kg
                        </td>
                        <td>
                            Rp. {{ number_format($penjualan->total) }}
                        </td>
                        <td class="text-center" style="font-size: 1rem;">
                            <a href="#" data-target="#modalInfo{{ $penjualan->id }}" data-toggle="modal" class="mr-2">
                                <i class="ni ni-zoom-split-in"></i>
                            </a>
                            {{-- <a href="#" onclick="event.preventDefault(); document.getElementById('delete-penjualan-{{ $penjualan->id }}').submit();">
                                <i class="ni ni-button-power"></i>
                            </a>
                            <form action="{{ route('penjualan.destroy', $penjualan->id) }}" method="POSt" class="d-none" id="delete-penjualan-{{ $penjualan->id }}">
                                @csrf
                                @method('delete')
                            </form> --}}
                        </td>
                    </tr>

                    <div class="modal fade" id="modalInfo{{ $penjualan->id }}" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h2 class="text-center">Detail Penjualan</h2>
                                    <hr class="my-4">
                                    <div class="p-0">
                                        <div class="row">
                                            <div class="col-md-6 left-right">
                                                <ul class="list-group">
                                                    <li class="font-weight-bold list-group-item non-bordered">
                                                        <span>Tanggal</span>
                                                        <br>
                                                        <span class="text-muted">{{ $penjualan->created_at }}</span>
                                                    </li>
                                                    <li class="font-weight-bold list-group-item non-bordered">
                                                        <span>Nama Pengepul</span>
                                                        <br>
                                                        <span class="text-muted">{{ $penjualan->nama_pengepul }}</span>
                                                    </li>
                                                    <li class="font-weight-bold list-group-item non-bordered">
                                                        <span>Alamat</span>
                                                        <br>
                                                        <span class="text-muted">{{ $penjualan->alamat }}</span>
                                                    </li>
                                                    <li class="font-weight-bold list-group-item non-bordered">
                                                        <span>Telpon</span>
                                                        <br>
                                                        <span class="text-muted">{{ $penjualan->telpon }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="list-group">
                                                    <li class="font-weight-bold list-group-item non-bordered">
                                                        <span>Jenis Sampah</span>
                                                        <br>
                                                        <span class="text-muted">{{ $penjualan->jenisSampah->jenis }}</span>
                                                    </li>
                                                    <li class="font-weight-bold list-group-item non-bordered">
                                                        <span>Harga Satuan</span>
                                                        <br>
                                                        @if($penjualan->jenisSampah->harga_pengepul * $penjualan->berat == $penjualan->total)
                                                            <span class="text-muted">Rp. {{ number_format($penjualan->jenisSampah->harga_pengepul) }}</span>
                                                        @else
                                                            <span class="text-danger">
                                                                Rp. {{ number_format($penjualan->total / $penjualan->berat) }}
                                                            </span>
                                                        @endif
                                                    </li>
                                                    <li class="font-weight-bold list-group-item non-bordered">
                                                        <span>Berat</span>
                                                        <br>
                                                        <span class="text-muted">{{ $penjualan->berat }} Kg</span>
                                                    </li>
                                                    <li class="font-weight-bold list-group-item non-bordered">
                                                        <span>Total Harga</span>
                                                        <br>
                                                        <span class="text-muted">Rp. {{ number_format($penjualan->total) }}</span>
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

        var $chartJual = $('#chart-total-catatan');
        var totalChart = new Chart($chartJual, {
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