JS_Image is a super simple wrapper for the GD2 image library written in PHP. It allows for easy manipulation of image files within any PHP project.

``` php
<?php
	// First, construct a new object with the file path
	$image = JS_Image( 'path/to/image.png' );

	// Then do any number of manipulations to the image
	$image->resize( 100, 300 );
	$image->crop( 50, 50 );
	
	// You can also reset and start from the original
	$image->reset();
	$image->fill( 200, 200 );

	// Methods can be chained
	$image->rotate( 20 )->crop( 100, 100 );

	// And when you're done, save…
	$image->save( 'image-thumb' );

	// Or create a string with the content
	echo (string) $image;

?>
```