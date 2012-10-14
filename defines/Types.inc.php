<?php

/*=======================================================================================
 *																						*
 *									Types.inc.php										*
 *																						*
 *======================================================================================*/
 
/**
 *	Enumerations.
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
define( "kTYPE_STRING",						':STR' );				// String.

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
define( "kTYPE_BOOLEAN",					':BOOL' );				// Boolean.

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
define( "kTYPE_BINARY",						':BIN' );				// Binary.

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
define( "kTYPE_DATE",						':DATE' );				// Date.

/**
 * Time type.
 *
 * This value represents a time represented as a <i>YYYY-MM-DD HH:MM:SS</i> string in which
 * you may not have missing elements.
 *
 * This type is functionally identical to a {@link kTYPE_STRING} type, except that its
 * contents are expected to have a specific structure.
 */
define( "kTYPE_TIME",						':TIME' );				// Time.

/*=======================================================================================
 *	STRUCTURED DATA TYPE ENUMERATIONS													*
 *======================================================================================*/

/**
 * Timestamp type.
 *
 * This data type should be used for native time-stamps.
 */
define( "kTYPE_STAMP",						':STAMP' );				// Timestamp.

/**
 * Coded list.
 *
 * This data type refers to a list of elements containing two items: a code an the data.
 * No two elements mat share the same code and only one element may omit the code.
 */
define( "kTYPE_CODED_LIST",					':LIST-CODED' );		// Coded list.

/*=======================================================================================
 *	STRUCTURED DATA TYPE OFFSETS														*
 *======================================================================================*/

/**
 * Language code.
 *
 * This tag is used as a sub-offset of the {@link kTYPE_CODED_LIST} type elements, it
 * is expected to contain a language character code identifying the language in which the
 * {@link kTYPE_CODED_LIST} instance element is expressed in.
 */
define( "kOFFSET_LANGUAGE",					'_language' );

/**
 * Data.
 *
 * This tag is used in structured data types as the sub-offset of the item holding the data.
 * For instance in {@link kTYPE_CODED_LIST} structures, this will be the offset holding the
 * actual string.
 */
define( "kOFFSET_DATA",						'_data' );


?>
