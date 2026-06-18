
import Alpine from 'alpinejs';

window.Alpine = Alpine;

const NAV_KEY = 'lms-nav-active';
const NAV_STARTED_KEY = 'lms-nav-started';

function isAuthenticatedApp() {
    const role = document.documentElement.dataset.userRole;
    const uid = document.documentElement.dataset.userId;
    return Boolean(uid && role && role !== 'guest');
}

function isLoaderVisible() {
    return document.documentElement.classList.contains('lms-nav-loading');
}

window.LmsLoader = {
    _el: null,
    _hideTimer: null,
    _safetyTimer: null,
    _shownAt: 0,
    _minShow: 60,
    _initialized: false,
    _finishing: false,

    init() {
        if (this._initialized) {
            return;
        }
        this._initialized = true;

        this._el = document.getElementById('lms-page-loader');
        if (!this._el || !isAuthenticatedApp()) {
            this._clearNavState();
            return;
        }

        this._minShow = parseInt(this._el.dataset.minShow || '60', 10);

        const pending = sessionStorage.getItem(NAV_KEY) === '1';
        if (pending) {
            this._syncFromNavigation();
        } else {
            this.forceHide();
        }

        this.bindNavigation();
        this.bindForms();
        this.bindPageReady();

        this._safetyTimer = window.setTimeout(() => this.forceHide(), 5000);
    },

    _clearNavState() {
        document.documentElement.classList.remove('lms-nav-loading');
        try {
            sessionStorage.removeItem(NAV_KEY);
            sessionStorage.removeItem(NAV_STARTED_KEY);
        } catch (e) {}
        if (this._el) {
            this._el.classList.remove('is-active');
            this._el.setAttribute('aria-hidden', 'true');
        }
    },

    _syncFromNavigation() {
        const started = parseInt(sessionStorage.getItem(NAV_STARTED_KEY) || '0', 10);
        this._shownAt = started > 0 ? started : performance.now();

        document.documentElement.classList.add('lms-nav-loading');
        if (this._el) {
            this._el.classList.add('is-active');
            this._el.setAttribute('aria-hidden', 'false');
        }
    },

    _showUi(persist = true) {
        const main = document.querySelector('.page-content-3d');
        if (main) {
            main.classList.add('lms-page-exiting');
        }

        if (isLoaderVisible()) {
            return;
        }

        const now = performance.now();
        this._shownAt = now;

        if (persist) {
            try {
                sessionStorage.setItem(NAV_KEY, '1');
                sessionStorage.setItem(NAV_STARTED_KEY, String(now));
            } catch (e) {}
        }

        document.documentElement.classList.add('lms-nav-loading');
        if (this._el) {
            this._el.classList.add('is-active');
            this._el.setAttribute('aria-hidden', 'false');
        }
    },

    show(persist = true) {
        this._showUi(persist);
    },

    forceHide() {
        if (this._finishing) {
            return;
        }

        window.clearTimeout(this._hideTimer);
        this._finishing = true;

        document.documentElement.classList.remove('lms-nav-loading');

        const main = document.querySelector('.page-content-3d');
        if (main) {
            main.classList.remove('lms-page-exiting');
        }

        if (this._el) {
            this._el.classList.remove('is-active');
            this._el.setAttribute('aria-hidden', 'true');
        }

        try {
            sessionStorage.removeItem(NAV_KEY);
            sessionStorage.removeItem(NAV_STARTED_KEY);
        } catch (e) {}

        window.setTimeout(() => {
            this._finishing = false;
        }, 50);
    },

    hide() {
        if (!isLoaderVisible()) {
            return;
        }

        const started = parseInt(sessionStorage.getItem(NAV_STARTED_KEY) || '0', 10);
        const elapsed = started > 0
            ? performance.now() - started
            : performance.now() - (this._shownAt || 0);
        const delay = Math.max(0, this._minShow - elapsed);

        window.clearTimeout(this._hideTimer);
        this._hideTimer = window.setTimeout(() => this.forceHide(), delay);
    },

    bindPageReady() {
        const finish = () => {
            if (sessionStorage.getItem(NAV_KEY) === '1' || isLoaderVisible()) {
                this.forceHide();
            }
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', finish, { once: true });
        } else {
            finish();
        }

        window.addEventListener('pageshow', (e) => {
            if (e.persisted) {
                this.forceHide();
            }
        });
    },

    isNavigationUrl(url) {
        if (url.origin !== window.location.origin) {
            return false;
        }

        const path = url.pathname;

        if (/\/locale\//i.test(path)) {
            return false;
        }

        if (/\/(download|export)(\/?|$)/i.test(path)) {
            return false;
        }

        if (/\.(pdf|zip|xlsx?|csv|docx?|png|jpe?g|gif|webp|mp4|webm)$/i.test(path)) {
            return false;
        }

        return true;
    },

    shouldHandleLink(link) {
        if (!link || link.dataset.lmsNoLoader !== undefined) {
            return false;
        }
        if (isLoaderVisible()) {
            return false;
        }
        if (link.target === '_blank' || link.hasAttribute('download')) {
            return false;
        }
        if (link.closest('#lms-page-loader, [x-data*="lmsDialog"]')) {
            return false;
        }
        if (link.closest('[data-lms-no-loader], .lms-locale-switcher')) {
            return false;
        }

        const href = link.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) {
            return false;
        }

        try {
            const url = new URL(link.href, window.location.href);
            if (url.pathname === window.location.pathname && url.search === window.location.search) {
                return false;
            }
            return this.isNavigationUrl(url);
        } catch (e) {
            return false;
        }
    },

    shouldShowOnFormSubmit(form, submitter) {
        if (isLoaderVisible()) {
            return false;
        }
        if (form.dataset.lmsNoLoader !== undefined) {
            return false;
        }
        if (form.target === '_blank') {
            return false;
        }
        if (form.dataset.lmsConfirmed !== '1') {
            if (form.dataset.lmsConfirm || submitter?.dataset?.lmsConfirm) {
                return false;
            }
        }

        const action = form.getAttribute('action') || window.location.href;
        try {
            return this.isNavigationUrl(new URL(action, window.location.href));
        } catch (e) {
            return true;
        }
    },

    bindNavigation() {
        document.addEventListener('click', (e) => {
            if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) {
                return;
            }

            const link = e.target.closest('a[href]');
            if (!this.shouldHandleLink(link)) {
                return;
            }

            this.show();
        }, true);
    },

    bindForms() {
        document.addEventListener('submit', (e) => {
            const form = e.target;
            if (!(form instanceof HTMLFormElement)) {
                return;
            }
            if (e.defaultPrevented) {
                return;
            }
            if (!this.shouldShowOnFormSubmit(form, e.submitter)) {
                return;
            }
            this.show();
        }, false);
    },
};

