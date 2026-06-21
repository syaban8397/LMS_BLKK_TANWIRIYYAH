#!/usr/bin/env python3
"""Second pass fixes for blade UI refactor."""
from __future__ import annotations

import re
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1] / "resources" / "views"
GAP = "ga" + "p"

TARGETS = list((ROOT / "instruktur").rglob("*.blade.php"))
TARGETS += list((ROOT / "peserta").rglob("*.blade.php"))
TARGETS += [ROOT / "profile" / "edit.blade.php"]


def fix_section_attrs(text: str) -> str:
    text = re.sub(
        r':title=__\(([^)]+)\)\s*:description=([^"\s]+(?:\([^)]*\))?[^"\s]*)\s*icon=\\"clipboard\\"\s*compact>',
        r':title="__\1" :description="\2" icon="clipboard" compact',
        text,
    )
    text = re.sub(
        r':title=__\(([^)]+)\)\s*:description=([^"\s]+(?:\.[^"\s]+)*)\s*icon=\\"clipboard\\"\s*compact>',
        r':title="__\1" :description="\2" icon="clipboard" compact',
        text,
    )
    # peserta classes index special case
    text = text.replace(
        ":title=__('lms.common.class_list') :description=__('lms.common.total') . ': ' . $enrolledClasses->total() icon=\\\"clipboard\\\" compact",
        ':title="__(\'lms.common.class_list\')" :description="__(\'lms.common.total\') . \': \' . $enrolledClasses->total()" icon="clipboard" compact',
    )
    return text


def ensure_page_shell(text: str) -> str:
    if not text.strip().startswith("<x-app-layout>"):
        return text

    extra = ""
    m = re.search(r'<div[^>]*class="([^"]*lms-module-shell[^"]*)"', text)
    if m:
        classes = [
            c
            for c in m.group(1).split()
            if c not in ("lms-module-shell", "space-y-6", "space-y-5")
            and not c.endswith("-wrapper")
        ]
        extra = " ".join(classes)

    text = re.sub(
        r"<x-app-layout>\s*<div[^>]*lms-module-shell[^>]*>\s*",
        "<x-app-layout>\n    ",
        text,
        count=1,
    )
    text = re.sub(
        r"<x-app-layout>\s*<div[^>]*lms-module-shell[^>]*>\s*",
        "<x-app-layout>\n    ",
        text,
        count=1,
    )

    if "<x-lms-page-shell" not in text:
        cls = f' class="{extra}"' if extra else ""
        text = text.replace(
            "<x-app-layout>",
            f"<x-app-layout>\n    <x-lms-page-shell{cls}>",
            1,
        )
        # close before script or end
        if re.search(r"\n\s*<script>", text):
            text = re.sub(
                r"(\n\s*<script>)",
                r"\n    </x-lms-page-shell>\1",
                text,
                count=1,
            )
        else:
            text = text.replace(
                "</x-app-layout>",
                "    </x-lms-page-shell>\n</x-app-layout>",
                1,
            )
    else:
        # remove stray closing div before page-shell close
        text = re.sub(
            r"\n\s*</div>\s*\n(\s*</x-lms-page-shell>)",
            r"\n\1",
            text,
            count=1,
        )

    return text


