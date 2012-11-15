<?php

/**
 * <h4>String utilities</h4>
 *
 * This file contains common string functions used by the library.
 *
 *	@package	MyWrapper
 *	@subpackage	Functions
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 03/09/2012
 */

/*=======================================================================================
 *																						*
 *										string.php										*
 *																						*
 *======================================================================================*/

/**
 * Errors.
 *
 * This include file contains all error code definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Errors.inc.php" );

/**
 * Flags.
 *
 * This include file contains all status flag definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Flags.inc.php" );



/*=======================================================================================
 *																						*
 *									STRING INTERFACE										*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	StringNormalise																	*
	 *==================================================================================*/

	/**
	 * <h4>Normalise string</h4>
	 *
	 * This function can be used to format a string, the provided modifiers bitfield
	 * determines what manipulations are applied:
	 *
	 * <ul>
	 *	<li><tt>{@link kFLAG_MODIFIER_UTF8}</tt>: Convert the string to the <tt>UTF8</tt>
	 *		character set.
	 *	<li><tt>{@link kFLAG_MODIFIER_LTRIM}</tt>: Apply left trimming to the string.
	 *	<li><tt>{@link kFLAG_MODIFIER_RTRIM}</tt>: Apply right trimming to the string.
	 *	<li><tt>{@link kFLAG_MODIFIER_TRIM}</tt>: Apply both left and right trimming to the
	 *		string.
	 *	<li><tt>{@link kFLAG_MODIFIER_NULL}</tt>: If the resulting string is empty, the
	 *		method will return <tt>NULL</tt>.
	 *	 <ul>
	 *		<li><tt>{@link kFLAG_MODIFIER_NULLSTR}</tt>: If this flag is set and the
	 *			resulting string is empty, the method will return the '<tt>NULL</tt>'
	 *			string.
	 *	 </ul>
	 *	<li><tt>{@link kFLAG_MODIFIER_NOCASE}</tt>: Set the string to lowercase, this is the
	 *		default way to generate a case insensitive string.
	 *	<li><tt>{@link kFLAG_MODIFIER_URL}</tt>: URL-encode the string; note that this
	 *		option and {@link kFLAG_MODIFIER_HTML} are mutually exclusive.
	 *	<li><tt>{@link kFLAG_MODIFIER_HTML}</tt>: HTML-encode the string; note that this
	 *		option and {@link kFLAG_MODIFIER_URL} are mutually exclusive.
	 *	<li><tt>{@link kFLAG_MODIFIER_HEX}</tt>: Convert the string to hexadecimal; note
	 *		that this option and {@link kFLAG_MODIFIER_MASK_HASH} are mutually exclusive.
	 *	 <ul>
	 *		<li><tt>{@link kFLAG_MODIFIER_HEXEXP}</tt>: Convert the string to a hexadecimal
	 *			expression; note that this option and {@link kFLAG_MODIFIER_MASK_HASH} are
	 *			mutually exclusive.
	 *	 </ul>
	 *	<li><tt>{@link kFLAG_MODIFIER_HASH}</tt>: If this bit is set, the resulting string
	 *		will be hashed using the <tt>md5</tt> algorithm resulting in a 32 character
	 *		hexadecimal string; this option is mutually exclusive with the
	 *		{@link kFLAG_MODIFIER_MASK_HEX} option.
	 *	 <ul>
	 *		<li><tt>{@link kFLAG_MODIFIER_HASH_BIN}</tt>: If this bit is set, the resulting
	 *			value should be a 16 character binary string; if the bit is <tt>OFF</tt>,
	 *			the resulting value should be a 32 character hexadecimal string.
	 *	 </ul>
	 * </ul>
	 *
	 * The order in which these modifications are applied are as stated.
	 *
	 * @param string				$theString			String to normalise.
	 * @param bitfield				$theModifiers		Modifiers bitfield.
	 *
	 * @return mixed				Normalised string.
	 *
	 * @see kFLAG_DEFAULT, kFLAG_MODIFIER_MASK
	 * @see kFLAG_MODIFIER_UTF8
	 * @see kFLAG_MODIFIER_LTRIM, kFLAG_MODIFIER_RTRIM, kFLAG_MODIFIER_TRIM
	 * @see kFLAG_MODIFIER_NULL, kFLAG_MODIFIER_NULLSTR
	 * @see kFLAG_MODIFIER_NOCASE, kFLAG_MODIFIER_URL, kFLAG_MODIFIER_HTML
	 * @see kFLAG_MODIFIER_HEX, kFLAG_MODIFIER_HEXEXP
	 * @see kFLAG_MODIFIER_HASH, kFLAG_MODIFIER_HASH_BIN
	 */
	function StringNormalise( $theString, $theModifiers = kFLAG_DEFAULT )
	{
		//
		// Check if any modification was requested.
		//
		if( ($theString === NULL)							// NULL string,
		 || ($theModifiers === kFLAG_DEFAULT)				// or no modifiers,
		 || (! $theModifiers & kFLAG_MODIFIER_MASK) )		// or none relevant.
			return $theString;														// ==>
		
		//
		// We know now that something is to be done with the string.
		//
		
		//
		// Convert to string.
		//
		$string = (string) $theString;
		
		//
		// Encode string to UTF8.
		//
		if( $theModifiers & kFLAG_MODIFIER_UTF8 )
		{
			if( ! mb_check_encoding( $string, 'UTF-8' ) )
				$string = mb_convert_encoding( $string, 'UTF-8' );
		}
		
		//
		// Trim.
		//
		if( $theModifiers & kFLAG_MODIFIER_MASK_TRIM )
		{
			if( ($theModifiers & kFLAG_MODIFIER_TRIM) == kFLAG_MODIFIER_TRIM ) 
				$string = trim( $string );
			elseif( $theModifiers & kFLAG_MODIFIER_LTRIM )
				$string = ltrim( $string );
			else
				$string = rtrim( $string );
		}
		
		//
		// Handle empty string.
		//
		if( (! strlen( $string ))
		 && ($theModifiers & kFLAG_MODIFIER_MASK_NULL) )
		{
			//
			// Set to NULL string.
			//
			if( ($theModifiers & kFLAG_MODIFIER_NULLSTR) == kFLAG_MODIFIER_NULLSTR )
				return 'NULL';														// ==>
			
			return NULL;															// ==>
		
		} // Empty string and NULL mask.
		
		//
		// Set case insensitive.
		//
		if( $theModifiers & kFLAG_MODIFIER_NOCASE )
			$string = ( $theModifiers & kFLAG_MODIFIER_UTF8 )
					? mb_convert_case( $string, MB_CASE_LOWER, 'UTF-8' )
					: strtolower( $string );
		
		//
		// URL-encode.
		//
		if( $theModifiers & kFLAG_MODIFIER_URL )
			$string = urlencode( $string );
		
		//
		// HTML-encode.
		//
		elseif( $theModifiers & kFLAG_MODIFIER_HTML )
			$string = htmlspecialchars( $string );
		
		//
		// handle HEX conversion.
		//
		if( $theModifiers & kFLAG_MODIFIER_MASK_HEX )
		{
			//
			// Convert to HEX string.
			//
			$string = bin2hex( $string );
			
			//
			// Convert to HEX expression.
			//
			if( ($theModifiers & kFLAG_MODIFIER_MASK_HEX) == kFLAG_MODIFIER_HEXEXP )
				$string = "0x$string";
		
		} // HEX mask.
		
		//
		// Hash string.
		//
		elseif( $theModifiers & kFLAG_MODIFIER_MASK_HASH )
		{
			if( ($theModifiers & kFLAG_MODIFIER_HASH_BIN) == kFLAG_MODIFIER_HASH_BIN )
				return md5( $string, TRUE );										// ==>
			
			return md5( $string );													// ==>
		}
		
		return $string;																// ==>
		
	} // StringNormalise.

	 
	/*===================================================================================
	 *	DurationString																	*
	 *==================================================================================*/
	
	/**
	 * <h4>Return a formatted duration</h4>
	 *
	 * This function will return a formatted duration string in <tt>HH:MM:SS:mmmmm</tt>
	 * format, where <tt>H</tt> stands for hours, <tt>M</tt> stands for minutes, <tt>S</tt>
	 * stands for seconds and <tt>m</tt> stands for milliseconds, from the value of
	 * <tt>microtime( TRUE )</tt>.
	 *
	 * <i>Note: The provided value should be a difference between two timestamps taken with
	 * <tt>microtime( TRUE )</tt>.</i>
	 *
	 * @param float					$theTime			Microtime difference.
	 *
	 * @static
	 * @return string				Duration string as <tt>HH:MM:SS:mmmmm</tt>.
	 */
	function DurationString( $theTime )
	{
		$h = floor( $theTime / 3600.0 );
		$m = floor( ( $theTime - ( $h * 3600 ) ) / 60.0 );
		$s = floor( $theTime - ( ( $h * 3600 ) + ( $m * 60 ) ) );
		$l = $theTime - ( ( $h * 3600 ) + ( $m * 60 ) + $s );
		
		return sprintf( "%d:%02d:%02d:%04d", $h, $m, $s, ( $l * 10000 ) );			// ==>
	
	} // DurationString.


?>
