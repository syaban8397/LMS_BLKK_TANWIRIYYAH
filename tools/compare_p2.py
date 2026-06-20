import fitz
from pathlib import Path

PT = 25.4 / 72.0
REF = Path(r"C:\Users\Sya'ban\Downloads\RAIHAN TAUVIQUL HADY IFDAL.pdf")
GEN = Path(__file__).resolve().parents[1] / "storage" / "app" / "certificates" / "pdf" / "_audit_layout.pdf"

for label, path in [("REF", REF), ("GEN", GEN)]:
    doc = fitz.open(path)
    page = doc[1]
    print(f"=== {label} PAGE 2 ===")
    for block in page.get_text("dict")["blocks"]:
        if block.get("type") != 0:
            continue
        for line in block["lines"]:
            txt = "".join(s["text"] for s in line["spans"]).strip()
            if not txt:
                continue
            y = line["bbox"][1] * PT
            x = line["bbox"][0] * PT
            x1 = line["bbox"][2] * PT
            sz = line["spans"][0]["size"]
            print(f"y={y:5.1f} x={x:5.1f}-{x1:5.1f} sz={sz:4.1f} | {txt[:70]}")
    doc.close()