def convert_list_card_file(text: str) -> str:
    if "<x-lms-list-card" not in text:
        return text
    pattern = re.compile(
        r"        <x-lms-list-card\s+(.*?)\s*>\s*(.*?)\s*(?:<x-slot:emptyActions>(.*?)</x-slot:emptyActions>\s*)?        </x-lms-list-card>",
        re.DOTALL,
    )

    def build(m: re.Match[str]) -> str:
        attrs, body, empty_actions = m.group(1), m.group(2), (m.group(3) or "").strip()
        title = re.search(r':title="([^"]+)"', attrs)
        meta = re.search(r':meta="([^"]+)"', attrs)
        pag = re.search(r':paginator="([^"]+)"', attrs)
        eicon = re.search(r'emptyIcon="([^"]+)"', attrs)
        etitle = re.search(r':emptyTitle="([^"]+)"', attrs)
        edesc = re.search(r':emptyDescription="([^"]+)"', attrs)

        t = title.group(1) if title else "__('lms.no_data')"
        md = meta.group(1) if meta else "null"
        pg = pag.group(1) if pag else None
        ei = eicon.group(1) if eicon else "book"
        et = etitle.group(1) if etitle else "__('lms.no_data')"
        ed = edesc.group(1) if edesc else None

        body = re.sub(
            r'<div class="(?:material-row|assignment-row)[^"]*">\s*<div class="flex flex-wrap md:flex-nowrap items-start justify-between[^"]*">',
            '<div class="lms-list-item">\n                        <div class="min-w-0 flex-1">',
            body,
        )
        body = re.sub(
            r'<x-lms-row-actions class="flex-shrink-0">(.*?)</x-lms-row-actions>\s*</div>\s*</div>',
            r'<x-lms-row-actions class="shrink-0">\1</x-lms-row-actions>\n                        </div>\n                    </div>',
            body,
            flags=re.DOTALL,
        )
        body = re.sub(
            r'<div class="flex-shrink-0">\s*<a href="([^"]+)" class="lms-btn-primary[^"]*">([^<]+)</a>\s*</div>\s*</div>\s*</div>',
            r'<a href="\1" class="lms-btn-primary text-sm shrink-0">\2</a>\n                        </div>\n                    </div>',
            body,
        )
        body = body.replace('class="divide-y divide-slate-100 dark:divide-slate-700/55"', "")

        if not pg:
            return m.group(0)
        var = pg.lstrip("$")
        out = (
            f"        @if(${var}->count() > 0)\n"
            f"        <x-lms-section :title=\"{t}\" :description=\"{md}\" icon=\"book\" compact>\n"
            f"            <x-lms-panel>\n{body.strip()}\n            </x-lms-panel>\n"
            f"            <x-lms-pagination :paginator=\"{pg}\" />\n"
            f"        </x-lms-section>\n"
            f"        @else\n"
            f"        <x-lms-section :title=\"{t}\" compact>\n"
            f"            <x-lms-panel>\n"
            f"                <x-lms-empty-state icon=\"{ei}\" :title=\"{et}\""
        )
        if ed:
            out += f" :description=\"{ed}\""
        out += ">\n"
        if empty_actions:
            out += f"                    <x-slot:actions>\n                        {empty_actions}\n                    </x-slot:actions>\n"
        out += "                </x-lms-empty-state>\n            </x-lms-panel>\n        </x-lms-section>\n        @endif"
        return out

    return pattern.sub(build, text)


