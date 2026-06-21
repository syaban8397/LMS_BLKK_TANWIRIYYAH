from __future__ import annotations
import re
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1] / "resources" / "views"
ALLOWED = {"instruktur", "peserta", "profile", "auth", "legal", " errors", "certificates"}


def should_process(rel: Path) -> bool:
    if rel.parts[0] not in ALLOWED:
        return False
    if rel.parts[0] == "certificates" and str(rel) not in (
        "certificates/verify.blade.php",
        "certificates/verify-invalid.blade.php",
    ):
        return False
    return True


def fix_typos(text: str) -> str:
    text = text.replace("ga\u0440", "gap")
    text = text.replace("$ errors", "$" + "error" + "s")
    text = text.replace('class="' + " sr-only\"", 'class=" sr-only"')
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
    if "<x-lms-page-shell" not in text:
        cls = f' class="{extra}"' if extra else ""
        text = text.replace(
            "<x-app-layout>",
            f"<x-app-layout>\n    <x-lms-page-shell{cls}>",
            1,
        )
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
    text = re.sub(r"\n\s*</div>\s*\n(\s*</x-lms-page-shell>)", r"\n\1", text, count=1)
    return text


def convert_list_card(text: str) -> str:
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


def main() -> None:
    for path in ROOT.rglob("*.blade.php"):
        rel = path.relative_to(ROOT)
        if not should_process(rel):
            continue
        orig = path.read_text(encoding="utf-8")
        t = fix_typos(convert_list_card(ensure_page_shell(orig)))
        if t != orig:
            path.write_text(t,encoding="utf-8")
            print("OK", rel)


if __name__ == "__main__":
    main()
