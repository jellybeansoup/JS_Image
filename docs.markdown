# JS_Image
Class for quick and easy image manipulation using the GD2 library.

* Daniel Farrelly <daniel@jellystyle.com>
* <https://github.com/jellybeansoup/JS_Image>

## __construct( *string* $path )
Create a new instance of JS_Image, referencing a given image file.

``` php
$image = new JS_Image( '/path/to/image.png' );
```

### Parameters
* *string* **$path:** Server-side path to the image file.

## mime(  )
Return the mime type for the current image.

### Return
*bool* Flag indicating whether the save was successful.

## size(  )
Fetch an object with the height and with of the current image.

### Return
*bool* Flag indicating whether the save was successful.

## __toString(  )
Return the content of the manipulated image.

``` php
$image = new JS_Image( '/path/to/image.png' );
echo (string) $image;
```

### Return
*string* The content of the manipulated image.

## save( *string* $path, *bool* $interlace )
Save the manipulated image.

### Parameters
* *string* **$path:** The path to save the image file to. The path must be writable to successfully save the file.
You can also optionally pass a null value to output the content directly to the browser.
* *bool* **$interlace:** Flag indicating whether to save as an interlaced image(true) or not (false). Defaults to false.
If true, PNG and GIF images are saved as interlaced images, while JPEGs are saved as progressive.

### Return
*bool* Flag indicating whether the save was successful (true) or not (false).
If a path was specified, the path to the new file is returned in place of the true value.

## resize( *int* $width, *int* $height )
Adjust the size of the image and canvas.

### Parameters
* *int* **$width:** The new width for the image.
* *int* **$height:** The new height for the image.

### Return
*JS_Image* The object for chaining.

## crop( *int* $width, *int* $height, *int* $x, *int* $y )
Adjust the size of the canvas.

### Parameters
* *int* **$width:** The new width for the canvas.
* *int* **$height:** The new height for the canvas.
* *int* **$x:** The horizontal offset (from the left) for the image within the canvas. Defaults to 0.
* *int* **$y:** The vertical offset (from the top) for the image within the canvas. Defaults to 0.

### Return
*JS_Image* The object for chaining.

## rotate( *int* $width, *int* $height, *int* $x, *int* $y )
Rotate the image.

### Parameters
* *int* **$width:** The new width for the canvas.
* *int* **$height:** The new height for the canvas.
* *int* **$x:** The horizontal offset (from the left) for the image within the canvas. Defaults to 0.
* *int* **$y:** The vertical offset (from the top) for the image within the canvas. Defaults to 0.

### Return
*JS_Image* The object for chaining.

## overlay( *mixed* $path, *int* $x, *int* $y, *string* $type )
Insert the given image into the current image.

### Parameters
* *mixed* **$path:** The path to the image file to overlay. Another JS_Image object can also be used.
* *int* **$x:** The horizontal offset (from the left) for the overlaid image. Defaults to 0.
* *int* **$y:** The vertical offset (from the top) for the overlaid image. Defaults to 0.
* *string* **$type:** The layer effect to use in overlaying the image, can be replace, normal or overlay. Defaults to 'normal'.

### Return
*JS_Image* The object for chaining.

## mask( *mixed* $path, *int* $x, *int* $y )
Mask the current image using the provided image file.

### Parameters
* *mixed* **$path:** The path to the image file to use as a mask. Another JS_Image object can also be used.
* *int* **$x:** The horizontal offset (from the left) for the mask. Defaults to 0.
* *int* **$y:** The vertical offset (from the top) for the mask. Defaults to 0.

### Return
*JS_Image* The object for chaining.

## noise( *float* $percent )
Randomly adjust the colour the pixels in the image, given a maximum percentage.

### Parameters
* *float* **$percent:** The maximum amount of noise, as a percentage. Defaults to 0.1.

### Return
*JS_Image* The object for chaining.

## diffuse( *int* $dist )
Randomly rearrange the pixels for the image, given a maximum distance.

### Parameters
* *int* **$dist:** The maximum pixel distance. Defaults to 2.

### Return
*JS_Image* The object for chaining.

## colorize( *int* $red, *int* $green, *int* $blue, *float* $percent )
Shift the colour pallet of the image to a given colour.
This method adjusts the colour pallet using a custom algorithm. For an alternate method,
see JS_Image::colorize_alt, which uses the built-in GD filter.

### Parameters
* *int* **$red:** The red value for the desired colour shift. Should be between 0 and 255.
* *int* **$green:** The green value for the desired colour shift. Should be between 0 and 255.
* *int* **$blue:** The blue value for the desired colour shift. Should be between 0 and 255.
* *float* **$percent:** The amount to shift towards the provided colour as a percentage.

### Return
*JS_Image* The object for chaining.

## desaturate( *float* $percent )
Remove colour from the image canvas, effectively converting it to a greyscale image.

### Parameters
* *float* **$percent:** The amount of desaturation to be applied to the image as a percentage. Defaults to 1.