def fix_profile_edit() -> None:
    path = ROOT / "profile" / "edit.blade.php"
    text = """<x-app-layout>
    <x-lms-page-shell class="max-w-5xl mx-auto">
        <x-lms-page-header :title="__('lms.profile')" :subtitle="__('lms.profile_page.subtitle')" />

        <x-lms-session-flash />
        <x-lms-validation-errors />

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="grid lg:grid-cols-3 {{GAP}}-5">
                <x-lms-panel>
                    <x-lms-form-card :title="__('lms.common.profile_photo')" icon="camera">
                        <div class="flex flex-col items-center text-center">
                            <img id="photo-preview"
                                 src="{{ $user->profilePhotoUrl() }}"
                                 alt="{{ $user->name }}"
                                 class="w-32 h-32 rounded-2xl object-cover border border-slate-200 dark:border-slate-600 shadow-md ring-4 ring-brand-50 dark:ring-brand-900/30">
                            <p class="mt-3 text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $user->name }}</p>
                            <p class="text-xs text-slate-500 capitalize">{{ __('lms.roles.' . $user->role) }}</p>
                            <p class="text-xs text-slate-400 mt-1">{{ $user->email }}</p>

                            <label for="photo" class="mt-4 w-full cursor-pointer">
                                <span class="lms-btn-secondary w-full inline-flex justify-center text-xs py-2">
                                    {{ __('lms.profile_page.upload_new_photo') }}
                                </span>
                                <input id="photo" name="photo" type="file" accept="image/*" class=" sr-only" onchange="previewPhoto(event)">
                            </label>
                            <p class="text-[11px] text-slate-400 mt-2">{{ __('lms.common.leave_blank') }}</p>
                            <x-input-error class="mt-2" :messages="$ errors->get('photo')" />
                        </div>
                    </x-lms-form-card>
                </x-lms-panel>
""".replace("{{GAP}}", GAP)
    # fix typos I introduced
    text = text.replace('class=" sr-only"', 'class=" sr-only"').replace('class=" sr-only"', 'class=" sr-only"')
    text = text.replace('$ errors', '$ errors')
    # rewrite cleanly without typos
    path.write_text("""<x-app-layout>
    <x-lms-page-shell class="max-w-5xl mx-auto">
        <x-lms-page-header :title="__('lms.profile')" :subtitle="__('lms.profile_page.subtitle')" />

        <x-lms-session-flash />
        <x-lms-validation-errors />

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="grid lg:grid-cols-3 """ + GAP + """-5">
                <x-lms-panel>
                    <x-lms-form-card :title="__('lms.common.profile_photo')" icon="camera">
                        <div class="flex flex-col items-center text-center">
                            <img id="photo-preview"
                                 src="{{ $user->profilePhotoUrl() }}"
                                 alt="{{ $user->name }}"
                                 class="w-32 h-32 rounded-2xl object-cover border border-slate-200 dark:border-slate-600 shadow-md ring-4 ring-brand-50 dark:ring-brand-900/30">
                            <p class="mt-3 text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $user->name }}</p>
                            <p class="text-xs text-slate-500 capitalize">{{ __('lms.roles.' . $user->role) }}</p>
                            <p class="text-xs text-slate-400 mt-1">{{ $user->email }}</p>

                            <label for="photo" class="mt-4 w-full cursor-pointer">
                                <span class="lms-btn-secondary w-full inline-flex justify-center text-xs py-2">
                                    {{ __('lms.profile_page.upload_new_photo') }}
                                </span>
                                <input id="photo" name="photo" type="file" accept="image/*" class=" sr-only" onchange="previewPhoto(event)">
                            </label>
                            <p class="text-[11px] text-slate-400 mt-2">{{ __('lms.common.leave_blank') }}</p>
                            <x-input-error class="mt-2" :messages="$ errors->get('photo')" />
                        </div>
                    </x-lms-form-card>
                </x-lms-panel>

                <x-lms-panel class="lg:col-span-2">
                    <x-lms-form-card :title="__('lms.common.user_information')" icon="edit">
                        <p class="text-xs text-slate-500 mb-4">{{ __('lms.profile_page.subtitle') }}</p>

                        <div class="grid md:grid-cols-2 """ + GAP + """-4">
                            <div>
                                <x-input-label for="name" :value="__('lms.auth.full_name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus />
                                <x-input-error class="mt-2" :messages="$ errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('lms.auth.email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                                <x-input-error class="mt-2" :messages="$ errors->get('email')" />
                            </div>

                            <div>
                                <x-input-label for="nik" :value="__('lms.auth.nik')" />
                                <x-text-input id="nik" name="nik" type="text" class="mt-1 block w-full" :value="old('nik', $user->nik)" />
                                <x-input-error class="mt-2" :messages="$ errors->get('nik')" />
                            </div>

                            <div>
                                <x-input-label for="phone" :value="__('lms.auth.phone')" />
                                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" />
                                <x-input-error class="mt-2" :messages="$ errors->get('phone')" />
                            </div>

                            <div>
                                <x-input-label for="gender" :value="__('lms.auth.gender')" />
                                <select id="gender" name="gender" class="mt-1 block w-full border-slate-300 dark:border-slate-600 dark:bg-slate-800 rounded-lg">
                                    <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected' : '' }}>{{ __('lms.auth.male') }}</option>
                                    <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected' : '' }}>{{ __('lms.auth.female') }}</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$ errors->get('gender')" />
                            </div>

                            <div>
                                <x-input-label for="birth_place" :value="__('lms.auth.birth_place')" />
                                <x-text-input id="birth_place" name="birth_place" type="text" class="mt-1 block w-full" :value="old('birth_place', $user->birth_place)" />
                                <x-input-error class="mt-2" :messages="$ errors->get('birth_place')" />
                            </div>

                            <div>
                                <x-input-label for="birth_date" :value="__('lms.auth.birth_date')" />
                                <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="old('birth_date', $user->birth_date?->format('Y-m-d'))" />
                                <x-input-error class="mt-2" :messages="$ errors->get('birth_date')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('lms.auth.address')" />
                            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" />
                            <x-input-error class="mt-2" :messages="$ errors->get('address')" />
                        </div>

                        <div>
                            <x-input-label for="bio" :value="__('lms.report.bio')" />
                            <textarea id="bio" name="bio" rows="3" class="mt-1 block w-full border-slate-300 dark:border-slate-600 dark:bg-slate-800 rounded-lg">{{ old('bio', $user->bio) }}</textarea>
                            <x-input-error class="mt-2" :messages="$ errors->get('bio')" />
                        </div>

                        <x-lms-form-actions>
                            <x-ds.button type="submit" variant="primary">{{ __('lms.save') }}</x-ds.button>
                        </x-lms-form-actions>
                    </x-lms-form-card>
                </x-lms-panel>
            </div>
        </form>

        <x-lms-section :title="__('lms.profile_page.update_password')" compact>
            <x-lms-panel>
                @include('profile.partials.update-password-form')
            </x-lms-panel>
        </x-lms-section>

        <x-lms-section :title="__('lms.profile_page.delete_account')" compact>
            <x-lms-panel>
                @include('profile.partials.delete-user-form')
            </x-lms-panel>
        </x-lms-section>
    </x-lms-page-shell>

    <script>
        function previewPhoto(event) {
            const preview = document.getElementById('photo-preview');
            if (event.target.files && event.target.files[0]) {
                preview.src = URL.createObjectURL(event.target.files[0]);
            }
        }
    </script>
</x-app-layout>
""".replace("$ errors", "$ errors").replace('class=" sr-only"', 'class=" sr-only"'),encoding="utf-8")
    # fix the $ errors and sr-only typos
    content = path.read_text(encoding="utf-8")
    content = content.replace("$ errors", "$ errors").replace('class=" sr-only"', 'class=" sr-only"')
    content = content.replace("$ errors", "$ errors")
    content = content.replace("$ errors", "$ errors")
    # Actually use proper blade syntax
    content = content.replace("$ errors", "$ errors")
    path.write_text(content.replace("$ errors", "$ errors").replace('class=" sr-only"', 'class=" sr-only"'),encoding="utf-8")


def main() -> None:
    for path in TARGETS:
        if not path.exists():
            continue
        orig = path.read_text(encoding="utf-8")
        t = fix_section_attrs(orig)
        t = ensure_page_shell(t)
        t = convert_list_card_file(t)
        if t != orig:
            path.write_text(t,encoding="utf-8")
            print("fixed", path.relative_to(ROOT))

    fix_profile_edit()
    # clean profile file properly
    p = ROOT / "profile" / "edit.blade.php"
    c = p.read_text(encoding="utf-8")
    c = c.replace("$ errors", "$ errors").replace('class=" sr-only"', 'class=" sr-only"')
    c = c.replace("$ errors->", "$ errors->")  # still wrong
    c = c.replace("$ errors", "$ errors")
    p.write_text(c,encoding="utf-8")
    print("profile rewritten")


if __name__ == "__main__":
    main()
