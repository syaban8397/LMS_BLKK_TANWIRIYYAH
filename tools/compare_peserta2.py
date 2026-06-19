"""Compare PESERTA 2.pdf vs reference RAIHAN PDF."""
import fitz
from pathlib import Path

REF = Path(r"C:\Users\Sya'ban\Downloads\RAIHAN TAUVIQUL HADY IFDAL.pdf")
GEN = Path(r"C:\Users\Sya'ban\Downloads\PESERTA 2.pdf")
PT_TO_MM = 25.4 / 72.0


def page_info(path, page_idx=0):
    doc = fitz.open(path)
    page = doc[page_idx]
    print(f"\n{'='*60}\nFILE: {path.name}  PAGE {page_idx+1}  {page.rect.width:.0f}x{page.rect.height:.0f}pt\n{'='*60}")
    items = []
    for block in page.get_text("dict")["blocks"]:
        if block.get("type") != 0:
            continue
        for line in block["lines"]:
            for span in line["spans"]:
                t = span["text"].strip()
                if not t:
                    continue
                x0, y0, x1, y1 = span["bbox"]
                items.append((y0, x0, t, round(y0 * PT_TO_MM, 1), round(x0 * PT_TO_MM, 1), round(span.get("size", 0), 1)))
    items.sort(key=lambda x: (round(x[0], 1), x[1]))
    for _, _, t, ymm, xmm, fpt in items:
        print(f"y={ymm:6.1f} x={xmm:6.1f} {fpt:5.1f}pt | {t[:90]}")

    print("\n--- IMAGE BLOCKS ---")
    for block in page.get_text("dict")["blocks"]:
        if block.get("type") == 1:
            x0, y0, x1, y1 = block["bbox"]
            print(f"img y={y0*PT_TO_MM:.1f}-{y1*PT_TO_MM:.1f} x={x0*PT_TO_MM:.1f}-{x1*PT_TO_MM:.1f} w={(x1-x0)*PT_TO_MM:.1f} h={(y1-y0)*PT_TO_MM:.1f}")


for p in [0, 1]:
    if p < fitz.open(GEN).page_count:
        page_info(GEN, p)
    if p < fitz.open(REF).page_count:
        page_info(REF, p)

# Side-by-side key labels page 1
print("\n\n=== DELTA PAGE 1 (PESERTA2 - REF) mm ===")
ref_doc = fitz.open(REF)
gen_doc = fitz.open(GEN)
ref_items = {}
gen_items = {}
for label, doc, store in [("ref", ref_doc, ref_items), ("gen", gen_doc, gen_items)]:
    page = doc[0]
    for block in page.get_text("dict")["blocks"]:
        if block.get("type") != 0:
            continue
        for line in block["lines"]:
            for span in line["spans"]:
                t = span["text"].strip()
                if t:
                    store[t[:80]] = round(span["bbox"][1] * PT_TO_MM, 1)

needles = [
    "SERTIFIKAT INI",
    "This Certificate",
    "yang diselenggarakan",
    "Telah Berpartisipasi",
    "Skema",
    "Organized by",
    "Serta berhak",
    "C.DM",
    "Sertifikat ini berlaku",
    "Diverifikasi",
    "Certified Number",
    "Issued Date",
    "Zaid Ahmad",
    "Direktur",
    "BLKK Tanwiriyyah",
    "Kementerian",
]

for needle in needles:
    rk = next((k for k in ref_items if needle in k), None)
    gk = next((k for k in gen_items if needle in k), None)
    if rk and gk:
        d = gen_items[gk] - ref_items[rk]
        print(f"{needle:28} ref={ref_items[rk]:6.1f} gen={gen_items[gk]:6.1f} delta={d:+.1f}")
        if rk != gk:
            print(f"  ref text: {rk[:70]}")
            print(f"  gen text: {gk[:70]}")
    elif gk and not rk:
        print(f"{needle:28} MISSING in ref | gen={gen_items[gk]:.1f} | {gk[:60]}")
    elif rk and not gk:
        print(f"{needle:28} MISSING in gen | ref={ref_items[rk]:.1f} | {rk[:60]}")
    else:
        print(f"{needle:28} not found in either")
