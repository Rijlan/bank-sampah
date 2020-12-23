@extends('layouts.layout')

@section('content')
<h2 style="border-bottom: 4px solid;" class="py-2">Profile</h2>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-md">
            <div class="card-header text-center">
                <img src="{{ $user->foto }}" alt="" width="150px" class="rounded-circle">
                <hr class="my-3">
                <h2 class="mb-0">{{ $user->name }}</h2>
                <h6 class="text-muted text-small">
                    @switch($user->role)
                        @case(1)
                            Pengurus 1
                            @break
                        @case(2)
                            Pengurus 2
                            @break
                        @case(3)
                            Nasabah
                            @break
                        @case(4)
                            Bendahara
                            @break
                        @case(5)
                            Admin
                            @break
                        @default
                            !???
                    @endswitch
                </h6>
                <hr class="my-3">
                <h4 class="font-weight-normal text-left"><i class="ni ni-square-pin mr-1"></i> {{ $user->alamat }}</h4>
                <h4 class="font-weight-normal text-left"><i class="ni ni-mobile-button mr-1"></i> {{ $user->telpon }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                    <h3 class="mb-0">Edit profile </h3>
                  </div>
                  <div class="col-4 text-right">
                    <a href="#!" data-target="#changePass" data-toggle="modal" class="btn btn-sm btn-danger">Change Password</a>
                  </div>

                  <div class="modal fade" id="changePass">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-body">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h2>Change Password</h2>

                                <hr class="my-2">
                                    
                                <form action="{{ route('admin.change') }}" method="post">
                                    @csrf
                                    @method('patch')
                                    <div class="form-group">
                                        <label class="form-control-label" for="old_password">Old Password</label>
                                        <input type="password" name="old_password" id="old_password" class="form-control" placeholder="Old Password" required />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label" for="password">New Password</label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label" for="password_confirmation">Repeat Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Password" required />
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-outline-danger btn-block">Change</button>
                                    </div>
                                </form>
                              </div>
                          </div>
                      </div>
                  </div>

              </div>
            </div>
            <div class="card-body">
              <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <input type="hidden" name="who" id="who" value="admin">
                <h6 class="heading-small text-muted mb-4">User information</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Your Name" value="{{ $user->name }}" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="example@example.com" value="{{ $user->email }}" required />
                        </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="form-control-label" for="foto">Image</label>
                    <input type="file" class="form-control" name="foto" id="foto" />
                </div>
                </div>
                <hr class="my-4" />
                <!-- Address -->
                <h6 class="heading-small text-muted mb-4">Contact information</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-control-label" for="telpon">Phone</label>
                            <input type="number" name="telpon" id="telpon" class="form-control" placeholder="082xxxxxxxxxxxx" value="{{ $user->telpon }}" required />
                        </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-control-label" for="alamat">Address</label>
                            <textarea rows="4" class="form-control" placeholder="Input your address ..." name="alamat" id="alamat">{{ $user->alamat }}</textarea>
                        </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <button type="submit" class="btn btn-success">Save</button>
                  </div>
              </form>
            </div>
          </div>
    </div>
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
