"""Deep visual diff REF vs PESERTA 1."""
import fitz
from pathlib import Path

PT = 25.4 / 72.0
REF = Path(r"C:/Users/Sya'ban/Downloads/RAIHAN TAUVIQUL HADY IFDAL.pdf")
GEN = Path(r"C:/Users/Sya'ban/Downloads/PESERTA 1.pdf")

for label, path in [("REF", REF), ("GEN", GEN)]:
    doc = fitz.open(path)
    page = doc[0]
    print(f"\n=== {label} SIDEBAR / LOGO TEXT x<55 ===")
    for block in page.get_text("dict")["blocks"]:
        if block.get("type") != 0:
            continue
        for line in block["lines"]:
            txt = "".join(s["text"] for s in line["spans"]).strip()
            if not txt:
                continue
            b = line["bbox"]
            x, y = b[0] * PT, b[1] * PT
            if x < 55 or (206 < x < 218 and y < 25):
                print(f"  y={y:6.2f} x={x:6.2f} sz={line['spans'][0]['size']:.1f} | {txt}")
    doc.close()

# Name center analysis
ref = fitz.open(REF)
gen = fitz.open(GEN)
for label, doc in [("REF", ref), ("GEN", gen)]:
    page = doc[0]
    for block in page.get_text("dict")["blocks"]:
        if block.get("type") != 0:
            continue
        for line in block["lines"]:
            txt = "".join(s["text"] for s in line["spans"]).strip()
            if "PESERTA" in txt or "RAIHAN" in txt:
                b = line["bbox"]
                cx = (b[0] + b[2]) / 2 * PT
                print(f"{label} name: x0={b[0]*PT:.1f} x1={b[2]*PT:.1f} cx={cx:.1f} | {txt}")
ref.close()
gen.close()
