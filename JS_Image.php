<?php

/**
* Class for quick and easy image manipulation using the GD2 library.
* @author Daniel Farrelly <daniel@jellystyle.com>
* @link <https://github.com/jellybeansoup/JS_Image>
*/

class JS_Image {

	/**
	* The path to the original image file.
	* @var string
	*/

	private $_path = NULL;
	
	/**
	* The current image width.
	* @var int
	*/

	private $_width = 0;
	
	/**
	* The current image height.
	* @var int
	*/

	private $_height = 0;
	
	/**
	* The image's mime type, e.g. image/png.
	* @var string
	*/

	private $_mime = null;

	/**
	* The image resource link for the current canvas.
	* @var resource
	*/

	private $_resource = NULL;
	
	/**
	* Create a new instance of JS_Image, referencing a given image file.
	*
	* ```
	* $image = new JS_Image( '/path/to/image.png' );
	* ```
	*
	* @param string $path Server-side path to the image file.
	*/

	public function __construct( $path ) {
		// Increase the memory allocation for this page
		// Mostly so we can deal with super large images
		ini_set('memory_limit', '128M');
		// Store the path
		$this->_path = $path;
		// Reset the image
		self::reset();
	}

	/**
	* Return the content of the manipulated image.
	*
	* ```
	* $image = new JS_Image( '/path/to/image.png' );
	* echo (string) $image;
	* ```
	*
	* @return string The content of the manipulated image.
	*/

	public function __toString() {
		// Turn on output buffering
		ob_start();
		// PNG source
		self::save( null );
		// Put the contents of the output buffer into the content variable
		$content = trim( ob_get_contents() );
		// Clean (erase) the output buffer and turn off output buffering
		ob_end_clean();
		// Output
	 	return (string) $content;
	}
	
	/**
	* Return the mime type for the current image.
	* @return bool Flag indicating whether the save was successful.
	*/

	public function mime() {
		return $this->_mime;
	}
	
	/**
	* Fetch an object with the height and with of the current image.
	* @return bool Flag indicating whether the save was successful.
	*/

	public function size() {
		return (object) array( 'width' => $this->_width, 'height' => $this->_height );
	}
	
	/**
	* Save the manipulated image.
	* @param string $path The path to save the image file to. The path must be writable to successfully save the file.
	*	You can also optionally pass a null value to output the content directly to the browser.
	* @return bool Flag indicating whether the save was successful (true) or not (false).
	*	If a path was specified, the path to the new file is returned in place of the true value.
	*/

	public function save( $path ) {
		// If the path doesn't have any slashes...
		if( $path && strpos( $path, '/' ) === false ) {
			// Get the path info
			$pathinfo = pathinfo( $this->_path );
			// Append the extension
			$path = $path.'.'.$pathinfo['extension'];
			// Relative to the original file
			$path = $pathinfo['dirname'].'/'.$path;
		}
		// PNG source
		if( $this->_mime == 'image/png' )
			$status = imagepng( $this->_resource, $path );
		// GIF source
		if( $this->_mime == 'image/gif' )
			$status = imagegif( $this->_resource, $path );
		// JPEG source
		if( $this->_mime == 'image/jpeg' || $this->_mime == 'image/jpg' )
			$status = imagejpeg( $this->_resource, $path, 100 );
		// If a path is set and the save was successful
		if( $path && $status )
			return $path;
		// Default to returning the status
		return $status;
	}
	
	/**
	* Adjust the size of the image and canvas.
	* @param int $width The new width for the image.
	* @param int $height The new height for the image.
	* @return JS_Image The object for chaining.
	*/

	public function resize( $width, $height ) {
		// Create a blank canvas in the size we want
		$canvas = self::_create_canvas( $width, $height );
		// Copy the image to our thumbnail
		imagecopyresampled( $canvas, $this->_resource, 0, 0, 0, 0, $width, $height, $this->_width, $this->_height );
		// Destroy the original canvas
		self::destroy();
		// Update the object parameters
		$this->_resource = $canvas;
		$this->_width = $width;
		$this->_height = $height;
		// Return the object for chaining
		return $this;
	}
	
