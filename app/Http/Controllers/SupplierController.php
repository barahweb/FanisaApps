<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.master.supplier.index',[
            'suppliers' => Supplier::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.dashboard.master.supplier.create',[
           'title' => 'Tambah Supplier',
       ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama_supplier' => 'required|unique:suppliers',
            'no_hp' => 'required|unique:suppliers',
            'alamat' => 'required',
        ]);

        Supplier::create($validateData);
        $request->session()->flash('status_text', '');
        return redirect('/master/suppliers')->with('status_icon', 'success')
            ->with('status', 'Berhasil Menambah Supplier!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        return view('admin.dashboard.master.supplier.edit',[
            'supplier' => $supplier,
            'title' => 'Edit Supplier',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $rules = ([
            'nama_supplier' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);
        if ($request->nama_supplier != $supplier->nama_supplier) {
            $rules['nama_supplier'] = 'required|unique:suppliers';
        }
        $validateData = $request->validate($rules);
        Supplier::where('id_supplier', $supplier->id_supplier)
            ->update($validateData);
        $request->session()->flash('status_text', 'Successfull!');
        return redirect('/master/suppliers')->with('status_icon', 'success')
            ->with('status', 'Berhasil Update Data Supplier!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        try {
            Supplier::destroy($supplier->id_supplier);
            session()->flash('status_text', '');
            return redirect('/master/suppliers')->with('status_icon', 'success')
                ->with('status', 'Supplier Berhasil Dihapus!');
        } catch (Exception $e) {
            return redirect('/master/suppliers')->with('status_icon', 'error')
                ->with('status', 'Supplier Sedang Digunakan!');
        }  
    }
}
