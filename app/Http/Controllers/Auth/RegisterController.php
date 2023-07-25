<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
{
    return Validator::make($data, [
        'name' => ['required', 'string', 'max:35'],
        'email' => ['required', 'string', 'email', 'max:75', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'umur' => ['required', 'numeric'],
        'alamat' => ['required', 'string', 'min:5'],
        'jenis_kelamin' => ['required', 'string']
    ], [
        'name.required' => 'Nama wajib diisi.',
        'name.max' => 'Nama maksimal 35 huruf.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.max' => 'Email maksimal 75 huruf.',
        'email.unique' => 'Email sudah digunakan, harap gunakan email lain.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 8 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        'umur.required' => 'Umur wajib diisi.',
        'umur.numeric' => 'Umur harus berupa angka.',
        'alamat.required' => 'Alamat wajib diisi.',
        'alamat.min' => 'Harap isi dengan alamat lengkap.',
        'jenis_kelamin.required' => 'Jenis Kelamin wajib diisi.'
    ]);
}



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'umur' => $data['umur'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'alamat' => $data['alamat'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
