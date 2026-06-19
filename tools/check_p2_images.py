import fitz
from pathlib import Path

PT = 25.4 / 72
ROOT = Path(__file__).resolve().parents[1]
GEN = ROOT / "storage/app/certificates/pdf/_audit_layout.pdf"
REF = Path(r"C:\Users\Sya'ban\Downloads\RAIHAN TAUVIQUL HADY IFDAL.pdf")

for label, path in [("GEN", GEN), ("REF", REF)]:
    doc = fitz.open(path)
    page = doc[1]
    print(f"=== {label} PAGE 2 IMAGES ===")
    for info in page.get_image_info(xrefs=True):
        bbox = info.get("bbox")
        if not bbox:
            continue
        x0, y0, x1, y1 = bbox
        print(
            f"xref={info.get('xref')} "
            f"x={x0*PT:.1f}-{x1*PT:.1f} y={y0*PT:.1f}-{y1*PT:.1f} "
            f"px={info.get('width')}x{info.get('height')}"
        )
    blocks = [b for b in page.get_text("dict")["blocks"] if b.get("type") == 1]
    print(f"image blocks via text dict: {len(blocks)}")
