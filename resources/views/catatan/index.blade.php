@extends('layouts.layout')

@section('content')
<h2 style="border-bottom: 4px solid;" class="py-2">Catatan</h2>

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
                            Rp. {{ number_format($catatan->jenisSampah->harga_nasabah * $catatan->berat) }}
                        </td>
                        <td>
                            {{ $catatan->user->name }}
                        </td>
                        <td class="text-center" style="font-size: 1rem;">
                            <a href="#" data-target="#modalInfo{{ $catatan->id }}" data-toggle="modal" class="mr-2">
                                <i class="ni ni-zoom-split-in"></i>
                            </a>
                            {{-- <a href="#" onclick="event.preventDefault(); document.getElementById('delete-catatan-{{ $catatan->id }}').submit();">
                                <i class="ni ni-button-power"></i>
                            </a>
                            <form action="{{ route('catatan.destroy', $catatan->id) }}" method="POSt" class="d-none" id="delete-catatan-{{ $catatan->id }}">
                                @csrf
                                @method('delete')
                            </form> --}}
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
                                    <div class="modal-body p-0">
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
                                                        <span>Lokasi</span>
                                                        <br>
                                                        <span class="text-muted">{{ $catatan->user->alamat }}</span>
                                                    </li>
                                                    <li class="font-weight-bold list-group-item non-bordered">
                                                        <span>Keterangan</span>
                                                        <br>
                                                        <span class="text-muted">{{ $catatan->keterangan }}</span>
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
                                                        <span class="text-muted">Rp. {{ number_format($catatan->jenisSampah->harga_nasabah) }}</span>
                                                    </li>
                                                    <li class="font-weight-bold list-group-item non-bordered">
                                                        <span>Berat</span>
                                                        <br>
                                                        <span class="text-muted">{{ $catatan->berat }} Kg</span>
                                                    </li>
                                                    <li class="font-weight-bold list-group-item non-bordered">
                                                        <span>Total Harga</span>
                                                        <br>
                                                        <span class="text-muted">Rp. {{ number_format($catatan->jenisSampah->harga_nasabah * $catatan->berat) }}</span>
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
