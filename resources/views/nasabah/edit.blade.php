@extends('layouts.layout')

@section('content')
<h2 style="border-bottom: 4px solid;" class="py-2">User : {{ $user->name }}</h2>

<form action="{{ route('user.update', $user->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('patch')
    <input type="hidden" name="who" id="who" value="nasabah" />
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="form-control-label" for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Your Name" value="{{ $user->name }}" required />
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="form-control-label" for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="example@example.com" value="{{ $user->email }}" required />
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="form-control-label" for="telpon">Phone</label>
                <input type="number" name="telpon" id="telpon" class="form-control" placeholder="082xxxxxxxxxxxx" value="{{ $user->telpon }}" required />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-control-label" for="password">Password <span class="text-danger">(Opsional)</span></label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-control-label" for="password_confirmation">Repeat Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Password" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="form-control-label" for="alamat">Address</label>
        <textarea rows="4" class="form-control" placeholder="Input your address ..." name="alamat" id="alamat">{{ $user->alamat }}</textarea>
    </div>
    <div class="form-group">
        <label class="form-control-label" for="foto">Image</label>
        <div class="mb-2">
            <img src="{{ $user->foto }}" alt="" width="250px">
        </div>
        <input type="file" class="form-control" name="foto" id="foto" />
    </div>

    <button class="btn btn-success" type="submit" name="simpan" id="simpan">Save</button>
    <a href="{{ route('nasabah.index') }}" class="btn btn-primary">Back</a>
</form>

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
@endsection
