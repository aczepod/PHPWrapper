<?php

/*=======================================================================================
 *																						*
 *									Types.inc.php										*
 *																						*
 *======================================================================================*/
 
/**
 *	Data types.
 *
 *	This file contains common data types used by all classes.
 *
 *	@package	MyWrapper
 *	@subpackage	Definitions
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 19/09/2012
 */

/*=======================================================================================
 *	PRIMITIVE DATA TYPES																*
 *======================================================================================*/

/**
 * String type.
 *
 * This tag represents the primitive string data type.
 */
define( "kTYPE_STRING",						':TEXT' );				// String.

/**
 * 32 bit signed integer type.
 *
 * This value represents the primitive 32 bit signed integer data type.
 */
define( "kTYPE_INT32",						':INT32' );				// 32 bit integer.

/**
 * 64 bit signed integer type.
 *
 * This value represents the primitive 64 bit signed integer data type.
 */
define( "kTYPE_INT64",						':INT64' );				// 64 bit integer.

/**
 * Float type.
 *
 * This value represents the primitive floating point data type.
 */
define( "kTYPE_FLOAT",						':FLOAT' );				// Float.

/**
 * Boolean type.
 *
 * This value represents the primitive boolean data type, it is assumed that it is provided
 * as (y/n; Yes/No; 1/0; TRUE/FALSE) and will be converted to 1/0.
 */
define( "kTYPE_BOOLEAN",					':BOOLEAN' );			// Boolean.

/**
 * Any type.
 *
 * This value represents the primitive wildcard type, it qualifies an attribute that can
 * take any kind of value.
 */
define( "kTYPE_ANY",						':ANY' );				// Any.

/*=======================================================================================
 *	PRIMITIVE DATA TYPE VARIATIONS														*
 *======================================================================================*/

/**
 * Binary type.
 *
 * This value represents a binary string data type, it differs from the {@link kTYPE_STRING}
 * type only because it needs to be handled in a custom way to accomodate different
 * databases.
 */
define( "kTYPE_BINARY",						':BINARY' );			// Binary.

/**
 * Date type.
 *
 * This value represents a date represented as a <i>YYYYMMDD</i> string in which missing
 * elements should be omitted. This means that if we don't know the day we can express that
 * date as <i>YYYYMM</i>.
 *
 * This type is functionally identical to a {@link kTYPE_STRING} type, except that its
 * contents are expected to have a specific structure.
 */
define( "kTYPE_DATE",						':DATE-STRING' );		// Date.

/**
 * Time type.
 *
 * This value represents a time represented as a <i>YYYY-MM-DD HH:MM:SS</i> string in which
 * you may not have missing elements.
 *
 * This type is functionally identical to a {@link kTYPE_STRING} type, except that its
 * contents are expected to have a specific structure.
 */
define( "kTYPE_TIME",						':TIME-STRING' );		// Time.

/**
 * Regular expression type.
 *
 * This tag defines a regular expression string type, it is generally expressed as an
 * instance of the {@link CDataTypeRegex} class.
 */
define( "kTYPE_REGEX",						':REGEX' );				// Regular expression.

/*=======================================================================================
 *	STRUCTURED DATA TYPE ENUMERATIONS													*
 *======================================================================================*/

/**
 * Language strings list.
 *
 * This data type represents a string attribute that can be expressed in several languages,
 * it is implemented as an array of two elements:
 *
 * <ul>
 *	<li><tt>kTAG_STRING</tt>: This element holds the language code of the string.
 *	<li><tt>kTAG_LANGUAGE</tt>: This element holds the language code of the string.
 * </ul>
 */
define( "kTYPE_LSTRING",					':LSTRING' );			// Language strings.

/**
 * Timestamp type.
 *
 * This data type should be used for native time-stamps.
 */
define( "kTYPE_STAMP",						':TIME-STAMP' );		// Timestamp.

/**
 * Structure.
 *
 * This data type refers to a structure, it implies that the offset to which it refers to
 * is a container of other offsets that will hold the actual data.
 */
define( "kTYPE_STRUCT",						':STRUCT' );			// Structure.

/*=======================================================================================
 *	FORMAT TYPES																		*
 *======================================================================================*/

/**
 * PHP-encoded.
 *
 * This tag represents the PHP serialised data format.
 */
define( "kTYPE_PHP",							':PHP' );

/**
 * JSON-encoded.
 *
 * This tag represents the JSON serialised data format.
 */
define( "kTYPE_JSON",							':JSON' );

/**
 * XML-encoded.
 *
 * This tag represents the generic XML serialised data format.
 */
define( "kTYPE_XML",							':XML' );

/**
 * SVG-encoded.
 *
 * This tag represents the SVG image serialised data format.
 */
define( "kTYPE_SVG",							':SVG' );

/*=======================================================================================
 *	CARDINALITY TYPES																	*
 *======================================================================================*/

/**
 * Required.
 *
 * This tag indicates that the element is required, which means that the offset must be
 * present in the object.
 */
define( "kTYPE_CARD_REQUIRED",					':REQUIRED' );

/**
 * Array.
 *
 * This tag indicates that the element represents an array and that the data type applies
 * to the elements of the array.
 */
define( "kTYPE_CARD_ARRAY",						':ARRAY' );

/*=======================================================================================
 *	MONGODB DATA TYPES																	*
 *======================================================================================*/

/**
 * MongoId.
 *
 * This value represents the MongoId object data type, when serialised it will have the
 * following structure:
 *
 * <ul>
 *	<li><i>{@link kTAG_TYPE kTAG_TYPE}</i>: Will contain this constant.
 *	<li><i>{@link kTAG_CUSTOM_DATA kTAG_CUSTOM_DATA}</i>: Will contain the HEX string ID.
 * </ul>
 */
define( "kTYPE_MongoId",					':MongoId' );			// MongoId.

/**
 * MongoCode.
 *
 * This value represents the MongoCode object data type, when serialised it will have the
 * following structure:
 *
 * <ul>
 *	<li><i>{@link kTAG_TYPE kTAG_TYPE}</i>: Will contain this constant.
 *	<li><i>{@link kTAG_CUSTOM_DATA kTAG_CUSTOM_DATA}</i>: Will contain the following structure:
 *	 <ul>
 *		<li><i>code</i>: The javascript code string.
 *		<li><i>scope</i>: The list of key/value pairs.
 *	 </ul>
 * </ul>
 */
define( "kTYPE_MongoCode",					':MongoCode' );		// MongoCode.


?>
