import fitz
from pathlib import Path

PT = 25.4 / 72.0
REF = Path(r"C:/Users/Sya'ban/Downloads/RAIHAN TAUVIQUL HADY IFDAL.pdf")

doc = fitz.open(REF)
page = doc[0]
for block in page.get_text("dict")["blocks"]:
    if block.get("type") != 0:
        continue
    for line in block["lines"]:
        t = "".join(s["text"] for s in line["spans"]).strip()
        if not t:
            continue
        b = line["bbox"]
        if b[1] * PT < 180:
            continue
        sp = line["spans"][0]
        print(
            f"y={b[1]*PT:.2f} x={b[0]*PT:.2f} x1={b[2]*PT:.2f} "
            f"w={(b[2]-b[0])*PT:.2f} sz={sp['size']:.1f} | {t}"
        )
doc.close()
