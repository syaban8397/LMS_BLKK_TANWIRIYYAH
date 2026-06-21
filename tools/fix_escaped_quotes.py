from pathlib import Path

roots = [
    Path("resources/views/instruktur"),
    Path("resources/views/peserta"),
    Path("resources/views/profile"),
]

for root in roots:
    for p in root.rglob("*.blade.php"):
        t = p.read_text(encoding="utf-8")
        nt = t.replace('class=\\"', 'class="')
        if nt != t:
            p.write_text(nt, encoding="utf-8")
            print("fixed", p)
