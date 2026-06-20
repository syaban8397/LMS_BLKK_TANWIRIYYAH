"""Compare PESERTA 1.pdf (generated) vs RAIHAN reference."""
import fitz
from pathlib import Path

PT = 25.4 / 72.0
REF = Path(r"C:/Users/Sya'ban/Downloads/RAIHAN TAUVIQUL HADY IFDAL.pdf")
GEN = Path(r"C:/Users/Sya'ban/Downloads/PESERTA 1.pdf")

KEYS = [
    "SERTIFIKAT INI",
    "This Certificate",
    "yang diselenggarakan",
    "BLKK Tanwiriyyah",
    "Kementerian",
    "Telah Berpartisipasi",
    "Skema",
    "Organized by",
    "Serta berhak",
    "As well as",
    "C.DM",
    "C.DS",
    "Sertifikat ini berlaku",
    "This Certificate is valid",
    "Diverifikasi",
    "Zaid Ahmad",
    "Direktur",
    "Certified Number",
    "Issued Date",
    "NO",
    "MATERI PELATIHAN",
    "KODE UNIT",
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
                out.append(
                    {
                        "page": pi + 1,
                        "y": line["bbox"][1] * PT,
                        "x": line["bbox"][0] * PT,
                        "x1": line["bbox"][2] * PT,
                        "sz": line["spans"][0]["size"],
                        "t": txt,
                    }
                )
    doc.close()
    return out


def imgs(path):
    doc = fitz.open(path)
    out = []
    for pi in range(min(2, doc.page_count)):
        for block in doc[pi].get_text("dict")["blocks"]:
            if block.get("type") == 1:
                b = block["bbox"]
                out.append(
                    {
                        "page": pi + 1,
                        "x0": b[0] * PT,
                        "y0": b[1] * PT,
                        "w": (b[2] - b[0]) * PT,
                        "h": (b[3] - b[1]) * PT,
                    }
                )
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
for k in KEYS[:19]:
    r, g = pick(ref, k), pick(gen, k)
    if r and g and r["page"] == 1 and g["page"] == 1:
        print(
            f"{k:28} dY={g['y'] - r['y']:+5.2f} dX={g['x'] - r['x']:+5.2f} "
            f"REF(x={r['x']:.1f},y={r['y']:.1f},sz={r['sz']:.1f}) "
            f"GEN(x={g['x']:.1f},y={g['y']:.1f},sz={g['sz']:.1f})"
        )
    elif r and not g:
        print(f"{k:28} MISSING IN GEN")
    elif g and not r:
        print(f"{k:28} EXTRA IN GEN: {g['t'][:60]}")

print("\n=== PAGE 2 ===")
for k in KEYS[19:]:
    r, g = pick(ref, k), pick(gen, k)
    if r and g:
        print(
            f"{k:28} dY={g['y'] - r['y']:+5.2f} dX={g['x'] - r['x']:+5.2f} "
            f"REF(x={r['x']:.1f},y={r['y']:.1f}) GEN(x={g['x']:.1f},y={g['y']:.1f})"
        )

print("\n=== PAGE 1 IMAGES (sorted by y,x) ===")
ri = sorted([x for x in imgs(REF) if x["page"] == 1], key=lambda i: (i["y0"], i["x0"]))
gi = sorted([x for x in imgs(GEN) if x["page"] == 1], key=lambda i: (i["y0"], i["x0"]))
for i in range(max(len(ri), len(gi))):
    r = ri[i] if i < len(ri) else None
    g = gi[i] if i < len(gi) else None
    if r and g:
        print(
            f"img{i} dX={g['x0']-r['x0']:+5.2f} dY={g['y0']-r['y0']:+5.2f} "
            f"dW={g['w']-r['w']:+5.2f} dH={g['h']-r['h']:+5.2f}"
        )
    elif r:
        print(f"img{i} missing in GEN")
    else:
        print(f"img{i} extra in GEN")

print("\n=== GEN org/name lines detail ===")
for ln in gen:
    if ln["page"] == 1 and ln["y"] > 45 and ln["y"] < 100:
        print(f"  y={ln['y']:5.1f} x={ln['x']:5.1f} x1={ln['x1']:5.1f} sz={ln['sz']:.1f} | {ln['t'][:80]}")

print("\n=== REF org/name lines detail ===")
for ln in ref:
    if ln["page"] == 1 and ln["y"] > 45 and ln["y"] < 100:
        print(f"  y={ln['y']:5.1f} x={ln['x']:5.1f} x1={ln['x1']:5.1f} sz={ln['sz']:.1f} | {ln['t'][:80]}")