### Return
*JS_Image* The object for chaining.

## opacity( *float* $percent )
Change the opacity of the image so that it appears to be see through.

### Parameters
* *float* **$percent:** The percentage of the original opacity.

### Return
*JS_Image* The object for chaining.

## percent( *int* $percent )
Resize image to the percentage of the original size.
i.e. 1024x768 resized by 0.1 produces a 102x77 image (and canvas).

### Parameters
* *int* **$percent:** The percentage of the original to resize the image to.

### Return
*JS_Image* The object for chaining.

## fit( *int* $width, *int* $height )
Resize the image and canvas so that the image fits within the given dimensions.
i.e. 1024x768 resized to fit 300x300 produces a 300x225 image (and canvas).

### Parameters
* *int* **$width:** The maximum width for the resized image.
* *int* **$height:** The maximum height for resized image.

### Return
*JS_Image* The object for chaining.

## fill( *int* $width, *int* $height )
Resize the image and canvas so that the image fills the given dimensions.
i.e. 1024x768 resized to fit 300x300 produces a 400x300 image centred in a 300x300 canvas.

### Parameters
* *int* **$width:** The new width for the canvas.
* *int* **$height:** The new height for the canvas.

### Return
*JS_Image* The object for chaining.

## invert(  )
Reverses all colors of the image, giving it a negative appearance.

### Return
*JS_Image* The object for chaining.

## brightness( *int* $level )
Uses mean removal to achieve a "sketchy" effect.

### Parameters
* *int* **$level:** Changes the brightness of the image.

### Return
*JS_Image* The object for chaining.

## contrast( *int* $level )
Changes the contrast of the image.

### Parameters
* *int* **$level:** The level of contrast.

### Return
*JS_Image* The object for chaining.

## colorize_alt( *int* $red, *int* $green, *int* $blue, *float* $percent )
Shift the colour pallet of the image to a given colour.
This method uses the IMG_FILTER_COLORIZE filter provided by GD and gives a slightly different
result to JS_Image::colorize. For convenience, they are set up to work using the same parameters.

### Parameters
* *int* **$red:** The red value for the desired colour shift. Should be between 0 and 255.
* *int* **$green:** The green value for the desired colour shift. Should be between 0 and 255.
* *int* **$blue:** The blue value for the desired colour shift. Should be between 0 and 255.
* *float* **$percent:** The amount to shift towards the provided colour as a percentage.

### Return
*JS_Image* The object for chaining.

## edge_detect(  )
Uses edge detection to highlight the edges in the image.

### Return
*JS_Image* The object for chaining.

## emboss(  )
Embosses the image.

### Return
*JS_Image* The object for chaining.

## gaussian_blur(  )
Blurs the image using the Gaussian method.

### Return
*JS_Image* The object for chaining.

## selective_blur(  )
Blurs the image.

### Return
*JS_Image* The object for chaining.

## mean_removal(  )
Uses mean removal to achieve a "sketchy" effect.

### Return
*JS_Image* The object for chaining.

## smooth( *int* $level )
Makes the image smoother.

### Parameters
* *int* **$level:** The level of smoothness.

### Return
*JS_Image* The object for chaining.

## pixelate( *int* $size, *bool* $advanced )
Applies a pixelation effect to the image.

### Parameters
* *int* **$size:** Block size in pixels.
* *bool* **$advanced:** Whether to use advanced pixelation effect (true) or not (false). Defaults to false.

### Return
*JS_Image* The object for chaining.

## palette( *int* $colors, *bool* $dithering )
Reduce the palette of the image canvas. This is a slightly quicker method than JS_Image::adaptive.

### Parameters
* *int* **$colors:** The maximum number of colours to allow in the canvas.
* *bool* **$dithering:** Flag indicating whether to dither the image (true) or not (false). Defaults to true.

### Return
*JS_Image* The object for chaining.

## adaptive( *int* $colors, *bool* $dithering )
Reduce the palette of the image canvas, matching the resulting colours as closely to the original palette
as possible. This produces a more accurate (and better looking) image that JS_Image::palette.

### Parameters
* *int* **$colors:** The maximum number of colours to allow in the canvas.
* *bool* **$dithering:** Flag indicating whether to dither the image (true) or not (false). Defaults to true.

### Return
*JS_Image* The object for chaining.

## background( *int* $red, *int* $green, *int* $blue, *float* $alpha )
Reduce the palette of the image canvas.

### Parameters
* *int* **$red:** The red value for the desired background colour. Should be between 0 and 255.
* *int* **$green:** The green value for the desired background colour. Should be between 0 and 255.
* *int* **$blue:** The blue value for the desired background colour. Should be between 0 and 255.
* *float* **$alpha:** The $alpha value for the desired background colour as a percentage.

### Return
*JS_Image* The object for chaining.

## reset(  )
Reset the image canvas to the original.

### Return
*JS_Image* The object for chaining.

## destroy(  )
Destroy the current canvas.

### Return
*JS_Image* The object for chaining.