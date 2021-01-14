@extends('layouts.layout')

@section('content')
<h2 style="border-bottom: 4px solid;" class="py-2">Tabungan {{ $user->name }}
    @if (Auth::user()->role == 4)
    <span class="float-right">
        <a href="#" data-target="#modalTarik" data-toggle="modal" class="btn btn-sm btn-neutral"><i class="ni ni-money-coins mr-1"></i>Tarik</a>
    </span>
    @endif
</h2>

@if (Auth::user()->role == 4)
<div class="modal fade" id="modalTarik" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2>Penarikan Uang</h2>
                <hr class="my-4">
                <form action="{{ route('nasabah.tarik', $user->id) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="date" class="form-control-label">Tanggal</label>
                        <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="kredit" class="form-control-label">Jumlah</label>
                        <input type="number" class="form-control" name="kredit" id="kredit" min="1000" max="{{ $total }}">
                    </div>
                    <button class="btn btn-success" type="submit" name="simpan">Confirm</button>
                    <button class="btn btn-primary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-md-6">
        <div class="card py-3 shadow-none bg-primary info-tabungan">
            <div class="card-body">
                <h2 style="border-bottom: 1px solid;" class="py-2">Pemilik</h2>
                <div>
                    <h4>Nama : {{ $user->name }}</h4>
                    <h4>Email : {{ $user->email }}</h4>
                    <h4>Telepon : {{ $user->telpon }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="alert py-4 bg-primary info-tabungan">
            <h2 style="border-bottom: 1px solid;" class="py-2 mt-3">Tabungan</h2>
            <h4>Total Debit : Rp. {{ number_format($totalDebit) }}</h4>
            <h4>Total Kredit : Rp. {{ number_format($totalKredit) }}</h4>
            <p>Saldo Tabungan : Rp. {{ number_format($total) }}</p>
        </div>
    </div>
</div>

<hr class="my-2">

{{-- Tabel --}}
<h3 class="text-center">Riwayat Transaksi</h3>
<hr class="mt-2 mb-0">
<div class="table-responsive">
    @if ($tabungans->isEmpty())
        <h1 class="text-center">Data Kosong</h1>
    @else
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort">No</th>
                    <th scope="col" class="sort">Tanggal</th>
                    <th scope="col" class="sort">Debit</th>
                    <th scope="col" class="sort">Kredit</th>
                </tr>
            </thead>
            <tbody class="list">
                @foreach ($tabungans as $key => $tabungan)
                    <tr>
                        <td>
                            {{ $key+1 }}
                        </td>
                        <td>
                            {{ $tabungan->created_at }}
                        </td>
                        <td>
                            @if ($tabungan->debit == 0)
                                -
                            @else
                                Rp. {{ number_format($tabungan->debit_raw) }}
                            @endif
                        </td>
                        <td>
                            @if ($tabungan->kredit == 0)
                                -
                            @else
                                Rp. {{ number_format($tabungan->kredit_raw) }}
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr class="font-weight-bold border-top">
                    <td colspan="2">Total :</td>
                    <td>
                        Rp. {{ number_format($totalDebit) }}
                    </td>
                    <td>
                        Rp. {{ number_format($totalKredit) }}
                    </td>
                </tr>
                <tr class="font-weight-bolder">
                    <td colspan="3" class="text-right">
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
