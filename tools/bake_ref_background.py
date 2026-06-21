"""Bake page-1 reference background — full raster from reference PDF (no white-out)."""
from pathlib import Path

import fitz

REF = Path(r"C:/Users/Sya'ban/Downloads/RAIHAN TAUVIQUL HADY IFDAL.pdf")
OUT = Path(__file__).resolve().parents[1] / "public/images/certificates/page1-reference-bg.png"


def main() -> None:
    doc = fitz.open(REF)
    page = doc[0]
    mat = fitz.Matrix(300 / 72, 300 / 72)
    pix = page.get_pixmap(matrix=mat, alpha=False)
    doc.close()

    OUT.parent.mkdir(parents=True, exist_ok=True)
    pix.save(str(OUT))
    print(f"Saved {OUT} ({pix.width}x{pix.height})")


if __name__ == "__main__":
    main()
