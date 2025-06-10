<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function formUser()
    {
        return view('backend.v_user.form', ['judul' => 'Laporan Data User',]);
    }
    public function cetakUser(Request $request)
    { // Menambahkan aturan validasi 
        $request->validate(['tanggal_awal' => 'required|date', 'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',], ['tanggal_awal.required' => 'Tanggal Awal harus diisi.', 'tanggal_akhir.required' => 'Tanggal Akhir harus diisi.', 'tanggal_akhir.after_or_equal' => 'Tanggal Akhir harus lebih besar atau sama dengan Tanggal Awal.',]);
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $query = User::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])->orderBy('user_id', 'desc');
        $user = $query->get();
        return view('backend.v_user.cetak', ['judul' => 'Laporan User', 'tanggalAwal' => $tanggalAwal, 'tanggalAkhir' => $tanggalAkhir, 'cetak' => $user]);
    }
    public function showLogin()
    {
        return view('frontend.authentication.loginregister');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            Log::info('LOGIN BERHASIL', ['user' => $user]);

            // Redirect berdasarkan role
            if ($user->role == 0) {
                return redirect()->route('admin.dashboard');
            }

            // Jika bukan superadmin, arahkan ke halaman biasa
            return redirect()->intended('/');
        }

        Log::warning('LOGIN GAGAL', ['email' => $request->email]);
        return back()->withErrors(['email' => 'Email atau password salah']);
    }


    public function showRegister()
    {
        return view('frontend.authentication.loginregister');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'hp' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Buat user jika validasi berhasil
        User::create([
            'nama' => $request->nama,
            'hp' => $request->hp,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 1,
        ]);

        return redirect()->route('register')->with('registerSuccess', 'Berhasil registrasi, silakan login.');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
