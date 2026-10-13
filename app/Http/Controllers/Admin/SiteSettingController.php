<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function edit()
    {
        $settings = SiteSetting::allKeyed();

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'school_name' => 'required|string|max:255',
            'school_address' => 'required|string|max:500',
            'school_phone' => 'required|string|max:50',
            'school_email' => 'required|email|max:100',
            'school_hours' => 'required|string|max:100',
            'school_visi' => 'required|string',
            'school_misi' => 'required|string',
            'school_kepala' => 'nullable|string|max:255',
            'school_struktur' => 'nullable|string',
            'dashboard_bg' => 'nullable|image|max:4096',
            'dashboard_bg_url' => 'nullable|url:http,https|max:2048',
        ]);

        if ($request->hasFile('dashboard_bg')) {
            $old = SiteSetting::get('dashboard_bg');
            if ($old) {
                Storage::disk('public')->delete($old);
            }
            $data['dashboard_bg'] = $request->file('dashboard_bg')->store('site', 'public');
            $data['dashboard_bg_url'] = '';
        } elseif (filled($data['dashboard_bg_url'] ?? null)) {
            $old = SiteSetting::get('dashboard_bg');
            if ($old) {
                Storage::disk('public')->delete($old);
            }
            $data['dashboard_bg'] = '';
            $data['dashboard_bg_url'] = trim($data['dashboard_bg_url']);
        } else {
            unset($data['dashboard_bg']);
            unset($data['dashboard_bg_url']);
        }

        SiteSetting::setMany($data);

        return back()->with('success', 'Pengaturan website berhasil disimpan.');
    }
}
