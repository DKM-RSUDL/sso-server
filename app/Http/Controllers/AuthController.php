<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Passport\Client;

class AuthController extends Controller
{
    private $clientId_;
    private $secretKey_;

    public function __construct()
    {
        $this->clientId_ = env('SSO_CLIENT_ID');
        $this->secretKey_ = env('SSO_SECRET_KEY');
    }

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
            $intendedUrl = redirect()->getIntendedUrl();
            $prefix = url('/oauth/authorize');

            if (Str::startsWith($intendedUrl, $prefix)) {
                return redirect()->intended();
            } else {
                return to_route('authorize');
            }
        }

        return back()->withErrors(['kd_karyawan' => 'Invalid credentials']);
    }

    public function approve(Request $request)
    {
        $client = Client::where('id', $request->client_id)->first();

        if (empty($client)) {
            return response()->json(['error' => 'Invalid client'], 400);
        }

        // Generate authorization code

        // Parameter yang diperlukan untuk rute /oauth/authorize
        $query = http_build_query([
            'client_id' => $client->id,
            'redirect_uri' => $client->redirect_uri,
            'response_type' => 'code',
            'scope' => $request->scope ?? 'user-info',
            'state' => $request->state ?? null, // Optional state parameter
        ]);

        // Redirect back to client with auth code
        return redirect('/oauth/authorize?' . $query);
    }

    public function logout(Request $request)
    {
        $token = $request->cookie('sso_tok');

        if ($token) {
            // Revoke token di SSO Server
            Http::withToken($token)->post(url("/api/oauth/revoke"), [
                'token' => $token,
                'client_id' => $this->clientId_,
                'client_secret' => $this->secretKey_,
            ]);
        }

        // Hapus cookie
        Cookie::queue(Cookie::forget('sso_tok', '/', env('COOKIE_DOMAIN')));
        Cookie::queue(Cookie::forget('sso_tok_expired', '/', env('COOKIE_DOMAIN')));

        // Logout dari guard web (akhiri sesi autentikasi)
        Auth::logout();

        // Invalidate sesi
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke URL yang diberikan (dari parameter redirect)
        $redirectUrl = $request->query('redirect', route('login'));

        // Validasi redirect URL (opsional)
        if (!filter_var($redirectUrl, FILTER_VALIDATE_URL)) {
            $redirectUrl = route('login');
        }

        return redirect($redirectUrl);
        // return to_route('login');
    }

    /*=================================
            INTERNAL AUTHORIZE
    =================================*/

    public function authorize()
    {
        $client = Client::where('id', $this->clientId_)->first();
        if (empty($client)) {
            return response()->json(['error' => 'Invalid client'], 400);
        }

        $query = http_build_query([
            'client_id' => $this->clientId_,
            'redirect_uri' => route('callback'),
            'response_type' => 'code',
            'scope' => 'user-info',
            'state' => null, // Optional state parameter
        ]);

        return redirect('/oauth/authorize?' . $query);
    }

    public function handleCallback(Request $request)
    {
        $code = $request->query('code');
        $redirectUri = route('callback');

        // Request access token
        $response = Http::post(url('/oauth/token'), [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId_,
            'client_secret' => $this->secretKey_,
            'redirect_uri' => $redirectUri,
            'code' => $code,
        ]);

        $responseData = $response->json();

        // Pastikan response berhasil
        if (isset($responseData['access_token'])) {
            $accessToken = $responseData['access_token'];
            $expiresIn = $responseData['expires_in'] ?? 3600; // Default 1 jam jika tidak ada expires_in

            // Hitung waktu kedaluwarsa (dalam detik)
            $expiresAt = now()->addSeconds($expiresIn)->timestamp;

            // Simpan Access Token ke cookie
            Cookie::queue(
                'sso_tok',
                $accessToken,
                $expiresIn / 60, // Waktu kedaluwarsa dalam menit
                '/', // Path eksplisit ke root
                env('COOKIE_DOMAIN'), // Pastikan domain sesuai
                false, // Secure (ubah ke true jika HTTPS)
                false, // HttpOnly
                false, // Raw
                'Lax' // SameSite
            );

            // Simpan waktu kedaluwarsa ke cookie terpisah
            Cookie::queue(
                'sso_tok_expired',
                $expiresAt,
                $expiresIn / 60,
                '/',
                env('COOKIE_DOMAIN'),
                false,
                false,
                false,
                'Lax'
            );

            return to_route('dashboard');
        }

        return to_route('login')->withErrors(['message' => 'Failed to obtain access token']);
    }
}
