@extends('layouts.layout')

@section('content')
<h2 style="border-bottom: 4px solid;" class="py-2">User</h2>

{{-- Tabel --}}
<div class="table-responsive">
    @if ($users->isEmpty())
        <h1 class="text-center">Data Kosong</h1>
    @else
        <table class="table align-items-center table-flush" id="UserTable">
            <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort">Name</th>
                    <th scope="col" class="sort">Email</th>
                    <th scope="col" class="sort">Phone</th>
                    <th scope="col" class="sort">
                        <select class="form-control search" id="selectSearch">
                            <option value="">Role</option>
                            <option value="Pengurus1">Pengurus 1</option>
                            <option value="Pengurus2">Pengurus 2</option>
                            <option value="Bendahara">Bendahara</option>
                        </select>
                    </th>
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
                            <a href="{{ route('user.edit', $user->id) }}" class="mr-2">
                                <i class="ni ni-settings-gear-65"></i>
                            </a>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('delete-user-{{ $user->id }}').submit();">
                                <i class="ni ni-button-power"></i>
                            </a>
                            <form action="{{ route('user.destroy', $user->id) }}" method="POSt" class="d-none" id="delete-user-{{ $user->id }}">
                                @csrf
                                @method('delete')
                            </form>
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

<div class="my-3 mx-3 float-right">
    <a href="#" data-target="#modalTambah" data-toggle="modal">
        <button class="btn btn-success" style="font-size: 1rem;">
            <i class="ni ni-fat-add"></i>
        </button>
    </a>
</div>

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
                        <label class="form-control-label" for="role">Role</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Role --</option>
                            <option value="1">Pengurus 1</option>
                            <option value="2">Pengurus 2</option>
                            <option value="3">Nasabah</option>
                            <option value="4">Bendahara</option>
                            <option value="5">Admin</option>
                        </select>
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

@section('script')
    <script>
        $(document).ready(function() {
            $('#UserTable').DataTable({
                'paging' : false,
                'info' : false,
                "columnDefs": [
                    { "orderable": false, "targets": [3, 4] }
                ]
            });

            $('#UserTable_filter').hide();
            var table = $('#UserTable').DataTable();
            $('.search').on('keyup change', function() {
                table.search(this.value).draw();
            });

            $('.search').on('keyup', function() {
                $('#selectSearch').val('');
            });
        });
    </script>
@endsection