"""Compare generated PESERTA 2 layout vs reference."""
import fitz
from pathlib import Path

PT = 25.4 / 72.0
REF = Path(r"C:/Users/Sya'ban/Downloads/RAIHAN TAUVIQUL HADY IFDAL.pdf")
GEN = Path(r"D:/PROJECT-KP/lms_blkk/storage/app/test-cert-peserta2.pdf")

KEYS = [
    "SERTIFIKAT INI", "This Certificate", "yang diselenggarakan",
    "Kementerian", "Telah Berpartisipasi", "Tahun 2027",
    "Organized by", "Serta berhak", "As well as", "C.DS",
    "Sertifikat ini berlaku", "This Certificate is valid",
    "Diverifikasi", "Zaid Ahmad", "Certified Number", "Issued Date",
]


def lines(path):
    doc = fitz.open(path)
    out = []
    for block in doc[0].get_text("dict")["blocks"]:
        if block.get("type") != 0:
            continue
        for line in block["lines"]:
            txt = "".join(s["text"] for s in line["spans"]).strip()
            if not txt:
                continue
            b = line["bbox"]
            out.append({"y": b[1] * PT, "x": b[0] * PT, "t": txt})
    doc.close()
    return out


def pick(lines, needle):
    for ln in lines:
        if needle.lower() in ln["t"].lower():
            return ln
    return None


ref = lines(REF)
gen = lines(GEN)

print("=== PESERTA 2 LAYOUT vs REF ===")
for k in KEYS:
    r, g = pick(ref, k), pick(gen, k)
    if r and g:
        print(f"{k:28} dY={g['y'] - r['y']:+5.2f} dX={g['x'] - r['x']:+5.2f}")
    elif r and not g:
        print(f"{k:28} MISSING (ref y={r['y']:.1f})")
    elif g and not r:
        print(f"{k:28} EXTRA y={g['y']:.1f} x={g['x']:.1f} | {g['t'][:50]}")

print("\n=== GEN program block ===")
for ln in sorted(gen, key=lambda l: l["y"]):
    if 75 < ln["y"] < 100:
        print(f"  y={ln['y']:6.2f} x={ln['x']:6.2f} | {ln['t']}")
