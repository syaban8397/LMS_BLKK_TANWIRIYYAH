"""Detailed page-1 image analysis for REF vs GEN."""
import fitz
from pathlib import Path

PT = 25.4 / 72.0
REF = Path(r"C:/Users/Sya'ban/Downloads/RAIHAN TAUVIQUL HADY IFDAL.pdf")
GEN = Path(r"C:/Users/Sya'ban/Downloads/PESERTA 2.pdf")


def imgs(path):
    doc = fitz.open(path)
    page = doc[0]
    out = []
    for block in page.get_text("dict")["blocks"]:
        if block.get("type") == 1:
            b = block["bbox"]
            out.append({
                "x0": b[0] * PT,
                "y0": b[1] * PT,
                "x1": b[2] * PT,
                "y1": b[3] * PT,
                "w": (b[2] - b[0]) * PT,
                "h": (b[3] - b[1]) * PT,
            })
    doc.close()
    return sorted(out, key=lambda i: (round(i["y0"], 1), round(i["x0"], 1)))


for label, path in [("REF", REF), ("GEN", GEN)]:
    print(f"\n=== {label} PAGE 1 IMAGES ({path.name}) ===")
    for i, im in enumerate(imgs(path)):
        print(
            f"  [{i}] x={im['x0']:6.2f}-{im['x1']:6.2f} "
            f"y={im['y0']:6.2f}-{im['y1']:6.2f} "
            f"({im['w']:.1f}x{im['h']:.1f}mm)"
        )
