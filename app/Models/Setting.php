<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'logo',
        'footer_logo',
        'favicon',
        'hotline',
        'whatsapp_number',
        'address',
        'google_map_embed',
        'latitude',
        'longitude',
        'email',
        'facebook_url',
        'twitter_url',
        'youtube_url',
        'diagnostic_url',
        'footer_text',
        'maintenance_mode',
        'maintenance_message',
        'site_meta_title_suffix',
        'default_meta_description',
        'og_image',
        'google_analytics_id',
        'google_tag_manager_id',
        'facebook_pixel_id',
        'google_site_verification',
        'custom_head_scripts',
        'theme_primary_color',
        'theme_font',
        'live_chat_enabled',
        'tawk_to_property_id',
        'tawk_to_widget_id',
    ];

    protected function casts(): array
    {
        return [
            'maintenance_mode' => 'boolean',
            'live_chat_enabled' => 'boolean',
        ];
    }

    public static function get()
    {
        return self::first() ?? new self();
    }

    public function themePrimaryColor(): string
    {
        return $this->theme_primary_color ?: '#0e4d92';
    }

    public function themePrimaryDarkColor(): string
    {
        return $this->darkenHex($this->themePrimaryColor(), 0.22);
    }

    public function themeFont(): string
    {
        return $this->theme_font ?: 'Poppins';
    }

    /**
     * একটা hex color-কে নির্দিষ্ট শতাংশ অন্ধকার করে, hover/active শেডের জন্য।
     */
    private function darkenHex(string $hex, float $percent): string
    {
        $hex = ltrim($hex, '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        if (strlen($hex) !== 6 || ! ctype_xdigit($hex)) {
            return '#09325f';
        }

        $r = max(0, (int) round(hexdec(substr($hex, 0, 2)) * (1 - $percent)));
        $g = max(0, (int) round(hexdec(substr($hex, 2, 2)) * (1 - $percent)));
        $b = max(0, (int) round(hexdec(substr($hex, 4, 2)) * (1 - $percent)));

        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }
}
