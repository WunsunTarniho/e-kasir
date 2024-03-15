@extends('main.body')

@section('container')
    <div class="d-flex align-items-center justify-content-between pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2">{{ $title }}</h1>
        <div>
            <a class="btn btn-primary px-3 me-1" href="/product/create">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                </svg>
                Produk Baru
            </a>
        </div>
    </div>
    <div class="col-lg-10 p-4 border border-secondary rounded">
        <form class="row g-3" action="/product/{{ $product->id }}" method="POST">
            @method('PUT')
            @csrf
            <div class="col-md-4">
                <label for="nama_pelanggan" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Nama Produk" value="{{ old('nama_produk', $product->nama_produk) }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="harga" class="form-label">Harga</label>
                <input type="text" class="form-control" id="harga" name="harga" placeholder="Harga" value="{{ old('harga', $product->harga) }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="stok" name="stok" min="0" placeholder="Jumlah Stok" value="{{ old('stok', $product->stok) }}" autofocus />
                @error('stok')
                    <div class="err-message text-danger ms-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary">Edit Product</button>
            </div>
        </form>
    </div>
    @include('component.search')

    @include('product')
@endsection
