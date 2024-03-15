<div class="row produkDetail position-relative pb-3 pe-5 g-md-4 g-1">
    <div class="col-lg-3 col-sm-6">
        <label class="form-label px-1">Nama Produk</label>
        <select name="kode_produk[]" class="form-select kode-produk">
            <option value="" hidden selected></option>
            <option value="/product/create">Tambah Produk</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->nama_produk . ' - ' . $product->id }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-3 col-sm-6">
        <label class="form-label px-1">Harga</label>
        <input type="text" class="form-control harga" name="harga[]" placeholder="Harga" value="" readonly>
    </div>
    <div class="col-lg-3 col-sm-6">
        <label class="form-label px-1">Jumlah Pembelian</label>
        <input type="number" class="form-control jumlah-produk" name="jumlah_produk[]" value="" min="0"
            oninput="count(this)" />
    </div>
    <div class="col-lg-3 col-sm-6">
        <label class="form-label px-1">Subtotal</label>
        <input type="text" class="form-control sub-total" name="sub_total[]" value="" readonly>
    </div>
    <button class="delete-field btn btn-transparent position-absolute w-auto end-0" style="top: calc(50% - 1.4rem);"
        onclick="removeField(this)">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-x-circle text-danger"
            viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
        </svg>
    </button>
</div>
