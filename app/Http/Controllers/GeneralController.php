<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\JenisLaporan;
use App\Laporan;

class GeneralController extends Controller
{
	public function login(Request $request)
	{
		$username = $request->input('username');
		$password = $request->input('password');
		if (Auth::attempt(['username' => $username, 'password' => $password])) {
            session()->put('username',$username);
            session()->put('role','intern');
            return response()->json(['hasil'=>true]);
        }else{
        	return response()->json(['hasil'=>false]);
        }
	}

	public function logout(Request $request){
	    session()->pull('username');
	    session()->pull('role');
	    return redirect('/');
    }

	public function laporan(Request $request)
	{
		$data['TAG'] = 'laporan';
		$data['list_jenis_laporan'] = JenisLaporan::all();
		return view('pages.laporan',$data);
	}

	public function pengumuman(Request $request)
	{
		$data['TAG'] = 'pengumuman';
		return view('pages.pengumuman',$data);	
	}

    public function internLaporan(Request $request)
    {
	   	$data['TAG'] = 'laporan';
	   	$data['list_mayor_keluhan'] = JenisLaporan::with('listLaporan')->has('listLaporan')->get()->sortByDesc(function($jenisLaporan){
	   		return $jenisLaporan->listLaporan->count();
	   	})->take(6);
	   	// dd($data);
	   	$data['total_keluhan'] = Laporan::count();
	   	return view('pages.laporan',$data);
    }

    public function internSummary(Request $request)
    {
    	$data['TAG'] = 'summary';
		return view('pages.summary',$data);
    }

    public function internPengumuman(Request $request)
    {
    	$data['TAG'] = 'pengumuman';
		return view('pages.pengumuman',$data);
    }

    public function updateSetting(Request $request)
    {
    	$username = trim($request->input('username'));
    	if($username!="" && $username!=null){
    		$user = null;
	    	if (session('username')!=$username) {
	    		$user = User::where('username',$username)->first();
	    		if($user!=null) return response()->json(['result'=>false,'token'=>csrf_token(),'message'=>'username tidak tersedia, silahkan ganti username yang lain'],200);
	    	}
	    	$user = User::where('username',session('username'))->first();
    		$password = trim($request->input('password'));
    		if($password!="" && $password!=null) $password = bcrypt($password);
    		else $password = $user->password;
    		$user->update(['username'=>$username,'password'=>$password]);
    		session()->put('username',$username);
    		return response()->json(['result'=>true,'token'=>csrf_token()]);
    	}
    	return response()->json(['result'=>false,'message'=>'username tidak boleh kosong','token'=>csrf_token()]);
    }
}
