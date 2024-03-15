<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaction;
use App\Models\Product;
use App\Models\Transaction;
use DivisionByZeroError;
use Illuminate\Http\Request;
use PHPUnit\Logging\JUnit\JunitXmlLogger;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $terjual = DetailTransaction::sum('jumlah_produk');
        $sisa_stok = Product::sum('stok');
        $jumlah_stok = $terjual + $sisa_stok;

        try {
            $persentase = $terjual / $jumlah_stok;
        } catch (DivisionByZeroError $e) {
            $persentase = 0;
        }

        return view('dashboard', [
            'title' => 'Dashboard',
            'jumlah_produk' => Product::count(),
            'total_pendapatan' => Transaction::sum('total_harga'),
            'terjual' => $terjual,
            'jumlah_stok' => $jumlah_stok,
            'persentase' => $persentase,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create.product', [
            'title' => 'Produk',
            'products' => Product::query()
                ->orderByRaw('IF(stok > 0, 1, 2), nama_produk')
                ->paginate(0),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|unique:products|min:3',
            'harga' => 'required|numeric|min:500',
            'stok' => 'required|numeric|min:1',
        ]);

        Product::create($validated);

        return back()->with('success', 'Produk Berhasil Ditambahkan !');
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        // search.value yang dikirim di Javascript tadi akan masuk ke dalam parameter $id
        // Query semua data produk (Sama kayak SELECT * FROM 'products' WHERE id = $id); lalu disimpan ke variabel $product
        $product = Product::find($id);

        // Setelah query, $product diresponse kembali ke javascript untuk ditangkap parameter function success
        // Liat kembali ke Javascript
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('update.product', [
            'title' => 'Produk',
            'products' => Product::query()
                ->orderByRaw('IF(stok > 0, 1, 2), nama_produk')
                ->paginate(0),
            'product' => Product::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {

        $product = Product::find($id);

        $validated = $request->validate([
            'nama_produk' => 'required|min:3',
            'harga' => 'required|numeric|min:500',
            'stok' => 'required|numeric|min:' . $product->stok,
        ]);

        $product->update($validated);

        return redirect('/product/create')->with('success', 'Perubahan Berhasil diedit !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        Product::destroy($id);

        return back()->with('success', 'Data berhasil dihapus !');
    }
}
