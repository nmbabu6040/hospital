@php
    $shareUrl = urlencode(url()->current());
    $shareTitle = urlencode($title ?? config('app.name'));
@endphp

<div class="flex items-center gap-2">
    <span class="text-xs text-gray-400 mr-1">Share:</span>

    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener"
        class="w-8 h-8 rounded-full bg-[#1877F2] text-white flex items-center justify-center hover:opacity-90 transition"
        aria-label="Share on Facebook">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path
                d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.99 3.66 9.13 8.44 9.88v-6.99h-2.54V12h2.54V9.8c0-2.5 1.49-3.89 3.78-3.89 1.09 0 2.23.2 2.23.2v2.45h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99C18.34 21.13 22 16.99 22 12z" />
        </svg>
    </a>

    <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank"
        rel="noopener"
        class="w-8 h-8 rounded-full bg-black text-white flex items-center justify-center hover:opacity-90 transition"
        aria-label="Share on X">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path
                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
        </svg>
    </a>

    <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank" rel="noopener"
        class="w-8 h-8 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:opacity-90 transition"
        aria-label="Share on WhatsApp">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path
                d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.39 1.26 4.82L2 22l5.4-1.42a9.87 9.87 0 004.64 1.18h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0012.04 2zm5.83 14.07c-.25.69-1.24 1.27-1.95 1.42-.5.1-1.15.19-3.33-.71-2.79-1.15-4.59-3.99-4.73-4.17-.14-.19-1.13-1.5-1.13-2.86 0-1.37.7-2.03.95-2.31.25-.28.54-.35.72-.35.18 0 .36 0 .51.01.17.01.38-.06.6.46.22.53.76 1.84.82 1.97.07.14.11.3.02.49-.09.19-.14.3-.27.46-.14.17-.29.37-.41.5-.14.14-.28.29-.12.57.16.28.71 1.17 1.52 1.9 1.05.94 1.93 1.23 2.21 1.37.28.14.44.12.6-.07.17-.19.69-.8.88-1.08.19-.28.37-.23.63-.14.25.09 1.6.76 1.88.9.28.14.46.21.53.33.07.12.07.68-.18 1.36z" />
        </svg>
    </a>

    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener"
        class="w-8 h-8 rounded-full bg-[#0A66C2] text-white flex items-center justify-center hover:opacity-90 transition"
        aria-label="Share on LinkedIn">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path
                d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.86 0-2.14 1.45-2.14 2.94v5.67H9.34V9h3.41v1.56h.05c.47-.9 1.63-1.85 3.36-1.85 3.6 0 4.26 2.37 4.26 5.46v6.28zM5.34 7.43a2.06 2.06 0 110-4.13 2.06 2.06 0 010 4.13zM7.12 20.45H3.56V9h3.56v11.45z" />
        </svg>
    </a>

    <button type="button"
        onclick="navigator.clipboard.writeText(window.location.href); this.querySelector('.copy-label').textContent='Copied!'; setTimeout(() => this.querySelector('.copy-label').textContent='Copy', 1500);"
        class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200 flex items-center justify-center hover:opacity-90 transition"
        aria-label="Copy link">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
        </svg>
    </button>
</div>
