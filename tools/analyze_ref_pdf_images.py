import fitz

pdf_path = r"C:\Users\Sya'ban\Downloads\RAIHAN TAUVIQUL HADY IFDAL.pdf"
doc = fitz.open(pdf_path)
PT_TO_MM = 25.4 / 72.0

for pi, page in enumerate(doc):
    print(f"=== PAGE {pi + 1} IMAGES ===")
    for img in page.get_images(full=True):
        print(img[:4])

    print("=== DRAWINGS/LINES (sample) ===")
    paths = page.get_drawings()
    for p in paths[:20]:
        rect = p.get("rect")
        if rect:
            r = fitz.Rect(rect)
            print(
                f"rect y={r.y0 * PT_TO_MM:.1f}-{r.y1 * PT_TO_MM:.1f}mm "
                f"x={r.x0 * PT_TO_MM:.1f}-{r.x1 * PT_TO_MM:.1f}mm"
            )

    print("=== IMAGE BLOCKS ===")
    for block in page.get_text("dict")["blocks"]:
        if block.get("type") == 1:
            x0, y0, x1, y1 = block["bbox"]
            print(
                f"img block y={y0 * PT_TO_MM:.1f}-{y1 * PT_TO_MM:.1f}mm "
                f"x={x0 * PT_TO_MM:.1f}-{x1 * PT_TO_MM:.1f}mm "
                f"w={(x1-x0)*PT_TO_MM:.1f}mm h={(y1-y0)*PT_TO_MM:.1f}mm"
            )
