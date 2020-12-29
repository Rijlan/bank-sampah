@extends('layouts.layout')

@section('content')
<h2 style="border-bottom: 4px solid;" class="py-2">Keuangan</h2>

{{-- Tabel --}}
<div class="table-responsive">
    @if ($keuangans->isEmpty())
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
                @foreach ($keuangans as $key => $keuangan)
                    <tr>
                        <td>
                            {{ $key+1 }}
                        </td>
                        <td>
                            {{ $keuangan->created_at }}
                        </td>
                        <td>
                            @if ($keuangan->debit == 0)
                                -
                            @else
                                Rp. {{ number_format($keuangan->debit) }}
                            @endif
                        </td>
                        <td>
                            @if ($keuangan->kredit == 0)
                                -
                            @else
                                Rp. {{ number_format($keuangan->kredit) }}
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
