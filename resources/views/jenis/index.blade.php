@extends('layouts.layout')

@section('content')
<h2 style="border-bottom: 4px solid;" class="py-2">Jenis Sampah</h2>

{{-- Tabel --}}
<div class="table-responsive">
    @if ($jenis_sampahs->isEmpty())
        <h1 class="text-center">Data Kosong</h1>
    @else
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort">No</th>
                    <th scope="col" class="sort">Jenis Sampah</th>
                    <th scope="col" class="sort">Harga Nasabah</th>
                    <th scope="col" class="sort">Harga Pengepul</th>
                    <th scope="col" class="sort text-center">Action</th>
                </tr>
            </thead>
            <tbody class="list">
                @foreach ($jenis_sampahs as $key => $jenis_sampah)
                    <tr>
                        <td>
                            {{ $key+1 }}
                        </td>
                        <td>
                            <img src="{{ $jenis_sampah->foto }}" width="20px" class="mr-2">{{ $jenis_sampah->jenis }}
                        </td>
                        <td>
                            Rp. {{ number_format($jenis_sampah->harga_nasabah) }}
                        </td>
                        <td>
                            Rp. {{ number_format($jenis_sampah->harga_pengepul) }}
                        </td>
                        <td class="text-center" style="font-size: 1rem;">
                            <a href="#" data-target="#modalEdit{{ $jenis_sampah->id }}" data-toggle="modal" class="mr-2">
                                <i class="ni ni-settings-gear-65"></i>
                            </a>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('delete-jenis-sampah-{{ $jenis_sampah->id }}').submit();">
                                <i class="ni ni-button-power"></i>
                            </a>
                            <form action="{{ route('jenis.destroy', $jenis_sampah->id) }}" method="POST" class="d-none" id="delete-jenis-sampah-{{ $jenis_sampah->id }}">
                                @csrf
                                @method('delete')
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalEdit{{ $jenis_sampah->id }}" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h2>Update Jenis Sampah</h2>
                                    <hr class="my-4">
                                    <div class="text-center">
                                        <img src="{{ $jenis_sampah->foto }}" width="100px" class="mb-3" />
                                    </div>
                                    <form action="{{ route('jenis.update', $jenis_sampah->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('patch')
                                        <div class="form-group">
                                            <label class="form-control-label" for="jenis">Jenis Sampah</label>
                                            <input type="text" class="form-control" name="jenis" id="jenis" value="{{ $jenis_sampah->jenis }}" required />
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="harga_nasabah">Harga Nasabah</label>
                                                    <input type="number" name="harga_nasabah" id="harga_nasabah" class="form-control" placeholder="Harga untuk Nasabah" value="{{ $jenis_sampah->harga_nasabah }}" required />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="harga_pengepul">Harga Pengepul</label>
                                                    <input type="number" name="harga_pengepul" id="harga_pengepul" class="form-control" placeholder="Harga untuk Pengepul" value="{{ $jenis_sampah->harga_pengepul }}" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="file" class="form-control" name="foto" id="foto" />
                                        </div>
                    
                                        <button class="btn btn-success" type="submit" name="simpan" id="simpan">Save</button>
                                        <button class="btn btn-primary" data-dismiss="modal">Close</button>
                                    </form>
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
                <h2>Tambah Jenis Sampah</h2>
                <hr class="my-4">
                <form action="{{ route('jenis.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-control-label" for="jenis">Jenis Sampah</label>
                        <input type="text" class="form-control" name="jenis" id="jenis" required />
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="harga_nasabah">Harga Nasabah</label>
                                <input type="number" name="harga_nasabah" id="harga_nasabah" class="form-control" placeholder="Harga untuk Nasabah" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="harga_pengepul">Harga Pengepul</label>
                                <input type="number" name="harga_pengepul" id="harga_pengepul" class="form-control" placeholder="Harga untuk Pengepul" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control" name="foto" id="foto" />
                    </div>

                    <button class="btn btn-success" type="submit" name="simpan" id="simpan">Save</button>
                    <button class="btn btn-primary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
