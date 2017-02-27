<?php

namespace Philandi\ImgSpector;

class Pixel
{
    /**
     * The position of this pixel on the x-axis
     *
     * @var int
     */
    private $x;

    /**
     * * The position of this pixel on the y-axis
     *
     * @var int
     */
    private $y;

    /**
     * RGBA red
     *
     * @var integer
     */
    private $red;

    /**
     * RGBA green
     *
     * @var integer
     */
    private $green;

    /**
     * RGBA blue
     *
     * @var integer
     */
    private $blue;

    /**
     * RGBA alpha
     *
     * @var integer
     */
    private $alpha;

    /**
     * Hue
     *
     * @var integer
     */
    private $hue;

    /**
     * Saturation
     *
     * @var integer
     */
    private $saturation;

    /**
     * Lightness
     *
     * @var integer
     */
    private $lightness;

    public function __construct($x, $y, $img)
    {
        $this->x = $x;
        $this->y = $y;

        // Get RGB information
        $rgb = imagecolorat($img, $x, $y);
        $rgba = imagecolorsforindex($img, $rgb);
        $this->red = $rgba['red'];
        $this->green = $rgba['green'];
        $this->blue = $rgba['blue'];
        $this->alpha = $rgba['alpha'];

        // Get HSL information
        $hsl = $this->rgb2hsl($rgba);
        $this->hue = $hsl[0];
        $this->saturation = $hsl[1];
        $this->lightness = $hsl[2];
    }


    /**
     * Convert RGB to HSL
     *
     * @param  array $rgb
     * @return array
     */
    private function rgb2hsl($rgb)
    {
        $r = $rgb['red'];
        $g = $rgb['green'];
        $b = $rgb['blue'];

        $r /= 255;
        $g /= 255;
        $b /= 255;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);

        $h;
        $s;
        $l = ($max + $min) / 2;

        $d = $max - $min;

        if ($d == 0) {
            $h = $s = 0;
        } else {
            $s = $d / (1 - abs(2 * $l - 1));

            switch ($max) {
                case $r:
                    $h = 60 * fmod((($g - $b) / $d), 6);
                    if ($b > $g) {
                        $h += 360;
                    }
                    break;
                case $g:
                    $h = 60 * (($b - $r) / $d + 2);
                    break;
                case $b:
                    $h = 60 * (( $r - $g) / $d + 4);
                    break;
            }
        }

        return array(round($h, 2), round($s, 2), round($l, 2));
    }
}
