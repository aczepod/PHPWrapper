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
 *	PRIMITIVE DATA TYPE ENUMERATIONS													*
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
 *
 * This data type is serialised as foillows:
 *
 * <ul>
 *	<li><i>{@link kTAG_TYPE kTAG_TYPE}</i>: Will contain this constant.
 *	<li><i>{@link kTAG_DATA kTAG_DATA}</i>: Will contain the string representation of the
 *		integer.
 * </ul>
 */
define( "kTYPE_INT32",						':INT32' );				// 32 bit integer.

/**
 * 64 bit signed integer type.
 *
 * This value represents the primitive 64 bit signed integer data type.
 *
 * This data type is serialised as foillows:
 *
 * <ul>
 *	<li><i>{@link kTAG_TYPE kTAG_TYPE}</i>: Will contain this constant.
 *	<li><i>{@link kTAG_DATA kTAG_DATA}</i>: Will contain the string representation of the
 *		integer.
 * </ul>
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
 *	COMPOSITE DATA TYPE ENUMERATIONS													*
 *======================================================================================*/

/**
 * Binary type.
 *
 * This value represents a binary string data type, it is generally expressed as an instance
 * of the {@link CDataTypeBinary CDataTypeBinary} class.
 */
define( "kTYPE_BINARY",						':BIN' );				// Binary.

/**
 * Date type.
 *
 * This value represents a date represented as a <i>YYYYMMDD</i> string in which missing
 * elements should be omitted. This means that if we don't know the day we can express that
 * date as <i>YYYYMM</i>.
 */
define( "kTYPE_DATE",						':DATE' );				// Date.

/**
 * Time type.
 *
 * This value represents a time represented as a <i>YYYY-MM-DD HH:MM:SS</i> string in which
 * you may not have missing elements.
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
 * Enumeration type.
 *
 * This value represents the enumeration data type, it represents an enumeration element or
 * container.
 *
 * Enumerations represent a vocabulary from which one value must be chosen.
 */
define( "kTYPE_ENUM",						':ENUM' );				// Enumeration.

/**
 * Set type.
 *
 * This value represents the enumerated set data type, it represents an enumerated set
 * element or container.
 *
 * Sets represent a vocabulary from which one or more value must be chosen.
 */
define( "kTYPE_ENUM_SET",					':SET' );				// Set.


?>
