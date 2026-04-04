const STORAGE_KEY = 'sultan-theme';

/** @returns {'light' | 'dark'} */
export function getResolvedTheme() {
    const stored = localStorage.getItem(STORAGE_KEY);
    if (stored === 'light' || stored === 'dark') {
        return stored;
    }
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

/** @param {'light' | 'dark'} mode */
export function applyTheme(mode, persist = true) {
    const root = document.documentElement;
    const dark = mode === 'dark';
    root.classList.toggle('dark', dark);
    root.setAttribute('data-theme', dark ? 'dark' : 'light');
    if (persist) {
        localStorage.setItem(STORAGE_KEY, mode);
    }
    root.style.colorScheme = dark ? 'dark' : 'light';
    window.dispatchEvent(new CustomEvent('sultan-theme-change', { detail: { theme: mode } }));
    syncToggleUi();
}

export function toggleTheme() {
    const root = document.documentElement;
    const isDark = root.classList.contains('dark') || root.getAttribute('data-theme') === 'dark';
    applyTheme(isDark ? 'light' : 'dark', true);
}

function syncToggleUi() {
    const root = document.documentElement;
    const dark = root.classList.contains('dark') || root.getAttribute('data-theme') === 'dark';
    document.querySelectorAll('[data-theme-toggle]').forEach((btn) => {
        btn.setAttribute('aria-pressed', dark ? 'true' : 'false');
        btn.setAttribute('title', dark ? 'Light mode' : 'Dark mode');
        btn.setAttribute('aria-label', dark ? 'Switch to light mode' : 'Switch to dark mode');
        btn.querySelectorAll('[data-theme-icon="sun"]').forEach((el) => {
            el.classList.toggle('hidden', !dark);
        });
        btn.querySelectorAll('[data-theme-icon="moon"]').forEach((el) => {
            el.classList.toggle('hidden', dark);
        });
    });
}

function onDomReady() {
    document.querySelectorAll('[data-theme-toggle]').forEach((btn) => {
        if (btn.dataset.themeInit) {
            return;
        }
        btn.dataset.themeInit = '1';
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            toggleTheme();
        });
    });
    syncToggleUi();

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (!localStorage.getItem(STORAGE_KEY)) {
            applyTheme(e.matches ? 'dark' : 'light', false);
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', onDomReady);
} else {
    onDomReady();
}
