<div x-data="accessibilityWidget()" class="fixed bottom-24 right-6 z-40" x-cloak>
    <button @click="open = !open" class="floating-btn bg-gray-700 hover:bg-gray-800" aria-label="Accessibility options"
        style="position: static;">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
    </button>

    <div x-show="open" @click.outside="open = false" x-transition
        class="absolute bottom-16 right-0 w-64 bg-white dark:bg-gray-900 rounded-lg shadow-xl border border-gray-100 dark:border-gray-800 p-4">
        <h3 class="font-semibold text-sm mb-3">Accessibility</h3>

        <p class="text-xs text-gray-500 mb-2">Font Size</p>
        <div class="flex gap-2 mb-4">
            <button @click="setFontSize('normal')"
                :class="fontSize === 'normal' ? 'bg-brand text-white' : 'bg-gray-100'"
                class="flex-1 py-1.5 rounded text-xs">A</button>
            <button @click="setFontSize('large')"
                :class="fontSize === 'large' ? 'bg-brand text-white' : 'bg-gray-100'"
                class="flex-1 py-1.5 rounded text-sm">A+</button>
            <button @click="setFontSize('xlarge')"
                :class="fontSize === 'xlarge' ? 'bg-brand text-white' : 'bg-gray-100'"
                class="flex-1 py-1.5 rounded text-base">A++</button>
        </div>

        <label class="flex items-center gap-2 text-xs">
            <input type="checkbox" x-model="highContrast" @change="toggleContrast()">
            High Contrast Mode
        </label>
    </div>
</div>

<script>
    function accessibilityWidget() {
        return {
            open: false,
            fontSize: localStorage.getItem('a11y-font-size') || 'normal',
            highContrast: localStorage.getItem('a11y-contrast') === 'true',

            init() {
                this.applyFontSize();
                if (this.highContrast) document.documentElement.classList.add('high-contrast');
            },

            setFontSize(size) {
                this.fontSize = size;
                localStorage.setItem('a11y-font-size', size);
                this.applyFontSize();
            },

            applyFontSize() {
                document.documentElement.classList.remove('font-large', 'font-xlarge');
                if (this.fontSize === 'large') document.documentElement.classList.add('font-large');
                if (this.fontSize === 'xlarge') document.documentElement.classList.add('font-xlarge');
            },

            toggleContrast() {
                localStorage.setItem('a11y-contrast', this.highContrast);
                document.documentElement.classList.toggle('high-contrast', this.highContrast);
            },
        };
    }
</script>
