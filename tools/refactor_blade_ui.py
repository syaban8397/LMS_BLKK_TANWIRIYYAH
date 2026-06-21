#!/usr/bin/env python3
"""Apply enterprise UI shell/panel transforms to blade views."""
from __future__ import annotations

import re
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1] / "resources" / "views"
GAP = "ga" + "p"

APP_FILES = [
    "instruktur/classes/index.blade.php",
    "instruktur/classes/stream.blade.php",
    "instruktur/classes/add-student.blade.php",
    "instruktur/attendances/index.blade.php",
    "instruktur/attendances/create.blade.php",
    "instruktur/attendances/edit.blade.php",
    "instruktur/attendances/show.blade.php",
    "instruktur/attendances/report.blade.php",
    "instruktur/materials/index.blade.php",
    "instruktur/materials/show.blade.php",
    "instruktur/materials/create.blade.php",
    "instruktur/materials/edit.blade.php",
    "instruktur/assignments/create.blade.php",
    "instruktur/assignments/edit.blade.php",
    "instruktur/grades/index.blade.php",
    "instruktur/grades/show.blade.php",
    "instruktur/certificates/index.blade.php",
    "peserta/classes/index.blade.php",
    "peserta/classes/stream.blade.php",
    "peserta/classes/show.blade.php",
    "peserta/materials/index.blade.php",
    "peserta/materials/show.blade.php",
    "peserta/assignments/index.blade.php",
    "peserta/assignments/show.blade.php",
    "peserta/attendances/index.blade.php",
    "peserta/attendances/show.blade.php",
    "peserta/submissions/create.blade.php",
    "peserta/submissions/edit.blade.php",
    "peserta/certificates/index.blade.php",
    "profile/edit.blade.php",
]


def fix_cyrillic(text: str) -> str:
    return text.replace("ga\u0440", "ga" + "p").replace("ga\u0440", GAP)


def convert_shell(text: str) -> str:
    if not text.strip().startswith("<x-app-layout>"):
        return text

    extra = ""
    m = re.search(
        r'<div[^>]*class="([^"]*(?:lms-module-shell|lms-page-shell)[^"]*)"',
        text,
    )
    if m:
        classes = m.group(1).split()
        keep = [
            c
            for c in classes
            if c
            not in (
                "lms-module-shell",
                "lms-page-shell",
                "space-y-6",
                "space-y-5",
            )
        ]
        extra = " ".join(keep)

    # strip wrapper div after x-app-layout
    text = re.sub(
        r"(<x-app-layout>\s*)<div[^>]*(?:lms-module-shell|lms-page-shell)[^>]*>\s*",
        r"\1",
        text,
        count=1,
    )
    text = re.sub(
        r"\s*</div>(\s*(?:<script>.*?</script>\s*)?)(</x-app-layout>)",
        r"\1\2",
        text,
        count=1,
        flags=re.DOTALL,
    )

    if "<x-lms-page-shell" not in text:
        cls_attr = f' class="{extra}"' if extra else ""
        text = text.replace(
            "<x-app-layout>",
            f"<x-app-layout>\n    <x-lms-page-shell{cls_attr}>",
            1,
        )
        text = text.replace("</x-app-layout>", "    </x-lms-page-shell>\n</x-app-layout>", 1)

    return text


def wrap_stat_grid(text: str) -> str:
    if re.search(r"<x-lms-panel[^>]*>\s*<x-lms-stat-grid", text):
        return text

    def repl(match: re.Match[str]) -> str:
        block = match.group(0)
        if "x-lms-section" in text[max(0, match.start() - 300) : match.start()]:
            return block
        return (
            "        <x-lms-section :title=\"__('lms.dashboard.overview')\" icon=\"chart\" compact>\n"
            "            <x-lms-panel flush pad=\"false\">\n"
            f"{block}\n"
            "            </x-lms-panel>\n"
            "        </x-lms-section>"
        )

    return re.sub(
        r"        <x-lms-stat-grid(?:[^>]*)?>.*?</x-lms-stat-grid>",
        repl,
        text,
        count=1,
        flags=re.DOTALL,
    )


