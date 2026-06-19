import fitz
import sys

pdf_path = r"C:\Users\Sya'ban\Downloads\RAIHAN TAUVIQUL HADY IFDAL.pdf"
doc = fitz.open(pdf_path)

PT_TO_MM = 25.4 / 72.0

for pi, page in enumerate(doc):
    print(f"=== PAGE {pi + 1} size={page.rect.width:.1f}x{page.rect.height:.1f} pt ===")
    items = []
    for block in page.get_text("dict")["blocks"]:
        if block.get("type") != 0:
            continue
        for line in block["lines"]:
            for span in line["spans"]:
                text = span["text"].strip()
                if not text:
                    continue
                x0, y0, x1, y1 = span["bbox"]
                items.append(
                    (
                        y0,
                        x0,
                        text.replace("\n", " ")[:100],
                        round(y0 * PT_TO_MM, 1),
                        round(x0 * PT_TO_MM, 1),
                        round(span.get("size", 0), 1),
                    )
                )
    items.sort(key=lambda x: (round(x[0], 1), x[1]))
    for _, _, text, ymm, xmm, fpt in items:
        print(f"y={ymm:6.1f}mm x={xmm:6.1f}mm size={fpt:4.1f}pt | {text}")
    print()
