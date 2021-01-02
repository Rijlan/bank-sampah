@extends('layouts.layout')

@section('content')
<h2 style="border-bottom: 4px solid;" class="py-2">Nasabah</h2>

{{-- Tabel --}}
<div class="table-responsive">
    @if ($users->isEmpty())
        <h1 class="text-center">Data Kosong</h1>
    @else
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort">Name</th>
                    <th scope="col" class="sort">Email</th>
                    <th scope="col" class="sort">Phone</th>
                    <th scope="col" class="sort text-center">Action</th>
                </tr>
            </thead>
            <tbody class="list">
                @foreach ($users as $user)
                    <tr>
                        <td>
                            {{ $user->name }}
                        </td>
                        <td>
                            {{ $user->email }}
                        </td>
                        <td>
                            {{ $user->telpon }}
                        </td>
                        <td class="text-center" style="font-size: 1rem;">
                            <a href="{{ route('nasabah.info', $user->id) }}" class="mr-2">
                                <i class="ni ni-credit-card"></i>
                            </a>
                            <a href="#" data-target="#modalInfo{{ $user->telpon }}" data-toggle="modal" class="mr-2">
                                <i class="ni ni-zoom-split-in"></i>
                            </a>
                            @if (Auth::user()->role == 5)
                            <a href="{{ route('nasabah.edit', $user->id) }}" class="mr-2">
                                <i class="ni ni-settings-gear-65"></i>
                            </a>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('delete-user-{{ $user->id }}').submit();">
                                <i class="ni ni-button-power"></i>
                            </a>
                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-none" id="delete-user-{{ $user->id }}">
                                @csrf
                                @method('delete')
                            </form>
                            @endif
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
                                        <div class="row justify-content-center">
                                            <div class="container">
                                                <div class="col-md-6">
                                                    <i class="ni ni-square-pin mr-1"></i>
                                                    <span>{{ $user->alamat }}</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <i class="ni ni-mobile-button mr-1"></i>
                                                    <span>{{ $user->telpon }}</span>
                                                </div>
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
            {{ $users->links() }}
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

@if (Auth::user()-> role == 5)
<div class="my-3 mx-3 float-right">
    <a href="#" data-target="#modalTambah" data-toggle="modal">
        <button class="btn btn-success" style="font-size: 1rem;">
            <i class="ni ni-fat-add"></i>
        </button>
    </a>
</div>
@endif

<div class="modal fade" id="modalTambah" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2>Tambah User</h2>
                <hr class="my-4">
                <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Your Name" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="example@example.com" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="telpon">Phone</label>
                                <input type="number" name="telpon" id="telpon" class="form-control" placeholder="082xxxxxxxxxxxx" required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="password_confirmation">Repeat Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Password" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="alamat">Address</label>
                        <textarea rows="4" class="form-control" placeholder="Input your address ..." name="alamat" id="alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="role" id="role" value="3" />
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="foto">Image</label>
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