def convert_lms_card(text: str) -> str:
    return re.sub(
        r"        <x-lms-card class=\"[^\"]*\" :title=\"([^\"]+)\" :meta=\"([^\"]+)\">\s*"
        r"(<x-lms-data-table.*?</x-lms-data-table>)\s*"
        r"        </x-lms-card>",
        r"        <x-lms-section :title=\1 :description=\2 icon=\"clipboard\" compact>\n            \3\n        </x-lms-section>",
        text,
        flags=re.DOTALL,
    )


def convert_cards_to_panel(text: str) -> str:
    subs = [
        (r'<div class="sidebar-card dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200">', "<x-lms-panel>"),
        (r'<div class="sidebar-card bg-white rounded-xl p-5 shadow-md border border-slate-200">', "<x-lms-panel>"),
        (r'<div class="form-card dashboard-card bg-white rounded-xl p-5 shadow-md border border-slate-200">', "<x-lms-panel>"),
        (r'<div class="stats-card bg-white rounded-xl p-5 shadow-md border border-slate-200">', "<x-lms-panel>"),
        (r'<div class="dashboard-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">', '<x-lms-panel flush pad="false">'),
        (r'<div class="info-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">', "<x-lms-panel>"),
        (r'<div class="detail-card bg-white rounded-lg shadow-md border border-slate-200 overflow-hidden[^"]*">', "<x-lms-panel>"),
        (r'<div class="detail-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">', "<x-lms-panel>"),
        (r'<div class="submission-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden[^"]*">', "<x-lms-panel>"),
        (r'<div class="attendance-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">', "<x-lms-panel>"),
        (r'<div class="report-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">', '<x-lms-panel flush pad="false">'),
        (r'<div class="table-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">', '<x-lms-panel flush pad="false">'),
        (r'<div class="grade-card bg-white rounded-lg shadow-md border border-slate-200 overflow-hidden">', "<x-lms-panel>"),
        (r'<div class="info-card bg-white rounded-lg shadow-md border border-slate-200 overflow-hidden">', "<x-lms-panel>"),
        (r'<div class="file-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">', "<x-lms-panel>"),
        (r'<div class="video-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">', "<x-lms-panel>"),
        (r'<div class="warning-card bg-white rounded-xl shadow-md border border-slate-200 p-6 text-center">', '<x-lms-panel class="text-center">'),
        (r'<div class="announcement-card bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">', "<x-lms-panel>"),
        (r'<div class="premium-card p-6 sm:p-8">', "<x-lms-panel>"),
        (r'<div class="premium-card p-5 flex flex-wrap items-center justify-between ' + GAP + r'-4">', f'<x-lms-panel class="flex flex-wrap items-center justify-between {GAP}-4">'),
        (r'<div class="card-3d">', "<x-lms-panel>"),
        (r'<div class="lg:col-span-2 card-3d">', '<x-lms-panel class="lg:col-span-2">'),
    ]
    for pat, rep in subs:
        text = re.sub(pat, rep, text)
    return text


def convert_quick_cards(text: str) -> str:
    text = re.sub(
        r'<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 ' + GAP + r'-4">\s*',
        f'<x-lms-panel><div class="lms-quick-grid">\n',
        text,
    )
    text = re.sub(
        r'<a href="([^"]+)" class="quick-card[^"]*">',
        r'<a href="\1" class="lms-quick-link">',
        text,
    )
    text = re.sub(
        r'</a>\s*</div>\s*\n\s*<div class="announcement-card',
        '</a>\n        </div></x-lms-panel>\n\n        <x-lms-section :title="__(' + "'lms.common.latest_from_instructor'" + ')" icon="megaphone" compact>\n        <x-lms-panel',
        text,
        count=1,
    )
    return text


