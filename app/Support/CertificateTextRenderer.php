<?php

namespace App\Support;

class CertificateTextRenderer
{
    protected const DPI = 300;

    /**
     * Render text to a transparent PNG (base64) for embedding in DomPDF.
     *
     * @param  array{
     *     text: string,
     *     fontFile: string,
     *     fontSizePt: float,
     *     color: string,
     *     widthMm: float,
     *     align?: 'left'|'center'|'right',
     *     bold?: bool
     * }  $options
     */
    public static function render(array $options): string
    {
        if (! extension_loaded('gd') || ! function_exists('imagettftext')) {
            throw new \RuntimeException('GD with FreeType is required for certificate text rendering.');
        }

        $text = $options['text'];
        $fontFile = $options['fontFile'];
        $fontSizePt = (float) $options['fontSizePt'];
        $color = self::parseColor($options['color']);
        $widthMm = (float) $options['widthMm'];
        $align = $options['align'] ?? 'left';

        if (! is_file($fontFile)) {
            throw new \RuntimeException("Certificate font not found: {$fontFile}");
        }

        $fontSizePx = self::ptToPx($fontSizePt);
        $widthPx = (int) ceil(self::mmToPx($widthMm));
        $heightPx = (int) ceil($fontSizePx * 1.6);

        $bbox = imagettfbbox($fontSizePx, 0, $fontFile, $text);
        $textWidth = (int) abs($bbox[2] - $bbox[0]);
        $textHeight = (int) abs($bbox[7] - $bbox[1]);
        $baselineFromTop = (int) abs($bbox[7]);

        $heightPx = max((int) ceil($textHeight + self::ptToPx(2)), (int) ceil($fontSizePx * 1.2));

        $img = imagecreatetruecolor($widthPx, $heightPx);
        imagesavealpha($img, true);
        $transparent = imagecolorallocatealpha($img, 255, 255, 255, 127);
        imagefill($img, 0, 0, $transparent);

        $textColor = imagecolorallocate($img, $color[0], $color[1], $color[2]);

        $x = match ($align) {
            'center' => (int) max(0, ($widthPx - $textWidth) / 2),
            'right' => (int) max(0, $widthPx - $textWidth),
            default => 0,
        };
        $y = (int) (($heightPx - $textHeight) / 2 + $baselineFromTop);

        imagettftext($img, $fontSizePx, 0, $x, $y, $textColor, $fontFile, $text);

        ob_start();
        imagepng($img);
        $png = ob_get_clean();
        imagedestroy($img);

        return base64_encode($png);
    }

    public static function fontPath(string $variant): string
    {
        $map = [
            'black' => 'Montserrat-Black.ttf',
            'bold' => 'Montserrat-Bold.ttf',
            'regular' => 'Montserrat-Regular.ttf',
            'italic' => 'Montserrat-Italic.ttf',
        ];

        return storage_path('fonts/certificates/' . ($map[$variant] ?? $map['bold']));
    }

    protected static function ptToPx(float $pt): float
    {
        return $pt * self::DPI / 72;
    }

    protected static function mmToPx(float $mm): float
    {
        return $mm * self::DPI / 25.4;
    }

    /**
     * @return array{0: int, 1: int, 2: int}
     */
    protected static function parseColor(string $hex): array
    {
        $hex = ltrim($hex, '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ];
    }
}
