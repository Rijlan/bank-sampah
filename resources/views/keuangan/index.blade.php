@extends('layouts.layout')

@section('content')
<h2 style="border-bottom: 4px solid;" class="py-2">
    Keuangan
    @if(Auth::user()->role == 4)
        <span class="float-right">
            <a href="#" data-target="#modalTambahSaldo" data-toggle="modal" class="btn btn-sm btn-neutral"><i class="ni ni-money-coins mr-1"></i>Tambah Saldo</a>
        </span>
    @endif
</h2>

@if(Auth::user()->role == 4)
<div class="modal fade" id="modalTambahSaldo" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="text-center">Tambah Saldo Keuangan</h2>
                <hr class="my-2">
                <form action="{{ route('keuangan.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="date" class="form-control-label">Tanggal</label>
                        <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}"
                            class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="debit" class="form-control-label">Jumlah</label>
                        <input type="number" class="form-control" name="debit" id="debit" min="1000" required />
                    </div>
                    <button class="btn btn-success" type="submit" name="simpan">Confirm</button>
                    <button class="btn btn-primary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Tabel --}}
<div class="table-responsive">
    @if($keuangans->isEmpty())
        <h1 class="text-center">Data Kosong</h1>
    @else
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort">No</th>
                    <th scope="col" class="sort">Tanggal</th>
                    <th scope="col" class="sort">keterangan</th>
                    <th scope="col" class="sort">Debit</th>
                    <th scope="col" class="sort">Kredit</th>
                </tr>
            </thead>
            <tbody class="list">
                @foreach($keuangans as $key => $keuangan)
                    <tr>
                        <td>
                            {{ $key+1 }}
                        </td>
                        <td>
                            {{ $keuangan->created_at }}
                        </td>
                        <td>
                            @if ($keuangan->keterangan == 0)
                                Penambahan Saldo
                            @elseif ($keuangan->keterangan == 1)
                                Penarikan Nasabah
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($keuangan->debit == 0)
                                -
                            @else
                                Rp. {{ number_format($keuangan->debit) }}
                            @endif
                        </td>
                        <td>
                            @if($keuangan->kredit == 0)
                                -
                            @else
                                Rp. {{ number_format($keuangan->kredit) }}
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr class="font-weight-bold border-top">
                    <td colspan="3">Total :</td>
                    <td>
                        Rp. {{ number_format($totalDebit) }}
                    </td>
                    <td>
                        Rp. {{ number_format($totalKredit) }}
                    </td>
                </tr>
                <tr class="font-weight-bolder">
                    <td colspan="4" class="text-right">
                        Saldo :
                    </td>
                    <td>
                        Rp. {{ number_format($total) }}
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
</div>

@if($errors->any())
    <div class="message shadow-sm">
        <div class="alert alert-danger alert-dismissible fade show inner-message" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif

@if(session()->has('message'))
    <div class="message shadow-sm">
        <div class="alert alert-success alert-dismissible fade show inner-message" role="alert">
            <p style="margin-bottom: 0;"><span class="ni ni-check-bold mr-1"></span>
                {{ session()->get('message') }}</p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif
@endsection