def convert_stream_actions(text: str) -> str:
    text = re.sub(
        r'<div class="space-y-1">\s*((?:<a[^>]*class="lms-stream-action"[^>]*>.*?</a>\s*)+)</div>',
        lambda m: '<div class="lms-quick-grid">\n'
        + m.group(1).replace("lms-stream-action", "lms-quick-link")
        + "\n                        </div>",
        text,
        flags=re.DOTALL,
    )
    text = re.sub(
        r'<div class="grid grid-cols-3 ' + GAP + r'-4">\s*((?:<a[^>]*class="lms-stream-action"[^>]*>.*?</a>\s*)+)</div>',
        lambda m: f'<div class="lms-quick-grid lms-quick-grid--3">\n{m.group(1).replace("lms-stream-action", "lms-quick-link")}\n                </div>',
        text,
        flags=re.DOTALL,
    )
    return text


def wrap_form_layout(text: str) -> str:
    if "lms-form-layout" in text:
        return text
    return re.sub(
        r"(        <x-lms-form-card(?:[^>]*)>.*?</x-lms-form-card>)",
        r"        <x-lms-section compact>\n            <div class=\"lms-form-layout lms-form-layout--wide\">\n\1\n            </div>\n        </x-lms-section>",
        text,
        count=1,
        flags=re.DOTALL,
    )


def wrap_summary_stats(text: str) -> str:
    pat = (
        r'        <div class="grid grid-cols-2 md:grid-cols-4 ' + GAP + r'-4">\s*'
        r'(<div class="summary-card[^"]*">.*?</div>\s*){4}\s*</div>'
    )
    m = re.search(pat, text, flags=re.DOTALL)
    if not m:
        return text
    block = m.group(0)
    wrapped = (
        "        <x-lms-section :title=\"__('lms.common.statistics')\" icon=\"chart\" compact>\n"
        "            <x-lms-panel flush pad=\"false\">\n"
        "                <x-lms-stat-grid class=\"lms-stat-grid--4\">\n"
        "                    <x-lms-stat-card :label=\"__('lms.report.present')\" :value=\"$summary['present']\" icon=\"check-circle\" tone=\"green\" />\n"
        "                    <x-lms-stat-card :label=\"__('lms.report.permission')\" :value=\"$summary['permission']\" icon=\"clock\" tone=\"amber\" />\n"
        "                    <x-lms-stat-card :label=\"__('lms.report.sick')\" :value=\"$summary['sick']\" icon=\"document\" tone=\"indigo\" />\n"
        "                    <x-lms-stat-card :label=\"__('lms.report.absent')\" :value=\"$summary['absent']\" icon=\"x-circle\" tone=\"blue\" />\n"
        "                </x-lms-stat-grid>\n"
        "            </x-lms-panel>\n"
        "        </x-lms-section>"
    )
    return text.replace(block, wrapped)


def convert_list_card(text: str) -> str:
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
        ei = eicon.group(1) if eicon else "inbox"
        et = etitle.group(1) if etitle else "__('lms.no_data')"
        ed = edesc.group(1) if edesc else None

        body = re.sub(r'<div class="(?:material-row|assignment-row)[^"]*">\s*<div class="flex[^"]*">', '<div class="lms-list-item">\n                        <div class="min-w-0 flex-1">', body)
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
            f"        <x-lms-section :title={t} :description={md} icon=\"book\" compact>\n"
            f"            <x-lms-panel>\n{body.strip()}\n            </x-lms-panel>\n"
            f"            <x-lms-pagination :paginator=\"{pg}\" />\n"
            f"        </x-lms-section>\n"
            f"        @else\n"
            f"        <x-lms-section :title={t} compact>\n"
            f"            <x-lms-panel>\n"
            f"                <x-lms-empty-state icon=\"{ei}\" :title={et}"
        )
        if ed:
            out += f" :description={ed}"
        out += ">\n"
        if empty_actions:
            out += f"                    <x-slot:actions>\n                        {empty_actions}\n                    </x-slot:actions>\n"
        out += "                </x-lms-empty-state>\n            </x-lms-panel>\n        </x-lms-section>\n        @endif"
        return out

    return pattern.sub(build, text)


