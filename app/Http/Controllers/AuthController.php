<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Client;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'kd_karyawan' => 'required',
            'password' => 'required',
        ]);

        // check user
        $user = User::with(['karyawan'])->where('kd_karyawan', $request->kd_karyawan)->first();
        if (empty($user)) return back()->withErrors(['kd_karyawan' => 'Invalid credentials']);

        if (Hash::check($request->password, $user->password)) {
            if (($user->karyawan->STATUS_PEG ?? 0) != 1) return back()->withErrors(['kd_karyawan' => 'Employee inactive']);
        }

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/authorize');
        }

        return back()->withErrors(['kd_karyawan' => 'Invalid credentials']);
    }

    public function authorize(Request $request)
    {
        $client = Client::where('id', $request->client_id)->first();
        if (empty($client)) {
            return response()->json(['error' => 'Invalid client'], 400);
        }
        return view('auth.authorize', compact('client', 'request'));
    }

    public function approve(Request $request)
    {
        $user = Auth::user();
        $client = Client::where('id', $request->client_id)->first();

        if (empty($client)) {
            return response()->json(['error' => 'Invalid client'], 400);
        }

        // Generate authorization code
        $authCode = $user->createToken('auth_code', ['user-info'])->accessToken;

        // Parameter yang diperlukan untuk rute /oauth/authorize
        // $query = http_build_query([
        //     'client_id' => $client->id,
        //     'redirect_uri' => $client->redirect_uri,
        //     'response_type' => 'code',
        //     'scope' => 'user-info',
        //     'state' => $request->state ?? null, // Optional state parameter
        // ]);

        // Redirect back to client with auth code
        $redirectUri = $client->redirect_uri . '?code=' . $authCode;
        return redirect($redirectUri);
        // return redirect('/oauth/authorize?' . $query);
    }

    public function logout()
    {
        Auth::logout();

        return to_route('login');
    }
}
