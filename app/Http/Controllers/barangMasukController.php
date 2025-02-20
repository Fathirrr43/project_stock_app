<?php

namespace App\Http\Controllers;

use App\Models\barangmasuk;
use App\Models\stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class barangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = barangmasuk::with(
            'getStok',
            'getSuplier',
            'getAdmin',
        );

        if($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_faktur', [
                $request->tanggal_awal,
                $request->tanggal_akhir,
            ]);
        }

        $query->orderBy('created_at', 'desc');
        $getData = $query->paginate(10);

        return view('Barang.BarangMasuk.barangMasuk', compact(
            'getData'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $getnama_barang_id = stok::with('getSuplier')->get();
        return view('Barang.BarangMasuk.addBarangMasuk', compact(
            'getnama_barang_id'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_faktur' => 'required',
            'nama_barang_id'  => 'required',
            'jumlah'  => 'required',
        ]);

        $updateStok = stok::find($request->nama_barang_id);

        if($request->filled('harga')) {
            $harga_beli = $request->harga;
        } else {
            $harga_beli = $updateStok->harga;
        }

            $savebarangmasuk = new barangmasuk();

            $savebarangmasuk->tanggal_faktur = $request->tanggal_faktur;
            $savebarangmasuk->nama_barang_id = $request->nama_barang_id;

            $savebarangmasuk->suplier_id = $updateStok->suplier;

            $savebarangmasuk->harga = $harga_beli;

            $savebarangmasuk->jumlah_barang_masuk = $request->jumlah;
            $savebarangmasuk->admin_id = Auth::user()->id;
            // dd($savebarangmasuk);
            $savebarangmasuk->save();

        $hitung = $updateStok->stok + $request->jumlah;
        $updateStok->stok = $hitung;
        $updateStok->save();


        return redirect('/barang-masuk')->with(
            'message',
            'Data barang ditambahkan'
        );

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        {
            $barangmasuk = barangmasuk::find($id);

                $get_Id_Stok = $barangmasuk->nama_barang_id;
                $get_Jumlah_barang_masuk = $barangmasuk->jumlah_barang_masuk;

                    $getItemBarang = stok::find($get_Id_Stok);
                        $getStok = $getItemBarang->stok;

                        $updateStok = $getStok - $get_Jumlah_barang_masuk;

                        $getItemBarang->stok = $updateStok;
                        $getItemBarang->save();

                $barangmasuk->delete();

                return redirect('/barang-masuk')->with(
                    'message',
                    'Data barang dihapus'
                );

        }
    }
}
