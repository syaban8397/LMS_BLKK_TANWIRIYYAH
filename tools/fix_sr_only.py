from pathlib import Path
p = Path(__file__).resolve().parents[1] / "resources/views/profile/edit.blade.php"
t = p.read_text(encoding="utf-8")
t = t.replace('class="' + ' sr-only"', 'class=" sr-only"')
p.write_text(t,encoding="utf-8")
print("done")
