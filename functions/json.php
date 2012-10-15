<?php

/**
 * <h3>JSON utilities</h3>
 *
 * This file contains common JSON functions used by the library.
 *
 *	@package	MyWrapper
 *	@subpackage	Functions
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 03/09/2012
 */

/*=======================================================================================
 *																						*
 *										json.php										*
 *																						*
 *======================================================================================*/

/**
 * Errors.
 *
 * This include file contains all error code definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Errors.inc.php" );



/*=======================================================================================
 *																						*
 *									JSON INTERFACE										*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	JsonEncode																		*
	 *==================================================================================*/

	/**
	 * <h4>Return JSON encoded data</h4>
	 *
	 * This function will return the provided array or object into a JSON encoded string.
	 *
	 * @param mixed					$theData			PHP data.
	 *
	 * @return string				JSON string.
	 *
	 * @uses JsonError()
	 */
	function JsonEncode( $theData )
	{
		//
		// Encode json.
		//
		$json = @json_encode( $theData );
		
		//
		// Handle errors.
		//
		JsonError( TRUE );
		
		return $json;																// ==>
	
	} // JsonEncode.

	 
	/*===================================================================================
	 *	JsonDecode																		*
	 *==================================================================================*/

	/**
	 * <h4>Return JSON decoded data</h4>
	 *
	 * This function will convert the provided JSON string into a PHP structure.
	 *
	 * @param string				$theData			JSON string.
	 *
	 * @return mixed				PHP data.
	 *
	 * @uses JsonError()
	 */
	function JsonDecode( $theData )
	{
		//
		// Decode JSON.
		//
		$decoded = @json_decode( $theData, TRUE );
		
		//
		// Handle errors.
		//
		JsonError( FALSE );
		
		return $decoded;															// ==>
	
	} // JsonDecode.

	 
	/*===================================================================================
	 *	JsonError																		*
	 *==================================================================================*/

	/**
	 * <h4>Return JSON errors</h4>
	 *
	 * This method will raise an exception according to the last JSON error
	 *
	 * @param boolean				$doEncode			<tt>TRUE</tt> for <i>encode</i>,
	 *													<tt>FALSE</tt> for <i>decode</i>.
	 *
	 * @throws Exception
	 *
	 * @see JSON_ERROR_DEPTH JSON_ERROR_STATE_MISMATCH
	 * @see JSON_ERROR_CTRL_CHAR JSON_ERROR_SYNTAX JSON_ERROR_UTF8
	 * @see kERROR_ENCODE kERROR_DECODE
	 */
	function JsonError( $doEncode )
	{
		//
		// Init local storage.
		//
		$code = ( $doEncode )? kERROR_ENCODE : kERROR_DECODE;
		$sense = ( $doEncode )? 'encode' : 'decode';
		
		//
		// Handle errors.
		//
		switch( json_last_error() )
		{
			case JSON_ERROR_DEPTH:
				throw new \Exception
					( "JSON $sense error: maximum stack depth exceeded",
					  $code );													// !@! ==>

			case JSON_ERROR_STATE_MISMATCH:
				throw new \Exception
					( "JSON $sense error: invalid or malformed JSON",
					  $code );													// !@! ==>

			case JSON_ERROR_CTRL_CHAR:
				throw new \Exception
					( "JSON $sense error: unexpected control character found",
					  $code );													// !@! ==>

			case JSON_ERROR_SYNTAX:
				throw new \Exception
					( "JSON $sense error: syntax error, malformed JSON",
					  $code );													// !@! ==>

			case JSON_ERROR_UTF8:
				throw new \Exception
					( "JSON $sense error: malformed UTF-8 characters, "
					 ."possibly incorrectly encoded",
					  $code );													// !@! ==>
		}
	
	} // JsonError.


?>
