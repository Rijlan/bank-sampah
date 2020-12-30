@extends('layouts.layout')

@section('content')
<h2 style="border-bottom: 4px solid;" class="py-2">Penjualan</h2>

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
                    <th scope="col" class="sort">Jenis Sampah</th>
                    <th scope="col" class="sort">Berat</th>
                    <th scope="col" class="sort">Total</th>
                    {{-- <th scope="col" class="sort text-center">Action</th> --}}
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
                            {{ ucwords($penjualan->jenisSampah->jenis) }}
                        </td>
                        <td>
                            {{ $penjualan->berat }} Kg
                        </td>
                        <td>
                            Rp. {{ number_format($penjualan->jenisSampah->harga_pengepul * $penjualan->berat) }}
                        </td>
                        {{-- <td class="text-center" style="font-size: 1rem;">
                            <a href="#" onclick="event.preventDefault(); document.getElementById('delete-penjualan-{{ $penjualan->id }}').submit();">
                                <i class="ni ni-button-power"></i>
                            </a>
                            <form action="{{ route('penjualan.destroy', $penjualan->id) }}" method="POSt" class="d-none" id="delete-penjualan-{{ $penjualan->id }}">
                                @csrf
                                @method('delete')
                            </form>
                        </td> --}}
                    </tr>
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

@if (Auth::user()->role == 4)
<div class="my-3 mx-3 float-right">
    <a href="#" data-target="#modalTambah" data-toggle="modal">
        <button class="btn btn-success" style="font-size: 1rem;">
            <i class="ni ni-fat-add"></i>
        </button>
    </a>
</div>

<div class="modal fade" id="modalTambah" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2>Jual ke Pengepul</h2>
                <hr class="my-4">
                <form action="{{ route('penjualan.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="jenis_sampah">Jenis Sampah</label>
                                <select name="jenis_sampah_id" id="jenis_sampah" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($jenis_sampahs as $jenis_sampah)
                                        <option value="{{ $jenis_sampah->id }}">{{ $jenis_sampah->jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-control-label" for="harga_pengepul">Harga Satuan</label>
                            <input type="number" class="form-control" name="harga_pengepul" id="harga_pengepul" disabled />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="berat">Berat (Kg)</label>
                        <input type="number" class="form-control" name="berat" id="berat" required />
                    </div>

                    <button class="btn btn-success" type="submit" name="simpan" id="simpan">Save</button>
                    <button class="btn btn-primary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
