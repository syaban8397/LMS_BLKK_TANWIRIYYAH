"""Extract key x/y positions from two PDFs side by side."""
import fitz
from pathlib import Path

PT = 25.4 / 72.0
REF = Path(r"C:\Users\Sya'ban\Downloads\RAIHAN TAUVIQUL HADY IFDAL.pdf")
GEN = Path(r"C:\Users\Sya'ban\Downloads\PESERTA 2.pdf")

KEYS = [
    "SERTIFIKAT INI",
    "This Certificate",
    "yang diselenggarakan",
    "Kementerian",
    "Telah Berpartisipasi",
    "Organized by",
    "Serta berhak",
    "C.DM",
    "C.DS",
    "Diverifikasi",
    "Zaid Ahmad",
    "Certified Number",
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
                        "sz": line["spans"][0]["size"],
                        "t": txt,
                    }
                )
    doc.close()
    return out


def pick(lines, needle):
    for ln in lines:
        if needle.lower() in ln["t"].lower():
            return ln
    return None


ref_lines = lines(REF)
gen_lines = lines(GEN)

print("PAGE 1 alignment (REF vs GEN)")
for k in KEYS[:12]:
    r = pick(ref_lines, k)
    g = pick(gen_lines, k)
    if r and g and r["page"] == 1 and g["page"] == 1:
        print(
            f"{k:22} REF y={r['y']:5.1f} x={r['x']:5.1f} sz={r['sz']:4.1f} | "
            f"GEN y={g['y']:5.1f} x={g['x']:5.1f} sz={g['sz']:4.1f} | "
            f"dY={g['y']-r['y']:+5.1f} dX={g['x']-r['x']:+5.1f}"
        )

print("\nPAGE 2 table header")
for k in KEYS[12:]:
    r = pick(ref_lines, k)
    g = pick(gen_lines, k)
    if r and g:
        print(
            f"{k:22} REF y={r['y']:5.1f} x={r['x']:5.1f} sz={r['sz']:4.1f} | "
            f"GEN y={g['y']:5.1f} x={g['x']:5.1f} sz={g['sz']:4.1f} | "
            f"dY={g['y']-r['y']:+5.1f} dX={g['x']-r['x']:+5.1f}"
        )

print("\nGEN program/org lines:")
for ln in gen_lines:
    if ln["page"] == 1 and any(
        x in ln["t"]
        for x in ["Telah", "Skema", "yang diselenggarakan", "Organized", "degree", "Gelar"]
    ):
        print(f"  y={ln['y']:5.1f} x={ln['x']:5.1f} | {ln['t'][:90]}")
