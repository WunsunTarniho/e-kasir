@extends('main.body')

@section('container')
    <div class="d-flex flex-nowrap align-items-center justify-content-between pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2">{{ $title }}</h1>
    </div>
    <div class="col-12 mb-md-4 mb-3 py-2">
        <form class="row" id='transaction' method="POST" action="/transaction">
            @csrf
            <div id="produkDetails">
                <div class="col-md-3 mb-4 pe-5">
                    <label class="form-label px-1">Pelanggan</label>
                    <select class="form-select col-4 @error('customer_id') is-invalid @enderror" name="customer_id"
                        id="customer-id">
                        <option value="" selected hidden></option>
                        <option value="/customer/create" id="addCustomer">Tambah Pelanggan</option>
                        @foreach ($customers as $customer)
                            @if (old('customer_id') == $customer->id)
                                <option value="{{ $customer->id }}" selected>{{ $customer->nama_pelanggan }}</option>
                            @else
                                <option value="{{ $customer->id }}">{{ $customer->nama_pelanggan }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('customer_id')
                        <div class="text-danger mx-1 small error-message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                @if ($errors->any())
                    @foreach (old('kode_produk') as $index => $kode_produk)
                        <div class="row produkDetail position-relative pb-3 pe-5 g-md-4 g-1">
                            <div class="col-lg-3 col-sm-6">
                                <label class="form-label px-1">Nama Produk</label>
                                <select name="kode_produk[]" class="form-select nama-produk">
                                    @foreach ($products as $product)
                                        <option value="" selected hidden></option>
                                        @if ($kode_produk == old('kode_product.' . $index))
                                            <option value="{{ $product->id }}" selected>
                                                {{ $product->nama_produk . ' - ' . $product->id }}</option>
                                        @endif
                                        <option value="{{ $product->id }}">
                                            {{ $product->nama_produk . ' - ' . $product->id }}</option>
                                    @endforeach
                                </select>
                                @error('kode_product.' . $index)
                                    <div class="text-danger mx-1 small error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <label class="form-label px-1">Harga</label>
                                <input type="text" class="form-control harga" name="harga[]" placeholder="Harga"
                                    value="{{ old('harga')[$index] }}" readonly>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <label class="form-label px-1">Jumlah Pembelian</label>
                                <input type="number" class="form-control jumlah-produk" name="jumlah_produk[]"
                                    value="{{ old('jumlah_produk')[$index] }}" min="0" oninput="count(this)" />
                                @error('jumlah_produk.' . $index)
                                    <div class="text-danger mx-1 small error-message">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <label class="form-label px-1">Subtotal</label>
                                <input type="text" class="form-control sub-total" name="sub_total[]"
                                    value="{{ old('sub_total')[$index] }}" readonly>
                            </div>
                            <button class="delete-field btn btn-transparent position-absolute w-auto end-0"
                                onclick="removeField(this)" style="top: calc(50% - 1.4rem);">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="bi bi-x-circle text-danger" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                    <path
                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                @else
                    @include('component.transaction')
                @endif
            </div>
            <div class="col-lg-3 col-6 mt-4">
                <button class="btn btn-primary" type="button" onclick="addField()">Tambah Pembelian</button>
            </div>
            <div class="col-lg-3 col-6 mt-4">
                <button id="submitForm" type="submit" class="btn btn-primary">Simpan Transaksi</button>
            </div>
        </form>
    </div>

    @include('product')

    <script>
        // Menghilangkan tombol delete 
        if ($('.produkDetail').length == 1) {
            $('.delete-field').hide();
        } else {
            $('.delete-field').show();
        }

        // array[] untuk menyimpan daftar produk yang sudah dipilih
        let selectedProuduct = [];

        function count(element) {
            produkDetail = $(element).parent('div').parent('.produkDetail');
            harga = produkDetail.find('.harga');
            subtotal = produkDetail.find('.sub-total');
            subtotal.val($(element).val() * harga.val());
        }

        // Untuk mengarah ke halaman tambah pelanggan jika option select dengan id 'addCustomer' ditekan
        $('#customer-id').change(function() {
            if (this.value === '/customer/create') {
                // Jika route nya sesuai dengan route yang ada dilaravel dia akan beralih ke halaman itu
                window.location.href = 'http://localhost:8000' + this.value;
            }
        });

        // Untuk memberikan event pada setiap input
        $('.produkDetail input').each(function() {
            $(this).keydown(unreload);
        });

        // Function yang berfungsi untuk memastikan halaman tidak reload saat tekan enter di field input
        function unreload(e) {
            // Jika key yang ditekan adalah enter dan event yang dipicu berasal dari class 'jumlah-produk'
            // Maka ambil .produkDetail yang terakhir dan disimpan ke variabel
            // lalu dicek apakah field dengan nama class 'kode-produk' punya produkDetail itu kosong ?
            // yang else if juga sama dicek, cuman bedanya di field dengan class '.jumlah-produk'
            // Kalau iya maka akan mereturn popup alert 
            // Dengan return maka code yang dibawahnya gak akan dieksekusi
            if (e.key == 'Enter') {
                e.preventDefault();
                $('#search').focus();
            }
        }

        function addField() {
            const newField = $('.produkDetail:last').clone();

            newField.find('input').val('');
            newField.find('.error-message').hide();
            newField.find('input').keydown(unreload);

            $('#produkDetails').append(newField);
            $('#search').focus();
            $('.delete-field').show();
        }

        // Function yang akan menangani penghapusan field detail penjualan
        function removeField(element) {
            produkDetail = $(element).parent('.produkDetail');

            // Menghapus produk dari daftar sudah terpilih
            selectedProuduct = selectedProuduct.filter(selected => selected !== produkDetail
                .find('.kode-produk').val());

            // Menghapus form detail penjualan 
            produkDetail.remove();

            // Mengecek apakah detail penjualan cuman 1 ? 
            // Kalau benar tombol hapus akan disembunyikan
            if ($('.produkDetail').length === 1) {
                $('.delete-field').hide();
            }
        }

        // Searching Produk
        // Untuk mengirim request ke laravel - Ke route /product/{id} untuk mengarah ke
        // ProductController dengan method show()
        $('#searching').change(function(e) {
            // Untuk mencegah event reload terjadi
            e.preventDefault();

            // Mengecek apakah yang disearch itu sudah ada di dalam array[] selectedProduct ?
            // Jika iya maka mereturn sebuah pop up, keyword return harus digunakan untuk mencegah perintah di bawah dieksekusi
            if (selectedProuduct.includes(search.value)) {
                $('#search').find('option:first').prop('selected', true);
                return alert('Produk ini sudah dipilih sebelumnya');
            }


            // Jika yang dicari itu tidak ada dalam daftar array[] selectedProduck
            // Maka Javascript akan merequest ke laravel dengan perintah dibawah ini
            // Bisa juga dengan route laravel langsung pakai form dengan atribut action tapi cara ini akan membuat halaman reload ulang

            $.ajax({
                // Sama seperti pengiriman request kayak di form action harus ada token csrf
                // Kalau di form action itu menggunakan @csrf dan kalau dengan jquery ajax bentuk nya seperti ini 
                // Dan harus menambahkan <meta name="csrf-token" content="{{ csrf_token() }}"> ke dalam tag head
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // Ini optional tidak wajib
                dataType: 'JSON',
                // Method request
                type: 'GET',
                // Route yang akan mengarah ke ProductController dengan method show()
                // Karena routenya itu bentuknya resource, bentuk route yang '/nama_route/{variabel}' dengan method GET
                // akan mengarah ke method show() pada controller
                url: 'http://localhost:8000/product/' + search.value,
                // Optional
                data: {},
                // Lihat ke bagian ProdukController dengan method show() 
                // function success ini akan dieksekusi jika laravel berhasil mengquery dan
                // parameter dari function success akan menerima hasil query dalam bentuk objek
                success: function(response) {
                    // Setiap .produkDetail akan dicek apakah .produkDetail yang mempunyai element dengan nama class 'kode-produk'
                    // ada isinya gak ?

                    $('#produkDetails .produkDetail').each(function() {
                        if ($(this).find('.kode-produk').val() === '') {
                            // Kalau tidak ada isinya, maka .produkDetail yang dicek itu setiap fieldnya itu akan diisi dengan response dari laravel
                            // parameter function sekarang adalah objek
                            // Bentuk contoh kayak :
                            /*  
                                response = {
                                               nama_atribut1 : value1,
                                               nama_atribut2 : value2,
                                               nama_atribut3 : value3,
                                           }
                            */
                            // jika semakin banyak kolom tabel yang diquery, maka semakin banyak atribut dari objek itu
                            // nama atribut yang response itu pasti sama dengan nama kolom dari tabel yang bersangkut
                            // dalam hal ini tabel produk
                            // untuk mengakses value dari atribut sebuah objek di Javascript itu dengan cara
                            // nama_objek.nama_atribut atau bisa juga dengan cara nama_objek['nama_atribut']

                            jumlahProduk = $(this).find('.jumlah-produk');

                            $(this).find('.kode-produk').val(response
                                .id); // bisa juga response['id']
                            $(this).find('.nama-produk').val(response[
                                'nama_produk']); // response.nama_produk
                            $(this).find('.harga').val(response.harga); // response['harga']
                            $(this).find('.sub-total').val(jumlahProduk.val() * response.harga);

                            jumlahProduk.focus();
                            // Menambahkan produk yang disearch akan dimasukkan ke daftar terpilih yaitu array[] selectedProduct
                            // untuk menambah data ke sebuah array harus menggunakan method push() atau unshift()
                            if (response.id) {
                                selectedProuduct.push(search.value);
                            }

                            $('#search').find('option:first').prop('selected', true);
                            // return ini untuk memastikan hanya sebuah .produkDetail yang terisi
                            return false;
                        }
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            })
        });
    </script>
@endsection
