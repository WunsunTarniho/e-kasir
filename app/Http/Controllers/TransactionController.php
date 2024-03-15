<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DetailTransaction;
use App\Models\Product;
use App\Models\Transaction;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Psy\Readline\Transient;

use function Laravel\Prompts\error;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request(['start_date', 'end_date'])){
            $validated = Validator::make(request(['start_date', 'end_date']), [
                'start_date' => 'required',
                'end_date' => 'required',
            ]);

            if($validated->fails()){
                return back()
                    ->withInput()
                    ->withErrors($validated);
            }
        }

        return view('transactions', [
            'title' => 'Semua Transaksi',
            'transactions' => Transaction::with('customer')->latest()->search(request(['search', 'start_date', 'end_date']))->paginate(40),
            'total_transactions' => Transaction::sum('total_harga'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('create.transaction', [
            'title' => 'Transaksi',
            'products' => Product::query()
                ->orderByRaw('IF(stok > 0, 1, 2), nama_produk')
                ->paginate(15),
            'customers' => Customer::latest()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'kode_produk.*' => 'required',
            'jumlah_produk.*' => 'required|numeric|min:1',
            'sub_total.*' => 'required',
        ], [
            'customer_id' => 'Pelanggan harus diisi',
            'kode_produk.*.required' => 'Cari produk dulu',
            'jumlah_produk.*.required' => 'Jumlah produk harus diisi',
            'jumlah_produk.*.min' => 'Minimal satu produk',
        ]);

        $products_id = $request->input('kode_produk');
        $jumlahProduk = $request->input('jumlah_produk');
        $subTotal = $request->input('sub_total');

        foreach ($products_id as $key => $product_id) {
            $product = Product::find($product_id);
            $requestStok = $jumlahProduk[$key];

            if ($product && $requestStok > $product->stok) {
                return back()->with('fail', 'Stok Tidak Cukup untuk Produk ' . $product->nama_produk . ' - ' . $product->id)
                    ->withInput()
                    ->withErrors($request->all());
            }
        }

        $transaksi = Transaction::create([
            'customer_id' => $request->input('customer_id'),
            'total_harga' => array_sum($subTotal),
        ]);

        $detailTransaction = new DetailTransactionController;
        $detailTransaction->store($products_id, $transaksi, $jumlahProduk, $subTotal);

        static::update($products_id, $jumlahProduk);

        return redirect('/transaction')->with('success', 'Transaksi Baru Berhasil ditambakan !');
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $transaction = Transaction::find($id);

        return view('transaction', [
            'title' => 'Nota ' . $transaction->id . ' - ' . ($transaction->customer->nama_pelanggan ?? '-'),
            'transaction' => $transaction,
            'details' => $transaction->details()->with('product')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($kode_produk, $jumlahProduk)
    {
        $products = Product::whereIn('id', $kode_produk)->get();

        foreach ($products as $key => $product) {
            $kode_produk = $product->id;
            $newStok = $product->stok - $jumlahProduk[$key];

            $product->update(['stok' => $newStok]);
        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $transaction = Transaction::find($id);

        $transaction->delete();

        return back()->with('success', 'Transaksi berhasil dihapus !');
    }
}
