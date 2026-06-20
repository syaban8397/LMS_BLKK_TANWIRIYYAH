"""Compare PESERTA 1.pdf vs RAIHAN reference - full page 1 analysis."""
import fitz
from pathlib import Path

PT = 25.4 / 72.0
REF = Path(r"C:/Users/Sya'ban/Downloads/RAIHAN TAUVIQUL HADY IFDAL.pdf")
GEN = Path(r"C:/Users/Sya'ban/Downloads/PESERTA 1.pdf")

KEYS = [
    "SERTIFIKAT INI", "This Certificate", "yang diselenggarakan",
    "Kementerian", "Telah Berpartisipasi", "Tahun", "Skema",
    "Organized by", "Serta berhak", "As well as", "C.DM", "C.DS",
    "Sertifikat ini berlaku", "This Certificate is valid",
    "Diverifikasi", "Zaid Ahmad", "Direktur", "BLKK Tanwiriyyah",
    "Certified Number", "Issued Date",
]


def page1_lines(path):
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
            out.append({
                "y": b[1] * PT,
                "x": b[0] * PT,
                "x1": b[2] * PT,
                "sz": line["spans"][0]["size"],
                "t": txt,
            })
    doc.close()
    return out


def page1_imgs(path):
    doc = fitz.open(path)
    out = []
    for block in doc[0].get_text("dict")["blocks"]:
        if block.get("type") == 1:
            b = block["bbox"]
            out.append({
                "x0": b[0] * PT,
                "y0": b[1] * PT,
                "w": (b[2] - b[0]) * PT,
                "h": (b[3] - b[1]) * PT,
            })
    doc.close()
    return sorted(out, key=lambda i: (i["y0"], i["x0"]))


def pick(lines, needle):
    for ln in lines:
        if needle.lower() in ln["t"].lower():
            return ln
    return None


ref = page1_lines(REF)
gen = page1_lines(GEN)

print("=== TEXT POSITION (GEN - REF) ===")
for k in KEYS:
    r, g = pick(ref, k), pick(gen, k)
    if r and g:
        print(
            f"{k:28} dY={g['y']-r['y']:+5.2f} dX={g['x']-r['x']:+5.2f} "
            f"REF(y={r['y']:.1f},x={r['x']:.1f}) GEN(y={g['y']:.1f},x={g['x']:.1f})"
        )
    elif r and not g:
        print(f"{k:28} MISSING IN GEN  ref y={r['y']:.1f}")
    elif g and not r:
        print(f"{k:28} EXTRA IN GEN   gen y={g['y']:.1f} x={g['x']:.1f} | {g['t'][:55]}")

print("\n=== ALL GEN LINES y>=30 ===")
for ln in sorted(gen, key=lambda l: (l["y"], l["x"])):
    if ln["y"] >= 30:
        print(f"  y={ln['y']:6.2f} x={ln['x']:6.2f} x1={ln['x1']:6.2f} sz={ln['sz']:4.1f} | {ln['t'][:70]}")

print("\n=== ALL REF LINES y>=30 ===")
for ln in sorted(ref, key=lambda l: (l["y"], l["x"])):
    if ln["y"] >= 30:
        print(f"  y={ln['y']:6.2f} x={ln['x']:6.2f} x1={ln['x1']:6.2f} sz={ln['sz']:4.1f} | {ln['t'][:70]}")

print("\n=== IMAGES ===")
ri, gi = page1_imgs(REF), page1_imgs(GEN)
print(f"REF count={len(ri)} GEN count={len(gi)}")
for i, im in enumerate(gi):
    print(f"  GEN img{i}: x0={im['x0']:.1f} y0={im['y0']:.1f} {im['w']:.1f}x{im['h']:.1f}")
for i, im in enumerate(ri):
    print(f"  REF img{i}: x0={im['x0']:.1f} y0={im['y0']:.1f} {im['w']:.1f}x{im['h']:.1f}")

# Find QR in GEN (should be ~171.7, 164.4)
qr_ref = next((im for im in ri if im["y0"] > 150), None)
qr_gen = next((im for im in gi if im["y0"] > 150), None)
if qr_ref and qr_gen:
    print(f"\nQR dX={qr_gen['x0']-qr_ref['x0']:+.2f} dY={qr_gen['y0']-qr_ref['y0']:+.2f}")
elif qr_ref and not qr_gen:
    print("\nQR MISSING IN GEN")
elif qr_gen and not qr_ref:
    print(f"\nQR extra/misplaced GEN at {qr_gen['x0']:.1f},{qr_gen['y0']:.1f}")
