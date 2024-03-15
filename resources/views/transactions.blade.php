@extends('main.body')

@section('container')
    <div class="d-flex align-items-center justify-content-between pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2">{{ $title }}</h1>
        @include('component.search')
    </div>
    <div class="row">
        <form method="GET" class="mx-2">
            <div class="row mt-4">
                <div class="col-md-4 col-sm-5 mb-1">
                    <label class="form-label" for="start_date">Start Date : </label>
                    <input class="form-control" type="date" id="start_date" name="start_date" placeholder="Pilih Tanggal" value="{{ old('start_date', request('start_date')) }}">
                    @error('start_date')
                        <div class="text-danger mx-1 small error-message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4 col-sm-5 mb-1">
                    <label class="form-label" for="end_date">End Date : </label>
                    <input class="form-control" type="date" id="end_date" name="end_date" placeholder="Pilih Tanggal" value="{{ old('end_date', request('end_date')) }}">
                    @error('end_date')
                        <div class="text-danger mx-1 small error-message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <button class="btn btn-success my-4 px-3" type="submit">Filter</button>
        </form>
        <div class="row" id="print-area">
            <div class="table-responsive small col-xl-9">
                @if (request(['start_date', 'end_date']))
                    <h5 class="mt-2 mb-4 text-center">{{ 'Periode ' . request('start_date') . ' sampai ' . request('end_date') }}</h5>
                @endif
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Kode Transaksi</th>
                            <th scope="col">Pelanggan</th>
                            <th scope="col">Nilai Transaksi</th>
                            <th scope="col">Tanggal Transaksi</th>
                            <th scope="col" style="width: 90px" class="text-center tools">Tools</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->customer->nama_pelanggan ?? '-' }}</td>
                                <td>{{ $transaction->created_at }}</td>
                                <td>{{ 'Rp ' . number_format($transaction->total_harga, 2, ',', '.') }}</td>
                                <td class="text-center text-nowrap tools">
                                    <a href="/transaction/{{ $transaction->id }}" class="badge text-white p-1 bg-warning">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-eye"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                        </svg>
                                    </a>
                                    <form action="/transaction/{{ $transaction->id }}" method="POST" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="badge text-white p-1 bg-danger border border-none"
                                            onclick="return confirm('Yakin ingin hapus ?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-trash3"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if ($transactions->lastPage() == $transactions->currentPage())
                            <tr>
                                <td colspan="4" class="text-center fw-bold">Total</td>
                                <td style="border-top: 2px solid !important">{{ 'Rp ' . number_format($total_transactions, 2, ',', '.') }}</td>
                                <td class="tools"></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            {{ $transactions->links() }}
        </div>
    </div>

    <button class="btn btn-primary px-4 my-4" id="print">Print</button>

    <script>
        $('#print').on('click', function() {
            let printArea = $('#print-area').html();

            let originalContent = $('body').html();

            $('body').html(printArea);

            window.print();

            $('body').html(originalContent);
        })
    </script>
@endsection
