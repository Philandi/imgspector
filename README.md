# imgspector
PHP Tool for analyzing pixels of images (eg. RGB, HSL, ...)


## Installation

Recommended installation is via [Composer](http://getcomposer.org).

```bash
composer require philandi/imgspector
```

## Getting started

Analyzing images is simple. Just create an instance of an image with a file path.

```php

use Philandi\ImgSpector\Image;

$img = new Image('/path/to/file.png');

// or

$img = Image::createFromPath('/path/to/file.png');

```
