@extends('admin.layouts.app')

@section('title', 'Site Settings')

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data"
        class="bg-white rounded-lg shadow-sm p-6 space-y-5 max-w-2xl">
        @csrf
        @method('PUT')

        <h3 class="font-semibold text-gray-700 border-b pb-2 mb-4">Branding</h3>

        <div class="grid grid-cols-3 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Header Logo</label>
                @if ($setting->logo)
                    <img src="{{ asset('storage/' . $setting->logo) }}" class="h-12 mb-2 bg-gray-800 p-1 rounded">
                @endif
                <input type="file" name="logo" accept="image/*"
                    class="w-full border border-gray-200 rounded-md px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Footer Logo</label>
                @if ($setting->footer_logo)
                    <img src="{{ asset('storage/' . $setting->footer_logo) }}" class="h-12 mb-2 bg-gray-800 p-1 rounded">
                @endif
                <input type="file" name="footer_logo" accept="image/*"
                    class="w-full border border-gray-200 rounded-md px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Favicon (square, 512x512px)</label>
                @if ($setting->favicon)
                    <img src="{{ asset('storage/' . $setting->favicon) }}" class="h-12 w-12 mb-2 object-cover rounded">
                @endif
                <input type="file" name="favicon" accept="image/*"
                    class="w-full border border-gray-200 rounded-md px-3 py-2 text-sm">
            </div>
        </div>

        <h3 class="font-semibold text-gray-700 border-b pb-2 mb-4 pt-4">Typography & Theme Color</h3>

        <div>
            <label class="block text-sm font-medium mb-1">Primary Brand Color</label>
            <div class="flex items-center gap-3">
                <input type="color" name="theme_primary_color" id="theme-color-input"
                    value="{{ old('theme_primary_color', $setting->theme_primary_color ?: '#0e4d92') }}"
                    class="w-14 h-10 border border-gray-200 rounded-md cursor-pointer">
                <input type="text" id="theme-color-text"
                    value="{{ old('theme_primary_color', $setting->theme_primary_color ?: '#0e4d92') }}"
                    class="w-28 border border-gray-200 rounded-md px-3 py-2 text-sm font-mono" readonly>
                <span id="theme-color-preview" class="px-4 py-2 rounded-md text-white text-sm font-medium"
                    style="background-color: {{ old('theme_primary_color', $setting->theme_primary_color ?: '#0e4d92') }}">
                    Preview Button
                </span>
            </div>
            <p class="text-xs text-gray-400 mt-1">সাইটের মূল রং — বাটন, লিংক, হাইলাইটে ব্যবহার হবে। গাঢ় শেড (hover color)
                স্বয়ংক্রিয়ভাবে হিসাব হয়ে যাবে।</p>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Site Font</label>
            <select name="theme_font" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
                @foreach ([
            'Poppins' => 'Poppins (Default)',
            'Hind Siliguri' => 'Hind Siliguri',
            'Inter' => 'Inter',
            'Roboto' => 'Roboto',
            'Nunito' => 'Nunito',
            'Open Sans' => 'Open Sans',
            'Noto Sans Bengali' => 'Noto Sans Bengali',
            'Lato' => 'Lato',
        ] as $value => $label)
                    <option value="{{ $value }}"
                        {{ old('theme_font', $setting->theme_font ?: 'Poppins') == $value ? 'selected' : '' }}>
                        {{ $label }}</option>
                @endforeach
            </select>
            <p class="text-xs text-gray-400 mt-1">বাংলা টেক্সটের জন্য Hind Siliguri সবসময় fallback হিসেবে থাকবে, যেকোনো
                ফন্ট বেছে নিলেও বাংলা লেখা ভাঙবে না।</p>
        </div>

        <script>
            const themeColorInput = document.getElementById('theme-color-input');
            const themeColorText = document.getElementById('theme-color-text');
            const themeColorPreview = document.getElementById('theme-color-preview');
            if (themeColorInput) {
                themeColorInput.addEventListener('input', () => {
                    themeColorText.value = themeColorInput.value;
                    themeColorPreview.style.backgroundColor = themeColorInput.value;
                });
            }
        </script>

        <h3 class="font-semibold text-gray-700 border-b pb-2 mb-4 pt-4">Contact Info</h3>

        <div>
            <label class="block text-sm font-medium mb-1">Hotline</label>
            <input type="text" name="hotline" value="{{ old('hotline', $setting->hotline) }}"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">WhatsApp Number (country code সহ, যেমন: 8801xxxxxxxxx)</label>
            <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $setting->whatsapp_number) }}"
                placeholder="8801XXXXXXXXX" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Address</label>
            <input type="text" name="address" value="{{ old('address', $setting->address) }}"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Google Map Embed Code (iframe)</label>
            <textarea name="google_map_embed" rows="3"
                placeholder='<iframe src="https://www.google.com/maps/embed?pb=..." width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>'
                class="w-full border border-gray-200 rounded-md px-4 py-2.5 text-xs font-mono">{{ old('google_map_embed', $setting->google_map_embed) }}</textarea>
            <p class="text-xs text-gray-400 mt-1">Google Maps-এ গিয়ে ঠিকানা সার্চ করো → Share → Embed a map → HTML কোডটা
                কপি করে এখানে বসাও।</p>
        </div>

        @include('admin.partials.map-picker', ['model' => $setting])

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $setting->email) }}"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Facebook URL</label>
                <input type="url" name="facebook_url" value="{{ old('facebook_url', $setting->facebook_url) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Twitter URL</label>
                <input type="url" name="twitter_url" value="{{ old('twitter_url', $setting->twitter_url) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">YouTube URL</label>
                <input type="url" name="youtube_url" value="{{ old('youtube_url', $setting->youtube_url) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Diagnostics URL (external, ঐচ্ছিক ব্যাকআপ)</label>
                <input type="url" name="diagnostic_url" value="{{ old('diagnostic_url', $setting->diagnostic_url) }}"
                    class="w-full border border-gray-200 rounded-md px-4 py-2.5">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Footer Text</label>
            <textarea name="footer_text" rows="2" class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('footer_text', $setting->footer_text) }}</textarea>
        </div>

        <h3 class="font-semibold text-gray-700 border-b pb-2 mb-4 pt-4">Global SEO Defaults</h3>

        <div>
            <label class="block text-sm font-medium mb-1">Site Title Suffix (প্রতিটা পেজের টাইটেলের শেষে যোগ হবে)</label>
            <input type="text" name="site_meta_title_suffix"
                value="{{ old('site_meta_title_suffix', $setting->site_meta_title_suffix) }}"
                placeholder="| Labaid Clone Hospital" class="w-full border border-gray-200 rounded-md px-4 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Default Meta Description (কোনো পেজে আলাদা description না থাকলে
                এটা
                ব্যবহার হবে)</label>
            <textarea name="default_meta_description" rows="2" maxlength="500"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('default_meta_description', $setting->default_meta_description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Default OG Image (সোশ্যাল মিডিয়ায় শেয়ার করলে যে ছবি দেখাবে,
                সুপারিশ: 1200x630px)</label>
            @if ($setting->og_image)
                <img src="{{ asset('storage/' . $setting->og_image) }}" class="h-20 mb-2 rounded">
            @endif
            <input type="file" name="og_image" accept="image/*"
                class="w-full border border-gray-200 rounded-md px-3 py-2 text-sm">
        </div>

        <h3 class="font-semibold text-gray-700 border-b pb-2 mb-4 pt-4">Analytics & Tracking</h3>

        <div>
            <label class="block text-sm font-medium mb-1">Google Analytics (GA4) Measurement ID</label>
            <input type="text" name="google_analytics_id"
                value="{{ old('google_analytics_id', $setting->google_analytics_id) }}" placeholder="G-XXXXXXXXXX"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5 font-mono text-sm">
            <p class="text-xs text-gray-400 mt-1">Google Analytics → Admin → Data Streams → তোমার ওয়েবসাইট স্ট্রিম থেকে
                পাবে।</p>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Google Tag Manager ID (ঐচ্ছিক)</label>
            <input type="text" name="google_tag_manager_id"
                value="{{ old('google_tag_manager_id', $setting->google_tag_manager_id) }}" placeholder="GTM-XXXXXXX"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5 font-mono text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Facebook Pixel ID (ঐচ্ছিক)</label>
            <input type="text" name="facebook_pixel_id"
                value="{{ old('facebook_pixel_id', $setting->facebook_pixel_id) }}" placeholder="123456789012345"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5 font-mono text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Google Search Console Verification Code (ঐচ্ছিক)</label>
            <input type="text" name="google_site_verification"
                value="{{ old('google_site_verification', $setting->google_site_verification) }}"
                placeholder="শুধু content এর ভ্যালু বসাও, পুরো meta ট্যাগ না"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5 font-mono text-sm">
            <p class="text-xs text-gray-400 mt-1">Search Console → Settings → Ownership verification → HTML tag → শুধু
                <code>content="..."</code> এর ভিতরের অংশটুকু বসাও।</p>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Custom Head Scripts (এডভান্সড — অন্য কোনো tracking/verification
                কোড)</label>
            <textarea name="custom_head_scripts" rows="4" placeholder="<!-- যেকোনো raw script/meta tag এখানে বসাও -->"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5 font-mono text-xs">{{ old('custom_head_scripts', $setting->custom_head_scripts) }}</textarea>
            <p class="text-xs text-amber-600 mt-1">⚠️ এটা সরাসরি পেজের &lt;head&gt;-এ বসে, তাই শুধু বিশ্বস্ত সোর্স থেকে কোড
                বসাও।</p>
        </div>

        <h3 class="font-semibold text-gray-700 border-b pb-2 mb-4 pt-4">Maintenance Mode</h3>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="maintenance_mode" value="1"
                {{ old('maintenance_mode', $setting->maintenance_mode) ? 'checked' : '' }}>
            সাইট Maintenance Mode-এ রাখো (ভিজিটররা একটা মেসেজ দেখবে, Admin Panel স্বাভাবিকভাবে কাজ করবে)
        </label>

        <div>
            <label class="block text-sm font-medium mb-1">Maintenance Message</label>
            <textarea name="maintenance_message" rows="2" placeholder="আমরা বর্তমানে সাইট আপডেট করছি। শীঘ্রই ফিরে আসবো।"
                class="w-full border border-gray-200 rounded-md px-4 py-2.5">{{ old('maintenance_message', $setting->maintenance_message) }}</textarea>
        </div>

        <button type="submit" class="btn-primary">Save Settings</button>
    </form>
@endsection
