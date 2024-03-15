@extends('main.body')

@section('container')
    <div class="d-flex align-items-center justify-content-between pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2">{{ $title }}</h1>
    </div>
    <div class="col-lg-10 p-4 border border-secondary rounded">
        <form class="row g-3" action="/product" method="POST">
            @csrf
            <div class="col-md-4">
                <label for="nama_pelanggan" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Nama Produk" value="{{ old('nama_produk') }}" autofocus />
                @error('nama_produk')
                    <div class="err-message text-danger ms-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="harga" class="form-label">Harga <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="harga" name="harga" placeholder="Harga" value="{{ old('harga') }}">
                @error('harga')
                    <div class="err-message text-danger ms-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="stok" name="stok" min="0" value="{{ old('stok', 0) }}">
                @error('stok')
                    <div class="err-message text-danger ms-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary">Add Product</button>
            </div>
        </form>
    </div>
    @include('component.search')

    @include('product')
@endsection
