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
                            {{ ucwords($penjualan->jenisSampah->jenis) }}
                        </td>
                        <td>
                            {{ $penjualan->berat }} Kg
                        </td>
                        <td>
                            Rp. {{ number_format($penjualan->jenisSampah->harga_pengepul * $penjualan->berat) }}
                        </td>
                        <td class="text-center" style="font-size: 1rem;">
                            <a href="#" onclick="event.preventDefault(); document.getElementById('delete-penjualan-{{ $penjualan->id }}').submit();">
                                <i class="ni ni-button-power"></i>
                            </a>
                            <form action="{{ route('penjualan.destroy', $penjualan->id) }}" method="POSt" class="d-none" id="delete-penjualan-{{ $penjualan->id }}">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
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
@endsection
