"""Extract reference fonts with stable filenames (keep largest per role)."""
import fitz
from pathlib import Path

REF = Path(r"C:/Users/Sya'ban/Downloads/RAIHAN TAUVIQUL HADY IFDAL.pdf")
OUT = Path(r"D:/PROJECT-KP/lms_blkk/storage/fonts/certificates")
OUT.mkdir(parents=True, exist_ok=True)

ROLE_MAP = {
    "Montserrat-Bold": "Montserrat-Bold.ttf",
    "Montserrat-BoldItalic": "Montserrat-BoldItalic.ttf",
    "Montserrat-Black": "Montserrat-Black.ttf",
    "Montserrat-Italic": "Montserrat-Italic.ttf",
    "Montserrat-Regular": "Montserrat-Regular.ttf",
}

doc = fitz.open(REF)
best = {}
for pi in range(doc.page_count):
    for f in doc[pi].get_fonts(full=True):
        xref = f[0]
        try:
            basename, ext, typ, content = doc.extract_font(xref)
        except Exception:
            continue
        if not content:
            continue
        for key, dest_name in ROLE_MAP.items():
            if key in basename:
                cur = best.get(key)
                if cur is None or len(content) > cur[1]:
                    best[key] = (content, len(content), dest_name)

for key, (content, size, dest_name) in best.items():
    path = OUT / dest_name
    path.write_bytes(content)
    print(f"{dest_name}: {size} bytes")

doc.close()
