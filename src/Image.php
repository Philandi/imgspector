<?php

namespace Philandi\ImgSpector;

class Image
{
    /**
     * The path to the image
     *
     * @var string
     */
    private $path;

    /**
     * The img resource
     *
     * @var Resource
     */
    private $img;

    /**
     * The pixels of this image
     * @var array
     */
    private $pixels = [];

    /**
     * The width of this image
     *
     * @var int
     */
    private $width;

    /**
     * The mime type of this image
     *
     * @var string
     */
    private $mime;
    /**
     * The height of this image
     *
     * @var int
     */
    private $height;

    public function __construct($path)
    {
        // Leave if the file doesn't exist
        if (!file_exists($path)) {
            throw new \Exception("The image doesn't exist at the given path", 1);
        }

        $this->path = $path;

        // Gather information about the image
        try {
            $info = getimagesize($this->path);

            $this->mime   = $info['mime'];
            $this->width  = $info[0];
            $this->height = $info[1];

            $this->scanPixels();
        } catch(Exception $e) {

        }
    }

    /**
     * Create an instance of a image and return it
     *
     * @param  string $path
     * @return Philandi\ImgSpector\Image
     */
    public static function createFromPath($path)
    {
        return new self($path);
    }

    /**
     * Scan all pixels and analyze them
     *
     * @return void
     */
    public function scanPixels()
    {
        switch ($this->mime) {
            case 'image/png':
                $this->img = imagecreatefrompng($this->path);
                break;
        }

        // analyze and store all pixels
        for ($x=0; $x<$this->width; $x++) {
            $this->pixels[$x] = [];

            for ($y=0; $y<$this->height; $y++) {
                $this->pixels[$x][$y] = new Pixel($x, $y, $this->img);
            }
        }
    }

    /**
     * Returns the pixel at the given position
     *
     * @param  integer $x
     * @param  integer $y
     * @return Philandi\ImgSpector\Pixel;
     */
    public function getPixelAt($x, $y)
    {
        return $this->pixels[$x][$y];
    }
}
