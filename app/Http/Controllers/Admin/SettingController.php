<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::get();

        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::get();

        $data = $request->validate([
            'hotline' => ['nullable', 'string', 'max:50'],
            'whatsapp_number' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'google_map_embed' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'email' => ['nullable', 'email', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'diagnostic_url' => ['nullable', 'url', 'max:255'],
            'footer_text' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:1024'],
            'footer_logo' => ['nullable', 'image', 'max:1024'],
            'favicon' => ['nullable', 'image', 'max:512'],
            'maintenance_mode' => ['nullable', 'boolean'],
            'maintenance_message' => ['nullable', 'string'],
            'site_meta_title_suffix' => ['nullable', 'string', 'max:255'],
            'default_meta_description' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'image', 'max:2048'],
            'google_analytics_id' => ['nullable', 'string', 'max:50', 'regex:/^(G|UA)-[A-Za-z0-9-]+$/'],
            'google_tag_manager_id' => ['nullable', 'string', 'max:50', 'regex:/^GTM-[A-Za-z0-9]+$/'],
            'facebook_pixel_id' => ['nullable', 'string', 'max:50', 'regex:/^[0-9]+$/'],
            'google_site_verification' => ['nullable', 'string', 'max:255'],
            'custom_head_scripts' => ['nullable', 'string'],
            'theme_primary_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_font' => ['nullable', 'string', 'in:Poppins,Hind Siliguri,Inter,Roboto,Nunito,Open Sans,Noto Sans Bengali,Lato'],
        ]);

        $data['maintenance_mode'] = $request->boolean('maintenance_mode');

        foreach (['logo', 'footer_logo', 'favicon', 'og_image'] as $field) {
            if ($request->hasFile($field)) {
                if ($setting->$field) {
                    Storage::disk('public')->delete($setting->$field);
                }
                $data[$field] = $request->file($field)->store('settings', 'public');
            }
        }

        if ($setting->exists) {
            $setting->update($data);
        } else {
            Setting::create($data);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
