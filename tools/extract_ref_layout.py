"""Extract all page-1 text bboxes from reference PDF for template tuning."""
import fitz
from pathlib import Path

PT = 25.4 / 72.0
REF = Path(r"C:/Users/Sya'ban/Downloads/RAIHAN TAUVIQUL HADY IFDAL.pdf")

doc = fitz.open(REF)
page = doc[0]
lines = []
for block in page.get_text("dict")["blocks"]:
    if block.get("type") != 0:
        continue
    for line in block["lines"]:
        txt = "".join(s["text"] for s in line["spans"]).strip()
        if not txt:
            continue
        b = line["bbox"]
        lines.append(
            {
                "y": b[1] * PT,
                "x0": b[0] * PT,
                "x1": b[2] * PT,
                "w": (b[2] - b[0]) * PT,
                "cx": (b[0] + b[2]) / 2 * PT,
                "sz": line["spans"][0]["size"],
                "t": txt,
            }
        )

lines.sort(key=lambda l: (l["y"], l["x0"]))
print("REF PAGE 1 TEXT LINES")
for ln in lines:
    print(
        f"y={ln['y']:6.2f} x0={ln['x0']:6.2f} x1={ln['x1']:6.2f} w={ln['w']:6.2f} "
        f"cx={ln['cx']:6.2f} sz={ln['sz']:5.1f} | {ln['t'][:70]}"
    )

print("\nREF PAGE 1 IMAGES")
imgs = []
for block in page.get_text("dict")["blocks"]:
    if block.get("type") == 1:
        b = block["bbox"]
        imgs.append(
            {
                "x0": b[0] * PT,
                "y0": b[1] * PT,
                "x1": b[2] * PT,
                "y1": b[3] * PT,
                "w": (b[2] - b[0]) * PT,
                "h": (b[3] - b[1]) * PT,
            }
        )
imgs.sort(key=lambda i: (i["y0"], i["x0"]))
for i, im in enumerate(imgs):
    print(
        f"img{i} x0={im['x0']:6.2f} y0={im['y0']:6.2f} w={im['w']:6.2f} h={im['h']:6.2f}"
    )

doc.close()
