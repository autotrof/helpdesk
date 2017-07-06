<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\JenisLaporan;
use App\Laporan;
use App\Pengumuman;

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
		$data['list_pengumuman'] = Pengumuman::whereDate('start_pengumuman','<=',\Carbon\Carbon::now())->whereDate('stop_pengumuman','>=',\Carbon\Carbon::now())->get();
		// $data['list_pengumuman'] = Pengumuman::all();
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
    	$data['list_mayor_keluhan'] = JenisLaporan::with(['listLaporan','listSolvedLaporan','listUnSolvedLaporan','listOtherLaporan'])->has('listLaporan')->get()->sortByDesc(function($jenisLaporan){
	   		return $jenisLaporan->listLaporan->count();
	   	});
	   	$data['max_keluhan'] = JenisLaporan::with(['listLaporan'])->has('listLaporan')->get()->sortByDesc(function($jenisLaporan){
	   		return $jenisLaporan->listLaporan->count();
	   	})->take(1);
	   	$data['min_keluhan'] = JenisLaporan::with(['listLaporan'])->has('listLaporan')->get()->sortBy(function($jenisLaporan){
	   		return $jenisLaporan->listLaporan->count();
	   	})->take(1);
	   	$data['max_keluhan_selesai'] = JenisLaporan::with(['listSolvedLaporan'])->has('listLaporan')->get()->sortByDesc(function($jenisLaporan){
	   		return $jenisLaporan->listSolvedLaporan->count();
	   	})->take(1);
	   	$data['max_keluhan_tidak_selesai'] = JenisLaporan::with(['listUnSolvedLaporan'])->has('listLaporan')->get()->sortByDesc(function($jenisLaporan){
	   		return $jenisLaporan->listUnSolvedLaporan->count();
	   	})->take(1);
	   	// $data['max_keluhan_belum_selesai'] = JenisLaporan::with(['listOtherLaporan'])->has('listLaporan')->get()->sortByDesc(function($jenisLaporan){
	   	// 	return $jenisLaporan->listOtherLaporan->count();
	   	// })->take(1);
	   	$data['min_keluhan_selesai'] = JenisLaporan::with(['listSolvedLaporan'])->has('listLaporan')->get()->sortBy(function($jenisLaporan){
	   		return $jenisLaporan->listSolvedLaporan->count();
	   	})->take(1);
	   	$data['min_keluhan_tidak_selesai'] = JenisLaporan::with(['listUnSolvedLaporan'])->has('listLaporan')->get()->sortBy(function($jenisLaporan){
	   		return $jenisLaporan->listUnSolvedLaporan->count();
	   	})->take(1);
	   	// $data['min_keluhan_belum_selesai'] = JenisLaporan::with(['listOtherLaporan'])->has('listLaporan')->get()->sortBy(function($jenisLaporan){
	   	// 	return $jenisLaporan->listOtherLaporan->count();
	   	// })->take(1);
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

    public function generateDummyLaporan(Request $request)
    {
    	$jenis = JenisLaporan::all();
    	foreach ($jenis as $j) {
    		$faker = \Faker\Factory::create();
    		for ($i=0; $i < $faker->numberBetween($min = 10, $max = 300); $i++) {
    			$faker = \Faker\Factory::create('da_DK');
    			if ($i%5==0) {
    				Laporan::create([
			            'jenis_laporan_id'=>$j->id,
			            'deskripsi'=>$faker->text,
			            'nip_pelapor'=>$faker->p,
			            'lokasi'=>$faker->citySuffix,
			            'waktu_melapor'=>\Carbon\Carbon::now()->addDays($faker->numberBetween($min = -100, $max = 300))->addMinutes($faker->numberBetween($min = -100, $max = 300))
			        ]);
    			}elseif ($i%5==1) {
    				Laporan::create([
			            'jenis_laporan_id'=>$j->id,
			            'deskripsi'=>$faker->text,
			            'nip_pelapor'=>$faker->p,
			            'lokasi'=>$faker->citySuffix,
			            'waktu_melapor'=>\Carbon\Carbon::now()->addDays($faker->numberBetween($min = -100, $max = 300))->addMinutes($faker->numberBetween($min = -100, $max = 300)),
			            'dugaan'=>$faker->sentence($nbWords = 6, $variableNbWords = true),
			            'waktu_dugaan'=>$faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = date_default_timezone_get()),
			            'status'=>'Proses'
			        ]);
    			}elseif($i%5==2){
    				Laporan::create([
			            'jenis_laporan_id'=>$j->id,
			            'deskripsi'=>$faker->text,
			            'nip_pelapor'=>$faker->p,
			            'lokasi'=>$faker->citySuffix,
			            'waktu_melapor'=>\Carbon\Carbon::now()->addDays($faker->numberBetween($min = -100, $max = 300))->addMinutes($faker->numberBetween($min = -100, $max = 300)),
			            'dugaan'=>$faker->sentence($nbWords = 6, $variableNbWords = true),
			            'waktu_dugaan'=>$faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = date_default_timezone_get()),
			            'aksi'=>$faker->sentence($nbWords = 10, $variableNbWords = true),
			            'waktu_aksi'=>$faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = date_default_timezone_get()),
			            'status'=>'Proses'
			        ]);
    			}elseif($i%5==3){
    				$status = $faker->randomElements($array = array ('Terselesaikan','Tidak Terselesaikan'), $count = 1);
    				Laporan::create([
			            'jenis_laporan_id'=>$j->id,
			            'deskripsi'=>$faker->text,
			            'nip_pelapor'=>$faker->p,
			            'lokasi'=>$faker->citySuffix,
			            'waktu_melapor'=>\Carbon\Carbon::now()->addDays($faker->numberBetween($min = -100, $max = 300))->addMinutes($faker->numberBetween($min = -100, $max = 300)),
			            'dugaan'=>$faker->sentence($nbWords = 6, $variableNbWords = true),
			            'waktu_dugaan'=>$faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = date_default_timezone_get()),
			            'aksi'=>$faker->sentence($nbWords = 10, $variableNbWords = true),
			            'waktu_aksi'=>$faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = date_default_timezone_get()),
			            'waktu_final'=>$faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = date_default_timezone_get()),
			            'status'=>$status[0]
			        ]);
    			}else{
    				Laporan::create([
			            'jenis_laporan_id'=>$j->id,
			            'deskripsi'=>$faker->text,
			            'nip_pelapor'=>$faker->p,
			            'lokasi'=>$faker->citySuffix,
			            'waktu_melapor'=>\Carbon\Carbon::now()->addDays($faker->numberBetween($min = -100, $max = 300))->addMinutes($faker->numberBetween($min = -100, $max = 300)),
			            'dugaan'=>$faker->sentence($nbWords = 6, $variableNbWords = true),
			            'waktu_dugaan'=>$faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = date_default_timezone_get()),
			            'aksi'=>$faker->sentence($nbWords = 10, $variableNbWords = true),
			            'waktu_aksi'=>$faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = date_default_timezone_get()),
			            'waktu_final'=>$faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = date_default_timezone_get()),
			            'status'=>'Terselesaikan'
			        ]);
    			}
	    	}
    	}
    	return "MARI";
    }
}
