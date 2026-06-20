import fitz
from pathlib import Path
PT = 25.4 / 72.0
GEN = Path(r"C:/Users/Sya'ban/Downloads/PESERTA 1.pdf")
doc = fitz.open(GEN)
page = doc[0]
print("GEN PAGE 1 IMAGES")
for i, block in enumerate(page.get_text("dict")["blocks"]):
    if block.get("type") == 1:
        b = block["bbox"]
        print(f"img x0={b[0]*PT:.2f} y0={b[1]*PT:.2f} w={(b[2]-b[0])*PT:.2f} h={(b[3]-b[1])*PT:.2f}")
print("\nGEN PAGE 1 KEY TEXT")
for block in page.get_text("dict")["blocks"]:
    if block.get("type") != 0: continue
    for line in block["lines"]:
        txt = "".join(s["text"] for s in line["spans"]).strip()
        if not txt: continue
        b = line["bbox"]
        if b[1]*PT > 150:
            print(f"y={b[1]*PT:.2f} x0={b[0]*PT:.2f} | {txt[:60]}")
doc.close()