	/**
	* Adjust the size of the canvas.
	* @param int $width The new width for the canvas.
	* @param int $height  The new height for the canvas.
	* @param int $x The horizontal offset (from the left) for the image within the canvas. Defaults to 0.
	* @param int $y The vertical offset (from the top) for the image within the canvas. Defaults to 0.
	* @return JS_Image The object for chaining.
	*/

	public function crop( $width, $height, $x=0, $y=0 ) {
		// Create a blank canvas in the size we want
		$canvas = self::_create_canvas( $width, $height );
		// Copy the image to our thumbnail
		imagecopyresampled( $canvas, $this->_resource, 0-$x, 0-$y, 0, 0, $this->_width, $this->_height, $this->_width, $this->_height );
		// Destroy the original canvas
		self::destroy();
		// Update the object parameters
		$this->_resource = $canvas;
		$this->_width = $width;
		$this->_height = $height;
		// Return the object for chaining
		return $this;
	}
	
	/**
	* Rotate the image.
	* @param int $width The new width for the canvas.
	* @param int $height  The new height for the canvas.
	* @param int $x The horizontal offset (from the left) for the image within the canvas. Defaults to 0.
	* @param int $y The vertical offset (from the top) for the image within the canvas. Defaults to 0.
	* @return JS_Image The object for chaining.
	*/

	public function rotate( $angle ) {
		// Copy the image to our thumbnail
		$rotated = imagerotate( $this->_resource, $angle, imagecolorallocatealpha( $this->_resource, 0, 0, 0, 127 ) );
		// Update the object parameters
		$this->_resource = $rotated;
		$this->_width = imagesx( $this->_resource );
		$this->_height = imagesy( $this->_resource );
		// Return the object for chaining
		return $this;
	}
	
	/**
	* Insert the given image into the current image.
	* @param mixed $path The path to the image file to overlay. Another JS_Image object can also be used.
	* @param int $x The horizontal offset (from the left) for the overlaid image. Defaults to 0.
	* @param int $y The vertical offset (from the top) for the overlaid image. Defaults to 0.
	* @return JS_Image The object for chaining.
	*/

	public function overlay( $path, $x=0, $y=0 ) {
		// Get the source image as a resource
		$overlay = self::_fetch_resource( $path );
		// Copy the overlay into the current canvas
		imagecopy( $this->_resource, $overlay, $x, $y, 0, 0, imagesx( $overlay ), imagesy( $overlay ) );
		// Return the object for chaining
		return $this;
	}
	
	/**
	* Mask the current image using the provided image file.
	* @param mixed $path The path to the image file to use as a mask. Another JS_Image object can also be used.
	* @param int $x The horizontal offset (from the left) for the mask. Defaults to 0.
	* @param int $y The vertical offset (from the top) for the mask. Defaults to 0.
	* @return JS_Image The object for chaining.
	*/

	public function mask( $path, $x=0, $y=0 ) {
		// Get the source image as a resource
		$mask = self::_fetch_resource( $path );
		// First we crop to the size of the mask
		self::crop( imagesx( $mask ), imagesy( $mask ), $x, $y );
		// Turn on alpha blending on the current canvas
		imagealphablending( $this->_resource, false );
		// Iterate through the pixels for the image
		for( $pixel_x = 0; $pixel_x < $this->_width; $pixel_x++ ) :
			for( $pixel_y = 0; $pixel_y < $this->_height; $pixel_y++ ) :
				// Get the alpha index
				$alpha = imagecolorsforindex( $mask, imagecolorat( $mask, $pixel_x, $pixel_y ) );
				$alpha = 127 - floor( $alpha['red'] / 2 );
				// Get the colour
				$color = imagecolorsforindex( $this->_resource, imagecolorat( $this->_resource, $pixel_x, $pixel_y ) );
				// Merge the colour and alpha index
				$color_alpha = imagecolorallocatealpha( $this->_resource, $color['red'], $color['green'], $color['blue'], $alpha );
				// Set the pixel colour and alpha on the current canvas
				imagesetpixel( $this->_resource, $pixel_x, $pixel_y, $color_alpha );
			endfor;
		endfor;
		// Return the object for chaining
		return $this;
	}
	
	/**
	* Resize image to the percentage of the original size.
	* i.e. 1024x768 resized by 0.1 produces a 102x77 image (and canvas).
	* @param int $percent The percentage of the original to resize the image to.
	* @return JS_Image The object for chaining.
	*/

