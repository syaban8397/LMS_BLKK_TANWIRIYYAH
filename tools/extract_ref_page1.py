"""Extract page 1 of REF as PNG for template background analysis."""
import fitz
from pathlib import Path

REF = Path(r"C:/Users/Sya'ban/Downloads/RAIHAN TAUVIQUL HADY IFDAL.pdf")
OUT = Path(r"D:/PROJECT-KP/lms_blkk/storage/app/ref-page1.png")

doc = fitz.open(REF)
page = doc[0]
# 300 dpi: matrix = 300/72
mat = fitz.Matrix(300 / 72, 300 / 72)
pix = page.get_pixmap(matrix=mat, alpha=False)
pix.save(str(OUT))
print(f"Saved {OUT} size={pix.width}x{pix.height}")
doc.close()
