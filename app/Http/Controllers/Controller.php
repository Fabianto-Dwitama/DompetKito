<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * Memilih tampilan folder 'mobile.' atau 'desktop.' secara otomatis
     */
    protected function renderView(string $viewName, array $data = [])
    {
        // 1. Jika di URL ada ?mode=mobile atau ?mode=desktop, simpan pilihannya ke session
        if (request()->has('mode')) {
            session(['ui_mode' => request('mode') === 'mobile' ? 'mobile' : 'desktop']);
        }

        // 2. Cek apakah user pernah memilih mode manual lewat URL
        if (session()->has('ui_mode')) {
            $prefix = session('ui_mode');
        } else {
            // 3. Jika belum, deteksi otomatis dari perangkat yang membuka web
            $userAgent = request()->header('User-Agent', '');
            $isMobile = preg_match('/(android|iphone|ipad|ipod|blackberry|windows phone|mobile)/i', $userAgent);
            $prefix = $isMobile ? 'mobile' : 'desktop';
        }

        return view("{$prefix}.{$viewName}", $data);
    }
}