window.LmsTheme = {
    storageKey(role, userId) {
        const base = 'lms-theme-' + (role || 'guest');
        return userId ? base + '-' + userId : base;
    },

    currentRole() {
        return document.documentElement.dataset.userRole || 'guest';
    },

    currentUserId() {
        return document.documentElement.dataset.userId || '';
    },

    get() {
        const role = this.currentRole();
        const uid = this.currentUserId();
        return localStorage.getItem(this.storageKey(role, uid))
            || localStorage.getItem(this.storageKey(role, ''))
            || 'light';
    },

    set(theme) {
        const role = this.currentRole();
        const uid = this.currentUserId();
        const value = theme === 'dark' ? 'dark' : 'light';
        localStorage.setItem(this.storageKey(role, uid), value);
        localStorage.setItem(this.storageKey(role, ''), value);
        this.apply(value);
    },

    apply(theme) {
        const isDark = theme === 'dark';
        document.documentElement.classList.toggle('dark', isDark);
        document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
    },

    toggle() {
        const next = this.get() === 'dark' ? 'light' : 'dark';
        this.set(next);
        return next;
    },

    init() {
        if (!isAuthenticatedApp()) {
            document.documentElement.classList.remove('dark');
            document.documentElement.setAttribute('data-theme', 'light');
            return;
        }
        this.apply(this.get());
    },
};

