# JS_Image
Class for quick and easy image manipulation using the GD2 library.

* Daniel Farrelly <daniel@jellystyle.com>
* <http://jellystyle.com>

## __construct( *string* $path )
Create a new instance of JS_Image, referencing a given image file.

```
$image = new JS_Image( '/path/to/image.png' );
```

### Parameters
* *string* **$path:** Server-side path to the image file.

## __toString(  )
Return the content of the manipulated image.

```
$image = new JS_Image( '/path/to/image.png' );
echo (string) $image;
```

### Return
*string* The content of the manipulated image.

## mime(  )
Return the mime type for the current image.

### Return
*bool* Flag indicating whether the save was successful.

## size(  )
Fetch an object with the height and with of the current image.

### Return
*bool* Flag indicating whether the save was successful.

## save( *string* $path )
Save the manipulated image.

### Parameters
* *string* **$path:** The path to save the image file to. The path must be writable to successfully save the file.
You can also optionally pass a null value to output the content directly to the browser.

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

## overlay( *mixed* $path, *int* $x, *int* $y )
Insert the given image into the current image.

### Parameters
* *mixed* **$path:** The path to the image file to overlay. Another JS_Image object can also be used.
* *int* **$x:** The horizontal offset (from the left) for the overlaid image. Defaults to 0.
* *int* **$y:** The vertical offset (from the top) for the overlaid image. Defaults to 0.

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

## reset(  )
Reset the image canvas to the original.

### Return
*JS_Image* The object for chaining.

## destroy(  )
Destroy the current canvas.

### Return
*JS_Image* The object for chaining.