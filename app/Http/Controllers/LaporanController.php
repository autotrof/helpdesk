<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\JenisLaporan;
use App\Laporan;

class LaporanController extends Controller
{
    public function getAll(Request $request)
    {
    	
    }

    public function getData(Request $request)
    {
    	$orderBy = '';
        switch($request->input('order.0.column')){
            case "0":
                $orderBy = 'nip_pelapor';
            break;
            case "1":
                $orderBy = 'id';
            break;
            default:
                $orderBy = 'id';
            break;
        }

        $data = Laporan::with('jenisLaporanInfo')->where('id','>',0);
        if($request->input('search.value')!=''){
            $data = $data
            	->where('nip_pelapor','like','%'.$request->input('search.value').'%')
                ->orWhere('deskripsi','like','%'.$request->input('search.value').'%');
        }

        $recordsFiltered = $data->count();

        $data = $data->skip($request->input('start'))->take($request->input('length'))->orderBy($orderBy,$request->input('order.0.dir'))->get();
        return response()->json([
        	'draw'=>$request->input('draw'),
            'recordsTotal'=>count($data)/$request->input('length'),
            'recordsFiltered'=>$recordsFiltered,
            'data'=>$data,
            'request'=>$request->all(),
        ],200);
    }

    public function addLaporan(Request $request){
        $gambar = null;
        if($request->hasFile('gambar')){
            $gambar = strtotime('now').'-'.$request->input('nip_pelapor').'.'.$request->file('gambar')->getClientOriginalExtension();
            \Storage::disk('public')->put('laporan/img/'.$gambar, \File::get($request->file('gambar')));
        }
        Laporan::create([
            'jenis_laporan_id'=>$request->input('jenis_laporan'),
            'deskripsi'=>$request->input('deskripsi'),
            'gambar'=>$gambar,
            'nip_pelapor'=>$request->input('nip_pelapor'),
            'lokasi'=>$request->input('lokasi'),
            'waktu_melapor'=>\Carbon\Carbon::now()
        ]);
        return response()->json(['hasil'=>true,'token'=>csrf_token()]);
    }

    public function setDugaan(Request $request)
    {
    	$laporan = Laporan::find($request->input('id'));
    	if ($laporan!=null) {
    		$laporan->dugaan = $request->input('dugaan');
    		$laporan->save();
    		return response()->json(['result'=>true],200);
    	}
    	return response()->json(['result'=>false],200);
    }
}
