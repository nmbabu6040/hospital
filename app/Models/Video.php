<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'youtube_url', 'is_featured'];

    /**
     * যেকোনো ফরম্যাটের YouTube URL (watch, youtu.be, embed) থেকে
     * video ID বের করে সবসময় সঠিক embed URL সেভ করে।
     */
    public function setYoutubeUrlAttribute(?string $value): void
    {
        $this->attributes['youtube_url'] = $this->toEmbedUrl($value);
    }

    private function toEmbedUrl(?string $url): ?string
    {
        if (! $url) {
            return $url;
        }

        $videoId = null;

        // Format 1: https://www.youtube.com/watch?v=VIDEO_ID
        if (preg_match('/[?&]v=([A-Za-z0-9_-]{11})/', $url, $matches)) {
            $videoId = $matches[1];
        }
        // Format 2: https://youtu.be/VIDEO_ID
        elseif (preg_match('/youtu\.be\/([A-Za-z0-9_-]{11})/', $url, $matches)) {
            $videoId = $matches[1];
        }
        // Format 3: already an embed URL — https://www.youtube.com/embed/VIDEO_ID
        elseif (preg_match('/youtube\.com\/embed\/([A-Za-z0-9_-]{11})/', $url, $matches)) {
            $videoId = $matches[1];
        }
        // Format 4: shorts — https://www.youtube.com/shorts/VIDEO_ID
        elseif (preg_match('/youtube\.com\/shorts\/([A-Za-z0-9_-]{11})/', $url, $matches)) {
            $videoId = $matches[1];
        }

        if ($videoId) {
            return 'https://www.youtube-nocookie.com/embed/' . $videoId;
        }

        // কোনো প্যাটার্নে না মিললে, যা দেওয়া হয়েছে তাই রাখা হলো (fallback)
        return $url;
    }


    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
        ];
    }
}
