<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class CheckSsoTokenExpiration
{
    private $clientId_;
    private $secretKey_;

    public function __construct()
    {
        $this->clientId_ = env('SSO_CLIENT_ID');
        $this->secretKey_ = env('SSO_SECRET_KEY');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $accessToken = $request->cookie('sso_tok');
        $expiresAt = $request->cookie('sso_tok_expired');

        if (!$accessToken || !$expiresAt) {

            // Hapus cookie jika token tidak ada
            Cookie::queue(Cookie::forget('sso_tok', '/', env('COOKIE_DOMAIN')));
            Cookie::queue(Cookie::forget('sso_tok_expired', '/', env('COOKIE_DOMAIN')));

            // hapus session auth
            if (Auth::check()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            return to_route('login')->withErrors(['message' => 'Access token not found']);
        }

        // Periksa apakah token sudah expired
        if (now()->timestamp > (int) $expiresAt) {

            // Hapus cookie jika token expired
            Cookie::queue(Cookie::forget('sso_tok', '/', env('COOKIE_DOMAIN')));
            Cookie::queue(Cookie::forget('sso_tok_expired', '/', env('COOKIE_DOMAIN')));

            // hapus session auth
            if (Auth::check()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            return to_route('login')->withErrors(['message' => 'Access token has expired']);
        } else {
            // get sso token user
            $response = Http::withToken($accessToken)->get(url("/api/user"));
            $ssoUser = $response->json();

            if (!empty($ssoUser)) {
                // Set data pengguna ke request
                $request->attributes->set('user', $ssoUser);

                // Autentikasi pengguna lokal (opsional, untuk session Laravel)
                Auth::loginUsingId($ssoUser['id']);

                if (Auth::check()) return $next($request);
            } else {
                // hapus session auth
                if (Auth::check()) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                }

                return to_route('login')->withErrors(['message' => 'SSO User not found']);
            }
        }

        return $next($request);
    }
}
