<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('lms.app_name') }}</title>
    <meta name="description" content="{{ __('lms.welcome.meta_desc') }}">
    @vite(['resources/css/app.css', 'resources/css/landing.css', 'resources/js/app.js', 'resources/js/landing.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="landing-page antialiased" x-data="{ navScrolled: false, mobileOpen: false }" @scroll.window="navScrolled = window.scrollY > 16">

<div class="landing-mesh" aria-hidden="true">
    <div class="landing-mesh__orb landing-mesh__orb--1"></div>
    <div class="landing-mesh__orb landing-mesh__orb--2"></div>
    <div class="landing-mesh__orb landing-mesh__orb--3"></div>
</div>

{{-- Navigation --}}
<header class="landing-nav" :class="{ 'landing-nav--scrolled': navScrolled }">
    <div class="landing-nav__shell">
        <div class="landing-nav__inner">
            <a href="{{ url('/') }}" class="landing-nav__brand">
                <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ __('lms.app_name') }}" class="h-10 w-auto">
                <span class="hidden sm:block">{{ __('lms.app_name') }}</span>
            </a>

            <nav class="landing-nav__links" aria-label="Primary">
                <a href="#fitur" class="landing-nav__link">{{ __('lms.welcome.nav_features') }}</a>
                <a href="#program" class="landing-nav__link">{{ __('lms.welcome.programs') }}</a>
                <a href="#manfaat" class="landing-nav__link">{{ __('lms.welcome.nav_benefits') }}</a>
                <a href="#faq" class="landing-nav__link">{{ __('lms.welcome.nav_faq') }}</a>
                <a href="#kontak" class="landing-nav__link">{{ __('lms.welcome.contact') }}</a>
            </nav>

            <div class="landing-nav__actions">
                <x-locale-switcher class="hidden sm:inline-flex" />
                <a href="{{ route('login') }}" class="hidden sm:inline-flex ds-btn ds-btn--secondary text-sm py-2 px-4">{{ __('lms.welcome.login') }}</a>
                <a href="{{ route('register') }}" class="hidden sm:inline-flex ds-btn ds-btn--primary text-sm py-2 px-4">{{ __('lms.welcome.register') }}</a>
                <button type="button" class="landing-nav__menu-btn" @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen" aria-label="Menu">
                    <svg x-show="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <div x-show="mobileOpen" x-cloak x-transition class="landing-mobile-menu md:hidden">
            <a href="#fitur" @click="mobileOpen = false">{{ __('lms.welcome.nav_features') }}</a>
            <a href="#program" @click="mobileOpen = false">{{ __('lms.welcome.programs') }}</a>
            <a href="#manfaat" @click="mobileOpen = false">{{ __('lms.welcome.nav_benefits') }}</a>
            <a href="#faq" @click="mobileOpen = false">{{ __('lms.welcome.nav_faq') }}</a>
            <a href="#kontak" @click="mobileOpen = false">{{ __('lms.welcome.contact') }}</a>
            <div class="flex items-center gap-2 pt-4">
                <x-locale-switcher />
                <a href="{{ route('login') }}" class="ds-btn ds-btn--secondary text-sm py-2 px-4 flex-1 justify-center">{{ __('lms.welcome.login') }}</a>
                <a href="{{ route('register') }}" class="ds-btn ds-btn--primary text-sm py-2 px-4 flex-1 justify-center">{{ __('lms.welcome.register') }}</a>
            </div>
        </div>
    </div>
</header>

