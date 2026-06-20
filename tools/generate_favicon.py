from pathlib import Path

from PIL import Image

SRC = Path(
    r"C:/Users/Sya'ban/.cursor/projects/d-PROJECT-KP-lms-blkk/assets/"
    r"c__Users_Sya_ban_AppData_Roaming_Cursor_User_workspaceStorage_a4f65610c8bb49a02c63819b8eca9a58_images_"
    r"image-67ff35f2-bf47-4d79-a0fd-e59f527c117d.png"
)
OUT = Path(__file__).resolve().parents[1] / "public"

img = Image.open(SRC).convert("RGBA")
for size, name in [
    (16, "favicon-16x16.png"),
    (32, "favicon-32x32.png"),
    (180, "apple-touch-icon.png"),
    (512, "favicon.png"),
]:
    resized = img.resize((size, size), Image.Resampling.LANCZOS)
    resized.save(OUT / name, optimize=True)

Image.open(OUT / "favicon-32x32.png").save(
    OUT / "favicon.ico",
    format="ICO",
    sizes=[(16, 16), (32, 32)],
)
print("Generated favicons in", OUT)