def convert_profile_partials(text: str) -> str:
    return text  # handled in edit


def process(path: Path) -> bool:
    orig = path.read_text(encoding="utf-8")
    t = orig
    t = fix_cyrillic(t)
    t = convert_shell(t)
    t = wrap_stat_grid(t)
    t = convert_lms_card(t)
    t = convert_list_card(t)
    t = convert_cards_to_panel(t)
    t = convert_quick_cards(t)
    t = convert_stream_actions(t)
    t = wrap_summary_stats(t)
    if "form-card" in path.name or "create" in path.name or "edit" in path.name:
        t = wrap_form_layout(t)
    t = fix_cyrillic(t)
    if t != orig:
        path.write_text(t,encoding="utf-8")
        return True
    return False


def process_verify(path: Path) -> bool:
    orig = path.read_text(encoding="utf-8")
    t = orig
    if "x-lms-public-shell" in t:
        return False
    body = re.search(r"<body[^>]*>(.*)</body>", t, re.DOTALL)
    if not body:
        return False
    inner = body.group(1).strip()
    new_body = f'<body class="lms-verify-body antialiased">\n<x-lms-public-shell centered>\n{inner}\n</x-lms-public-shell>\n</body>'
    t = re.sub(r"<body[^>]*>.*</body>", new_body, t, flags=re.DOTALL)
    if t != orig:
        path.write_text(t,encoding="utf-8")
        return True
    return False


def process_profile_edit(path: Path) -> bool:
    orig = path.read_text(encoding="utf-8")
    t = convert_shell(orig)
    t = t.replace('<div class="lms-page-shell max-w-5xl mx-auto space-y-6">', "")
    t = t.replace('<div class="grid lg:grid-cols-3 ' + GAP + '-5">', "")
    t = t.replace('<div class="lg:col-span-2 card-3d">', "")
    t = re.sub(r"        </div>\s*</form>", "        </div>\n        </x-lms-section>\n        </form>", t, count=1)
    if "<x-lms-page-shell" not in t:
        t = t.replace("<x-app-layout>", '<x-app-layout>\n    <x-lms-page-shell class="max-w-5xl mx-auto">', 1)
        t = t.replace("</x-app-layout>", "    </x-lms-page-shell>\n</x-app-layout>", 1)
    t = t.replace(
        '        <div class="premium-card p-6 sm:p-8">',
        '        <x-lms-section compact>\n            <x-lms-panel>',
    )
    t = t.replace(
        "        </div>\n\n        <div class=\"premium-card",
        "        </x-lms-panel>\n        </x-lms-section>\n\n        <x-lms-section compact>\n            <x-lms-panel",
    )
    t = fix_cyrillic(t)
    if t != orig:
        path.write_text(t,encoding="utf-8")
        return True
    return False


def main() -> None:
    changed = []
    for rel in APP_FILES:
        p = ROOT / rel
        if not p.exists():
            print("MISSING", rel)
            continue
        fn = process_profile_edit if rel == "profile/edit.blade.php" else process
        if fn(p):
            changed.append(rel)
            print("OK", rel)

    for rel in ["certificates/verify.blade.php", "certificates/verify-invalid.blade.php"]:
        p = ROOT / rel
        if p.exists() and process_verify(p):
            changed.append(rel)
            print("OK", rel)

    # fix stream typos if present
    stream = ROOT / "instruktur/classes/stream.blade.php"
    if stream.exists():
        t = stream.read_text(encoding="utf-8")
        t2 = t.replace("lms.common post_", "lms.common.").replace("ga\u0440", GAP)
        if t2 != t:
            stream.write_text(t2,encoding="utf-8")
            print("FIX stream")

    print("changed:", len(changed))


if __name__ == "__main__":
    main()
