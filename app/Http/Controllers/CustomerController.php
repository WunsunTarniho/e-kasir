<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create.customer', [
            'title' => 'Pelanggan',
            'customers' => Customer::orderBy('nama_pelanggan')->search(request('search'))->paginate(15),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nama_pelanggan' => 'required',
            'alamat' => '',
        ];

        $request->input('no_telp') ? $rules['no_telp'] = 'numeric' : false;

        $validated = $request->validate($rules);

        Customer::create($validated);

        return back()->with('success', 'Pelanggan Baru berhasil ditambahkan !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        return view('update.customer', [
            'title' => 'Pelanggan',
            'customers' => Customer::orderBy('nama_pelanggan')->search(request('search'))->paginate(15),
            'customer' => Customer::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        $rules = [
            'nama_pelanggan' => 'required',
            'alamat' => '',
        ];

        $request->input('no_telp') ? $rules['no_telp'] = 'numeric' : false;

        $validated = $request->validate($rules);

        Customer::find($id)->update($validated);

        return redirect('/customer/create')->with('success', 'Perubahan berhasil dilakukan !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        Customer::destroy($id);

        return back()->with('success', 'Data berhasil dihapus !');
    }
}
