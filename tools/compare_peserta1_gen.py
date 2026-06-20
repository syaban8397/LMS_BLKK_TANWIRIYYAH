"""Compare generated PESERTA 1 vs reference."""
import fitz
from pathlib import Path

PT = 25.4 / 72.0
REF = Path(r"C:/Users/Sya'ban/Downloads/RAIHAN TAUVIQUL HADY IFDAL.pdf")
GEN = Path(r"D:/PROJECT-KP/lms_blkk/storage/app/test-cert-peserta1.pdf")

KEYS = [
    "SERTIFIKAT INI", "This Certificate", "PESERTA", "yang diselenggarakan",
    "Kementerian", "Telah Berpartisipasi", "Tahun 2027", "Organized by",
    "Serta berhak", "C.DS", "Diverifikasi", "Zaid Ahmad", "Certified Number",
    "Indonesia", "Skills", "SERTIFIKAT", "CERTIFICATE OF TRAINING",
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
            out.append({"y": b[1] * PT, "x": b[0] * PT, "x1": b[2] * PT, "t": txt})
    doc.close()
    return out


def pick(lines, needle):
    for ln in lines:
        if needle.lower() in ln["t"].lower():
            return ln
    return None


ref = lines(REF)
gen = lines(GEN)

print("=== PESERTA 1 vs REF ===")
for k in KEYS:
    r, g = pick(ref, k), pick(gen, k)
    if r and g:
        cx_r = (r["x"] + r["x1"]) / 2
        cx_g = (g["x"] + g["x1"]) / 2
        print(f"{k:28} dY={g['y']-r['y']:+5.2f} dX={g['x']-r['x']:+5.2f} dCX={cx_g-cx_r:+5.2f}")
    elif r and not g:
        print(f"{k:28} MISSING IN GEN")
    elif g and not r:
        print(f"{k:28} EXTRA | y={g['y']:.1f} x={g['x']:.1f} | {g['t'][:40]}")

r_name = pick(ref, "RAIHAN")
g_name = pick(gen, "PESERTA")
if r_name and g_name:
    print(f"\nName center REF cx={(r_name['x']+r_name['x1'])/2:.1f} GEN cx={(g_name['x']+g_name['x1'])/2:.1f}")

print("\n=== GEN sidebar/logo text ===")
for ln in sorted(gen, key=lambda l: l["y"]):
    if ln["x"] < 55 or (200 < ln["x"] < 220 and ln["y"] < 30):
        print(f"  y={ln['y']:6.2f} x={ln['x']:6.2f} | {ln['t'][:50]}")

print("\n=== IMAGES GEN ===")
doc = fitz.open(GEN)
for block in doc[0].get_text("dict")["blocks"]:
    if block.get("type") == 1:
        b = block["bbox"]
        print(f"  x0={b[0]*PT:.1f} y0={b[1]*PT:.1f} w={(b[2]-b[0])*PT:.1f}x{(b[3]-b[1])*PT:.1f}")
doc.close()
