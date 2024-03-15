@extends('main.body')

@section('container')
    <div class="d-flex flex-nowrap align-items-center justify-content-between pt-3 pb-2 mb-4  border-bottom">
        <h1 class="h2">{{ $title }}</h1>
        <div>
            <a class="btn btn-primary px-3 me-1" href="/customer/create">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                </svg>
                Pelanggan Baru
            </a>
        </div>
    </div>
    <div class="col-lg-10 p-4 border border-secondary rounded">
        <form class="row g-3" action="/customer/{{ $customer->id }}" method="POST">
            @method('PUT')
            @csrf
            <div class="col-md-4">
                <label for="nama_pelanggan" class="form-label">Pelanggan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" placeholder="Nama Pelanggan" value="{{ old('nama_pelanggan', $customer->nama_pelanggan) }}" autofocus />
                @error('nama_pelanggan')
                    <div class="err-message text-danger ms-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="alamat" class="form-label">Alamat <span class="text-secondary">(Optional)</span></label>
                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" value="{{ old('alamat', $customer->alamat) }}">
            </div>
            <div class="col-md-4">
                <label for="no_telp" class="form-label">No. Telp <span class="text-secondary">(Optional)</span></label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="No. Telp" value="{{ old('no_telp', $customer->no_telp) }}">
                @error('no_telp')
                    <div class="err-message text-danger ms-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary">Edit Customer</button>
            </div>
        </form>
    </div>

    @include('customer')
@endsection