	public function percent( $percent ) {
		// Get the new width and height based on the percentage
		$width = round( $this->_width * $percent );
		$height = round( $this->_height * $percent );
		// Resize the image
		$this->resize( $width, $height );
		// Return the object for chaining
		return $this;
	}
	
	/**
	* Resize the image and canvas so that the image fits within the given dimensions.
	* i.e. 1024x768 resized to fit 300x300 produces a 300x225 image (and canvas).
	* @param int $width The maximum width for the resized image.
	* @param int $height The maximum height for resized image.
	* @return JS_Image The object for chaining.
	*/

	public function fit( $width, $height ) {
		// Set the default percent to 100
		$percent = 1;
		// Resize to fit the maximum width
		if( $this->_width > $width )
			$percent = ( $width / $this->_width );
		// Resize to fit the maximum height	
		if( $this->_height > $height )
			$percent = ( $height / $this->_height );
		// Resize the image using the percentage
		if( $percent != 1 )
			$this->percent( $percent );
		// Return the object for chaining
		return $this;
	}
	
	/**
	* Resize the image and canvas so that the image fills the given dimensions.
	* i.e. 1024x768 resized to fit 300x300 produces a 400x300 image centred in a 300x300 canvas.
	* @param int $width The new width for the canvas.
	* @param int $height The new height for the canvas.
	* @return JS_Image The object for chaining.
	*/

	public function fill( $width, $height ) {
		// Set the default percent to 100
		$percent = 1;
		// Get the ratios
		$imageRatio = $this->_height / $this->_width;
		$resizeRatio = $height / $width;
		// Resize to fit the maximum height	
		if( $imageRatio < $resizeRatio )
			$percent = ( $height / $this->_height );
		// Resize to fit the maximum width	
		else
			$percent = ( $width / $this->_width );
		// Resize the image using the percentage
		if( $percent != 1 )
			$this->percent( $percent );
		// Crop the image
		if( $imageRatio != $resizeRatio ) {
			$x = 0 - round( ( $width - $this->_width ) / 2 );
			$y = 0 - round( ( $height - $this->_height ) / 2 );
			$this->crop( $width, $height, $x, $y );
		}
		// Return the object for chaining
		return $this;
	}
	
	/**
	* Reset the image canvas to the original.
	* @return JS_Image The object for chaining.
	*/

	public function reset() {
		// Get the image size
		$image_size = getimagesize( $this->_path );
		$this->_width = $image_size[0];
		$this->_height = $image_size[1];
		$this->_mime = $image_size['mime'];
		// Destroy the original canvas (if one exists)
		self::destroy();
		// Get the source image as a resource
	 	$this->_resource = self::_fetch_resource( $this->_path );
	 	// Resize to 100% to workaround losing transparency when outputting the image unmanipulated.
	 	$this->percent( 1 );
		// Return the object for chaining
		return $this;
	}
	
	/**
	* Destroy the current canvas.
	* @return JS_Image The object for chaining.
	*/

	public function destroy() {
		// Destroy the original canvas (if one exists)
		if( $this->_resource ) {
			imagedestroy( $this->_resource );
			$this->_resource = null;
		}
		// Return the object for chaining
		return $this;
	}

	/**
	* Create a canvas in the size given.
	* @param int $width The width for the new canvas.
	* @param int $height The height for new canvas.
	* @returns An image resource.
	*/

	private function _create_canvas( $width, $height ) {
		// Create a blank canvas in the size we want
		$canvas = imagecreatetruecolor( $width, $height );
		// Turn off alpha blending
		imagesavealpha( $canvas, true );
		// Set the background color to white
		imagefill( $canvas, 0, 0, imagecolorallocatealpha( $canvas, 0, 0, 0, 127 ) );
		// Return the new canvas
		return $canvas;
	}
	
	/**
	* Fetch an image resource for the image
	* @param string $path Server-side path to the image file.
	* @returns An image resource.
	*/

	private function _fetch_resource( $path ) {
		// If we're dealing with an JS_Image object
		if( is_a( $path, 'JS_Image' ) )
			return imagecreatefromstring( (string) $path );
		// If we have an existing path
		elseif( file_exists( $path ) ) {
			$content = file_get_contents( $path );
			return imagecreatefromstring( $content );
		}
		// Default to null
		return null;
	}
	
}