from pathlib import Path

for rel in [
    "profile/partials/delete-user-form.blade.php",
    "profile/partials/update-password-form.blade.php",
]:
    p = Path(__file__).resolve().parents[1] / "resources/views" / rel
    t = p.read_text(encoding="utf-8")
    t = t.replace("$ errors", "$" + "error" + "s")
    t = t.replace('class="' + " sr-only\"", 'class="hidden"')
    p.write_text(t,encoding="utf-8")
    print("fixed", rel)
