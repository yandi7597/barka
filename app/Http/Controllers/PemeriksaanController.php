<?php

namespace App\Http\Controllers;

use App\Models\pemeriksaan;
use App\Models\obat;
use App\Models\dokter;
use App\Models\pasien;
use Illuminate\Http\Request;

class PemeriksaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword=$request->get('keyword');
        $pemeriksaan=pemeriksaan::all();
        if($keyword){
            $pemeriksaan=pemeriksaan::where("nama_pasien","LIKE","%$keyword%")->get();
        }
        return view('pemeriksaan/index', compact('pemeriksaan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $obat=obat::all();
        $dokter=dokter::all();
        $pasien=pasien::all();
        return view('pemeriksaan/create', compact('obat','dokter','pasien'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien'=>'required',
            'nama_dokter'=>'required',
            'tgl'=>'required',
            'hasil_pengujian'=>'required',
            'nama_obat'=>'required',
            'biaya'=>'required',
            'pajak'=>'required',
            'total_biaya'=>'required'
        ]);
        pemeriksaan::create($request->all());

        return redirect('/pemeriksaan')->with('status', 'Data Pemeriksaan Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pemeriksaan  $pemeriksaan
     * @return \Illuminate\Http\Response
     */
    public function show(pemeriksaan $pemeriksaan)
    {
       return view('pemeriksaan.show', compact('pemeriksaan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pemeriksaan  $pemeriksaan
     * @return \Illuminate\Http\Response
     */
    public function edit(pemeriksaan $pemeriksaan)
    {
        $obat=obat::all();
        $dokter=dokter::all();
        $pasien=pasien::all();
        return view('pemeriksaan.edit', compact('pemeriksaan','obat','dokter','pasien'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pemeriksaan  $pemeriksaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pemeriksaan $pemeriksaan)
    {
        pemeriksaan::where('id',$pemeriksaan->id)
        ->update(['nama_pasien'=>$request->nama_pasien,
        'nama_dokter'=>$request->nama_dokter,
        'tgl'=>$request->tgl,
        'hasil_pengujian'=>$request->hasil_pengujian,
        'nama_obat'=>$request->obat,
        'biaya'=>$request->biaya,
        'pajak'=>$request->pajak,
        'total_biaya'=>$request->total_biaya
        ]);
        return redirect('/pemeriksaan')->with('status', 'Data pemeriksaan Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pemeriksaan  $pemeriksaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(pemeriksaan $pemeriksaan)
    {
        pemeriksaan::destroy($pemeriksaan->id);
        return redirect('pemeriksaan')->with('status','Data Pemeriksaan Berhasil Dihapus');
    }
}