window.LmsDialog = {
    alert(message) {
        return new Promise((resolve) => {
            window.dispatchEvent(new CustomEvent('lms-dialog-alert', {
                detail: { message: String(message), resolve },
            }));
        });
    },

    confirm(message) {
        return new Promise((resolve) => {
            window.dispatchEvent(new CustomEvent('lms-dialog-confirm', {
                detail: { message: String(message), resolve },
            }));
        });
    },
};

function setupLmsFormConfirm() {
    if (document.documentElement.dataset.lmsConfirmBound === '1') {
        return;
    }
    document.documentElement.dataset.lmsConfirmBound = '1';

    document.addEventListener('submit', async (e) => {
        const form = e.target;
        if (!(form instanceof HTMLFormElement)) {
            return;
        }

        let msg = form.dataset.lmsConfirm;
        const submitter = e.submitter;

        if (submitter && submitter.dataset.lmsConfirm) {
            msg = submitter.dataset.lmsConfirm;
        }

        if (!msg) {
            return;
        }

        if (form.dataset.lmsConfirmed === '1') {
            delete form.dataset.lmsConfirmed;
            return;
        }

        e.preventDefault();
        e.stopPropagation();

        const ok = await window.LmsDialog.confirm(msg);
        if (ok) {
            form.dataset.lmsConfirmed = '1';
            form.requestSubmit(submitter || undefined);
        }
    }, true);
}

document.addEventListener('alpine:init', () => {
    Alpine.data('themeToggle', () => ({
        dark: document.documentElement.classList.contains('dark'),
        init() {
            this.dark = window.LmsTheme.get() === 'dark';
        },
        toggle() {
            const next = window.LmsTheme.toggle();
            this.dark = next === 'dark';
        },
    }));

    Alpine.data('lmsDialog', () => ({
        alertOpen: false,
        confirmOpen: false,
        message: '',
        _alertResolve: null,
        _confirmResolve: null,

        openAlert({ message, resolve }) {
            this.message = message;
            this._alertResolve = resolve;
            this.alertOpen = true;
        },

        closeAlert() {
            this.alertOpen = false;
            if (this._alertResolve) {
                this._alertResolve();
                this._alertResolve = null;
            }
        },

        openConfirm({ message, resolve }) {
            this.message = message;
            this._confirmResolve = resolve;
            this.confirmOpen = true;
        },

        confirmYes() {
            this.confirmOpen = false;
            if (this._confirmResolve) {
                this._confirmResolve(true);
                this._confirmResolve = null;
            }
        },

        confirmNo() {
            this.confirmOpen = false;
            if (this._confirmResolve) {
                this._confirmResolve(false);
                this._confirmResolve = null;
            }
        },
    }));
});

window.LmsLocale = {
    init() {
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-lms-locale]');
            if (!btn) {
                return;
            }

            const locale = btn.getAttribute('data-lms-locale');
            const htmlLang = (document.documentElement.lang || 'id').toLowerCase().slice(0, 2);
            if (locale === htmlLang) {
                e.preventDefault();
                return;
            }

            e.preventDefault();
            e.stopPropagation();

            const href = btn.getAttribute('href');
            if (!href) {
                return;
            }

            try {
                sessionStorage.removeItem(NAV_KEY);
                sessionStorage.removeItem(NAV_STARTED_KEY);
            } catch (err) {}

            window.location.replace(href);
        }, true);
    },
};

let lmsAppBooted = false;

function bootLmsApp() {
    if (lmsAppBooted) {
        return;
    }
    lmsAppBooted = true;

    window.LmsTheme.init();
    window.LmsLocale.init();

    if (isAuthenticatedApp()) {
        window.LmsLoader.init();
        setupLmsFormConfirm();
    } else {
        document.documentElement.classList.remove('lms-nav-loading');
        try {
            sessionStorage.removeItem(NAV_KEY);
            sessionStorage.removeItem(NAV_STARTED_KEY);
        } catch (e) {}
        const loaderEl = document.getElementById('lms-page-loader');
        if (loaderEl) {
            loaderEl.classList.remove('is-active');
            loaderEl.setAttribute('aria-hidden', 'true');
        }
    }
}

document.addEventListener('DOMContentLoaded', bootLmsApp);

if (document.readyState !== 'loading') {
    bootLmsApp();
}

Alpine.start();
