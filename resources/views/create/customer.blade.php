@extends('main.body')

@section('container')
    <div class="d-flex flex-nowrap align-items-center justify-content-between pt-3 pb-2 mb-4  border-bottom">
        <h1 class="h2">{{ $title }}</h1>
    </div>
    <div class="col-lg-10 p-4 border border-secondary rounded">
        <form class="row g-3" action="/customer" method="POST">
            @csrf
            <div class="col-md-4">
                <label for="nama_pelanggan" class="form-label">Pelanggan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan"
                    placeholder="Nama Pelanggan" value="{{ old('nama_pelanggan') }}" autofocus />
                @error('nama_pelanggan')
                    <div class="err-message text-danger ms-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="alamat" class="form-label">Alamat <span class="text-secondary">(Optional)</span></label>
                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat"
                    value="{{ old('alamat') }}">
            </div>
            <div class="col-md-4">
                <label for="no_telp" class="form-label">No. Telp <span class="text-secondary">(Optional)</span></label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="No. Telp"
                    value="{{ old('no_telp') }}">
                @error('no_telp')
                    <div class="err-message text-danger ms-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary">Add Customer</button>
            </div>
        </form>
    </div>
    @include('component.search')
    @include('customer')
@endsection
