import fitz
from pathlib import Path

PT = 25.4 / 72
doc = fitz.open(Path(r"C:/Users/Sya'ban/Downloads/RAIHAN TAUVIQUL HADY IFDAL.pdf"))
p = doc[0]
for block in p.get_text("dict")["blocks"]:
    if block.get("type") != 0:
        continue
    for line in block["lines"]:
        for s in line["spans"]:
            t = s["text"].strip()
            if not t or s["bbox"][1] * PT < 45:
                continue
            b = s["bbox"]
            print(
                f"y={b[1]*PT:.2f} x={b[0]*PT:.2f} w={(b[2]-b[0])*PT:.1f} "
                f"sz={s['size']:.1f} font={s['font'][:35]} color={s.get('color')} | {t[:55]}"
            )
doc.close()