<main>
    {{-- Hero --}}
    <section class="landing-hero">
        <div class="landing-wrap">
            <div class="landing-hero__grid">
                <div class="landing-reveal">
                    <p class="landing-eyebrow">{{ __('lms.welcome.powered_by') }}</p>
                    <h1 class="landing-hero__title">
                        {{ __('lms.welcome.hero_title') }}
                        <span>{{ __('lms.welcome.hero_tagline') }}</span>
                    </h1>
                    <p class="landing-lead">{{ __('lms.welcome.hero_desc') }}</p>
                    <div class="landing-hero__actions">
                        <a href="{{ route('register') }}" class="ds-btn ds-btn--primary px-6 py-3">{{ __('lms.welcome.register_now') }}</a>
                        <a href="{{ route('login') }}" class="ds-btn ds-btn--outline px-6 py-3">{{ __('lms.welcome.login_lms') }}</a>
                    </div>
                    <div class="landing-hero__trust">
                        <span class="landing-hero__trust-badge">
                            <span class="landing-hero__trust-dot"></span>
                            {{ __('lms.welcome.powered_by') }}
                        </span>
                        <span class="text-sm text-slate-500">{{ __('lms.welcome.hero_subtitle') }}</span>
                    </div>
                </div>

                <div class="landing-bento landing-reveal landing-reveal--delay-1">
                    <div class="landing-bento__cell landing-bento__cell--7">
                        <div class="landing-card landing-card--dark landing-card--tall">
                            <div class="landing-card__icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="1.75" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                            </div>
                            <h3 class="landing-card__title">{{ __('lms.welcome.hero_card_skill_up') }}</h3>
                            <p class="landing-card__desc">{{ __('lms.welcome.hero_card_skill_up_desc') }}</p>
                        </div>
                    </div>
                    <div class="landing-bento__cell landing-bento__cell--5">
                        <div class="landing-card landing-card--accent">
                            <div class="landing-card__icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="1.75" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342"/></svg>
                            </div>
                            <h3 class="landing-card__title">{{ __('lms.welcome.hero_card_certification') }}</h3>
                            <p class="landing-card__desc">{{ __('lms.welcome.hero_card_certification_desc') }}</p>
                        </div>
                    </div>
                    <div class="landing-bento__cell landing-bento__cell--6">
                        <div class="landing-card">
                            <div class="landing-card__icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="1.75" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                            </div>
                            <h3 class="landing-card__title">{{ __('lms.welcome.hero_card_future_ready') }}</h3>
                            <p class="landing-card__desc">{{ __('lms.welcome.hero_card_future_ready_desc') }}</p>
                        </div>
                    </div>
                    <div class="landing-bento__cell landing-bento__cell--6">
                        <div class="landing-card">
                            <div class="landing-card__icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="1.75" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/></svg>
                            </div>
                            <h3 class="landing-card__title">{{ __('lms.welcome.hero_card_institutional') }}</h3>
                            <p class="landing-card__desc">{{ __('lms.welcome.hero_card_institutional_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Feature --}}
    <section id="fitur" class="landing-section landing-section--muted">
        <div class="landing-wrap">
            <div class="landing-section-head landing-reveal">
                <p class="landing-eyebrow">{{ __('lms.welcome.features_eyebrow') }}</p>
                <h2 class="landing-heading">{{ __('lms.welcome.features_title') }}</h2>
                <p class="landing-lead">{{ __('lms.welcome.features_desc') }}</p>
            </div>

            <div class="landing-bento">
                @foreach([
                    ['feature_materials', 'feature_materials_desc', 'M4.745 3A23.933 23.933 0 003 12c0 3.026.737 5.874 2.036 8.378M4.745 3A23.933 23.933 0 0121 12c0 3.026-.737 5.874-2.036 8.378M4.745 3L21 21', '8', 'accent'],
                    ['feature_assignments', 'feature_assignments_desc', 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z', '4', ''],
                    ['feature_attendance', 'feature_attendance_desc', 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5', '4', ''],
                    ['feature_certificates', 'feature_certificates_desc', 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z', '4', ''],
                    ['feature_stream', 'feature_stream_desc', 'M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z', '4', ''],
                ] as $i => [$titleKey, $descKey, $iconPath, $span, $variant])
                    <div class="landing-bento__cell landing-bento__cell--{{ $span }} landing-reveal landing-reveal--delay-{{ min($i + 1, 4) }}">
                        <div class="landing-card {{ $variant === 'accent' ? 'landing-card--accent landing-card--tall' : '' }}">
                            <div class="landing-card__icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="1.75" d="{{ $iconPath }}"/></svg>
                            </div>
                            <h3 class="landing-card__title">{{ __('lms.welcome.'.$titleKey) }}</h3>
                            <p class="landing-card__desc">{{ __('lms.welcome.'.$descKey) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Program --}}
    <section id="program" class="landing-section">
        <div class="landing-wrap">
            <div class="landing-section-head landing-section-head--center landing-reveal">
                <p class="landing-eyebrow">{{ __('lms.welcome.featured_programs') }}</p>
                <h2 class="landing-heading">{{ __('lms.welcome.competency') }}</h2>
            </div>

            <div class="landing-bento">
                @foreach([
                    ['program_digital_marketing', 'program_digital_marketing_desc', '0'],
                    ['program_content_creator', 'program_content_creator_desc', '1'],
                    ['program_desain_grafis', 'program_desain_grafis_desc', '2'],
                    ['program_web_dev', 'program_web_dev_desc', '3'],
                    ['program_fotografi', 'program_fotografi_desc', '4'],
                    ['program_public_speaking', 'program_public_speaking_desc', '5'],
                ] as $i => [$titleKey, $descKey, $tagNum])
                    <div @class([
                        'landing-bento__cell landing-reveal',
                        'landing-bento__cell--8' => $i === 0,
                        'landing-bento__cell--4' => $i !== 0,
                        'landing-reveal--delay-'.min($i + 1, 4) => true,
                    ])>
                        <div @class(['landing-card landing-program', 'landing-card--accent' => $i === 0])>
                            <span class="landing-program__tag">{{ str_pad((int) $tagNum + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <h3 class="landing-program__title">{{ __('lms.welcome.'.$titleKey) }}</h3>
                            <p class="landing-program__desc">{{ __('lms.welcome.'.$descKey) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Benefit --}}
    <section id="manfaat" class="landing-section landing-section--muted">
        <div class="landing-wrap">
            <div class="grid lg:grid-cols-2 gap-10 items-start">
                <div class="landing-reveal">
                    <p class="landing-eyebrow">{{ __('lms.welcome.benefits_eyebrow') }}</p>
                    <h2 class="landing-heading">{{ __('lms.welcome.benefits_title') }}</h2>
                    <p class="landing-lead">{{ __('lms.welcome.benefits_desc') }}</p>
                    <div class="mt-8 space-y-4 text-sm leading-relaxed text-slate-600">
                        <p>{{ __('lms.welcome.about_p1') }}</p>
                        <p>{{ __('lms.welcome.about_p2') }}</p>
                    </div>
                    <div class="landing-card landing-card--accent mt-8">
                        <h3 class="landing-card__title text-brand-900">{{ __('lms.welcome.vision') }}</h3>
                        <p class="landing-card__desc mt-2">{{ __('lms.welcome.vision_text') }}</p>
                    </div>
                </div>

                <div class="landing-benefit-list">
                    @foreach([
                        ['benefit_competency', 'benefit_competency_desc'],
                        ['benefit_practice', 'benefit_practice_desc'],
                        ['benefit_mentor', 'benefit_mentor_desc'],
                        ['benefit_career', 'benefit_career_desc'],
                    ] as $i => [$titleKey, $descKey])
                        <div class="landing-benefit-item landing-reveal landing-reveal--delay-{{ min($i + 1, 4) }}">
                            <span class="landing-benefit-item__num">{{ $i + 1 }}</span>
                            <div>
                                <h3 class="font-semibold text-slate-900">{{ __('lms.welcome.'.$titleKey) }}</h3>
                                <p class="mt-1 text-sm text-slate-600 leading-relaxed">{{ __('lms.welcome.'.$descKey) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Statistics --}}
    <section id="statistik" class="landing-section">
        <div class="landing-wrap">
            <div class="landing-section-head landing-section-head--center landing-reveal">
                <p class="landing-eyebrow">{{ __('lms.welcome.stats_eyebrow') }}</p>
                <h2 class="landing-heading">{{ __('lms.welcome.stats_title') }}</h2>
                <p class="landing-lead">{{ __('lms.welcome.stats_desc') }}</p>
            </div>

            <div class="landing-stats-grid">
                @foreach([
                    [$participantCount, 'stat_participants'],
                    [$programCount, 'stat_programs'],
                    [$classCount, 'stat_classes'],
                    [$certificateCount, 'stat_certificates'],
                ] as $i => [$value, $labelKey])
                    <div class="landing-stat landing-reveal landing-reveal--delay-{{ min($i + 1, 4) }}">
                        <p class="landing-stat__value" data-count="{{ $value }}">0</p>
                        <p class="landing-stat__label">{{ __('lms.welcome.'.$labelKey) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section id="faq" class="landing-section landing-section--muted" x-data="{ open: null }">
        <div class="landing-wrap">
            <div class="landing-section-head landing-section-head--center landing-reveal">
                <p class="landing-eyebrow">{{ __('lms.welcome.faq_eyebrow') }}</p>
                <h2 class="landing-heading">{{ __('lms.welcome.faq_title') }}</h2>
                <p class="landing-lead">{{ __('lms.welcome.faq_desc') }}</p>
            </div>

            <div class="landing-faq">
                @foreach(range(1, 5) as $n)
                    <div class="landing-faq__item landing-reveal landing-reveal--delay-{{ min($n, 4) }}" :class="{ 'is-open': open === {{ $n }} }">
                        <button type="button" class="landing-faq__trigger" @click="open = open === {{ $n }} ? null : {{ $n }}" :aria-expanded="open === {{ $n }}">
                            <span>{{ __('lms.welcome.faq_q'.$n) }}</span>
                            <svg class="landing-faq__chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="landing-faq__panel" x-ref="panel{{ $n }}" :style="open === {{ $n }} ? 'max-height:' + $refs.panel{{ $n }}.scrollHeight + 'px' : ''">
                            <div class="landing-faq__answer">{{ __('lms.welcome.faq_a'.$n) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="landing-cta">
        <div class="landing-wrap">
            <div class="landing-cta__panel landing-reveal">
                <div class="landing-cta__content">
                    <h2 class="landing-cta__title">{{ __('lms.welcome.cta_title') }}</h2>
                    <p class="landing-cta__desc">{{ __('lms.welcome.cta_desc') }}</p>
                    <div class="landing-cta__actions">
                        <a href="{{ route('register') }}" class="landing-cta__btn-primary">{{ __('lms.welcome.register_now') }}</a>
                        <a href="{{ route('login') }}" class="landing-cta__btn-ghost">{{ __('lms.welcome.login_lms') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

{{-- Footer --}}
<footer id="kontak" class="landing-footer">
    <div class="landing-wrap">
        <div class="landing-footer__grid">
            <div class="landing-footer__brand">
                <img src="{{ asset('storage/images/Logo.png') }}" alt="{{ __('lms.app_name') }}" class="h-10 w-auto brightness-0 invert opacity-90">
                <p>{{ __('lms.welcome.footer_tagline') }}</p>
            </div>
            <div>
                <h3 class="landing-footer__heading">{{ __('lms.welcome.links') }}</h3>
                <div class="landing-footer__links">
                    <a href="{{ route('legal.privacy') }}">{{ __('lms.welcome.privacy') }}</a>
                    <a href="{{ route('legal.terms') }}">{{ __('lms.welcome.terms') }}</a>
                    <a href="{{ route('legal.help') }}">{{ __('lms.welcome.help') }}</a>
                </div>
            </div>
            <div>
                <h3 class="landing-footer__heading">{{ __('lms.welcome.contact_title') }}</h3>
                <p class="text-sm leading-relaxed">{{ __('lms.welcome.contact_address_full') }}</p>
                <p class="text-sm mt-3">{{ __('lms.welcome.contact_email') }}</p>
                <p class="text-sm mt-1">{{ __('lms.welcome.contact_phone') }}</p>
            </div>
        </div>
        <div class="landing-footer__bottom">
            © {{ date('Y') }} {{ __('lms.app_name') }} · {{ __('lms.welcome.powered_by') }}
        </div>
    </div>
</footer>

</body>
</html>
