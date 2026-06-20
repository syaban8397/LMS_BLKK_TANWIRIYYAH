"""Compare generated test cert vs RAIHAN reference."""
import fitz
from pathlib import Path

PT = 25.4 / 72.0
REF = Path(r"C:/Users/Sya'ban/Downloads/RAIHAN TAUVIQUL HADY IFDAL.pdf")
GEN = Path(r"D:/PROJECT-KP/lms_blkk/storage/app/test-cert-generated.pdf")

KEYS = [
    "SERTIFIKAT INI", "This Certificate", "RAIHAN", "yang diselenggarakan",
    "Kementerian", "Telah Berpartisipasi", "Skema", "Organized by",
    "Serta berhak", "As well as", "C.DM", "Sertifikat ini berlaku",
    "This Certificate is valid", "Diverifikasi", "Zaid Ahmad", "Direktur",
    "Certified Number", "DM2209320301", "Issued Date",
]


def lines(path):
    doc = fitz.open(path)
    out = []
    for pi in range(min(2, doc.page_count)):
        for block in doc[pi].get_text("dict")["blocks"]:
            if block.get("type") != 0:
                continue
            for line in block["lines"]:
                txt = "".join(s["text"] for s in line["spans"]).strip()
                if not txt:
                    continue
                out.append({
                    "page": pi + 1,
                    "y": line["bbox"][1] * PT,
                    "x": line["bbox"][0] * PT,
                    "x1": line["bbox"][2] * PT,
                    "sz": line["spans"][0]["size"],
                    "t": txt,
                })
    doc.close()
    return out


def pick(lines, needle):
    for ln in lines:
        if needle.lower() in ln["t"].lower():
            return ln
    return None


ref = lines(REF)
gen = lines(GEN)

print("=== PAGE 1 TEXT (GEN - REF) ===")
for k in KEYS:
    r, g = pick(ref, k), pick(gen, k)
    if r and g and r["page"] == 1 and g["page"] == 1:
        print(
            f"{k:28} dY={g['y'] - r['y']:+5.2f} dX={g['x'] - r['x']:+5.2f} "
            f"REF(x={r['x']:.1f},y={r['y']:.1f}) GEN(x={g['x']:.1f},y={g['y']:.1f})"
        )
    elif r and not g:
        print(f"{k:28} MISSING IN GEN")
    elif g and not r:
        print(f"{k:28} EXTRA IN GEN: {g['t'][:50]}")

print("\n=== GEN lines y=45-100 ===")
for ln in gen:
    if ln["page"] == 1 and 45 < ln["y"] < 100:
        print(f"  y={ln['y']:5.1f} x={ln['x']:5.1f} x1={ln['x1']:5.1f} | {ln['t'][:75]}")
