import fitz
from pathlib import Path

PT = 25.4 / 72
doc = fitz.open(Path(r"C:/Users/Sya'ban/Downloads/RAIHAN TAUVIQUL HADY IFDAL.pdf"))
p = doc[1]
for block in p.get_text("dict")["blocks"]:
    if block.get("type") != 0:
        continue
    for line in block["lines"]:
        for s in line["spans"]:
            t = s["text"].strip()
            if t:
                print(
                    f"y={s['bbox'][1]*PT:.2f} x={s['bbox'][0]*PT:.2f} "
                    f"sz={s['size']:.1f} font={s['font'][:40]} | {t[:50]}"
                )
doc.close()
