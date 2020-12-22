@extends('layouts.layout')

@section('content')
<h2 style="border-bottom: 4px solid;" class="py-2">User</h2>

{{-- Tabel --}}
<div class="table-responsive">
    <table class="table align-items-center table-flush">
        <thead class="thead-light">
            <tr>
                <th scope="col" class="sort">Name</th>
                <th scope="col" class="sort">Email</th>
                <th scope="col" class="sort">Role</th>
                <th scope="col" class="sort text-center">Action</th>
            </tr>
        </thead>
        <tbody class="list">
            @foreach ($users as $user)
                <tr>
                    <td>
                        {{ $user->name }}
                    </td>
                    <td class="budget">
                        {{ $user->email }}
                    </td>
                    <td>
                        <span class="badge badge-dot mr-4">
                            @switch($user->role)
                                @case(1)
                                    <i class="bg-primary"></i>
                                    <span class="status">Pengurus 1</span>
                                    @break
                                @case(2)
                                    <i class="bg-primary"></i>
                                    <span class="status">Pengurus 2</span>
                                    @break
                                @case(4)
                                    <i class="bg-success"></i>
                                    <span class="status">Bendahara</span>
                                    @break
                                @case(5)
                                    <i class="bg-warning"></i>
                                    <span class="status">Admin</span>
                                    @break
                                @default
                                    <i class="bg-warning"></i>
                                    <i class="bg-warning"></i>
                                    <span class="status">???</span>
                            @endswitch
                        </span>
                    </td>
                    <td class="text-center" style="font-size: 1rem;">
                        <a href="#" data-target="#modalInfo{{ $user->telpon }}" data-toggle="modal" class="mr-2">
                            <i class="ni ni-zoom-split-in"></i>
                        </a>
                        <a href="#" class="mr-2">
                            <i class="ni ni-settings-gear-65"></i>
                        </a>
                        <a href="#">
                            <i class="ni ni-button-power"></i>
                        </a>
                    </td>
                </tr>

                <div class="modal fade" id="modalInfo{{ $user->telpon }}" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="info">
                                    <div class="text-center">
                                        <img src="{{ $user->foto }}" alt="Profile" class="img-fluid rounded-circle" width="250px">
                                    </div>
                                    <hr>
                                    <div class="title text-center">
                                        <h1>{{ ucwords($user->name) }}</h1>
                                        <p class="text-muted">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
