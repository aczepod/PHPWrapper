<?php

/*=======================================================================================
 *																						*
 *										Flags.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	Status flags.
 *
 *	This file contains the common status flags used by all classes in this library.
 *
 *	@package	MyWrapper
 *	@subpackage	Definitions
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 03/05/2009
 *				2.00 23/11/2010
 *				3.00 13/02/2012
 *				4.00 03/09/2012
 */

/*=======================================================================================
 *	OBJECT STATUS FLAGS																	*
 *======================================================================================*/

/**
 * State: Initialised.
 *
 * This bitfield value indicates that the object has been initialised, this means that all
 * required data members are present.
 *
 * If this flag is not set, it means that the object lacks required elements, thus it will
 * not work correctly, or it cannot be stored persistently.
 */
define( "kFLAG_STATE_INITED",			0x00000001 );		// Initialised.

/**
 * State: Dirty.
 *
 * This bitfield value indicates that the object has been modified. In general this state is
 * only triggered by modifications to persistent data members; run time members should not
 * be included. Methods that serialise or modify the contents of the object should
 * respectively reset and set this flag.
 *
 * If the flag is not set, this means that the object has not been modified;
 */
define( "kFLAG_STATE_DIRTY",			0x00000002 );		// Dirty.

/**
 * State: Committed.
 *
 * This bitfield value indicates that the object has been either loaded from a persistent
 * container, or that it has been saved to a persistent container.
 *
 * If the flag is off, this means that the object was not instantiated from a persistent
 * container, or that it was not committed to a persistent container.
 */
define( "kFLAG_STATE_COMMITTED",		0x00000004 );		// Committed.

/**
 * State: Encoded.
 *
 * This bitfield value indicates an encoded state. This status is usually associated to
 * persistent objects that need to be transmitted via the network: an encoded object knows
 * how to serialise properties that cannot be directly represented in formats used to
 * transmit data over the internet, such as JSON.
 *
 * In general, if this flag is set, the object has the knowledge on how to convert its
 * members before being transmitted and on how to convert the serialised values back to
 * native state.
 */
define( "kFLAG_STATE_ENCODED",			0x00000008 );		// Encoded.

/*=======================================================================================
 *	OBJECT STATUS FLAGS - MASKS															*
 *======================================================================================*/

/**
 * State mask.
 *
 * This value masks all the state flags.
 */
define( "kFLAG_STATE_MASK",				0x0000000F );		// State mask.

/*=======================================================================================
 *	PERSISTENCE ACTION FLAGS															*
 *======================================================================================*/

/**
 * Persist: Insert.
 *
 * This bitfield value indicates that we intend to <i>insert</i> an object in a container,
 * this means that the operation should fail if there is a duplicate.
 */
define( "kFLAG_PERSIST_INSERT",			0x00000010 );		// Insert.

/**
 * Persist: Update.
 *
 * This bitfield value indicates that we intend to <i>update</i> an object in a container,
 * this means that the operation should fail if the object is not already present in the
 * container. This operation also assumes that the provided object will replace the entire
 * contents of the existing one.
 */
define( "kFLAG_PERSIST_UPDATE",			0x00000020 );		// Update.

/**
 * Persist: Replace.
 *
 * This bitfield value indicates that we intend to <i>insert</i> a non existing object or
 * <i>update</i> an existing object. It is the combination of the
 * {@link kFLAG_PERSIST_INSERT} and the {@link kFLAG_PERSIST_UPDATE} flags.
 */
define( "kFLAG_PERSIST_REPLACE",		0x00000030 );		// Replace.

/**
 * Persist: Modify.
 *
 * This bitfield value indicates that we intend to <i>modify</i> the contents of one or
 * more objects in a container. Since the operation does not consider the object as a
 * whole, it can be applied to one or more objects according to a selection criteria.
 */
define( "kFLAG_PERSIST_MODIFY",			0x00000060 );		// Modify.

/**
 * Persist: Delete.
 *
 * This bitfield value indicates that we intend to <i>delete</i> an object from a
 * container. If the object doesn't exist, the operation should still succeed.
 */
define( "kFLAG_PERSIST_DELETE",			0x00000080 );		// Delete.

/*=======================================================================================
 *	PERSISTENCE ACTION FLAGS - MASKS													*
 *======================================================================================*/

/**
 * Write mask.
 *
 * This value masks the access flags that imply writing to the collection, with the
 * exception of the delete ({@link kFLAG_PERSIST_DELETE}) option.
 */
define( "kFLAG_PERSIST_WRITE_MASK",		0x00000070 );		// Write mask.

/**
 * Persist mask.
 *
 * This value masks all the persistence action flags.
 */
define( "kFLAG_PERSIST_MASK",			0x000000F0 );		// Persist mask.

/*=======================================================================================
 *	PERSISTENCE MODIFICATION FLAGS														*
 *======================================================================================*/

/**
 * Modify: Increment.
 *
 * This bitfield value indicates that we intend to increment a value of a field, if the
 * field does not exist, the provided increment value will be set in the field. This option
 * works in conjunction with the {@link kFLAG_PERSIST_MODIFY} flag.
 */
define( "kFLAG_MODIFY_INCREMENT",		0x00000100 );		// Increment.

/**
 * Modify: Append.
 *
 * This bitfield value indicates that we intend to append a value to an existing field, if
 * field is not present, an array with the provided value will be set in the field; if the
 * field does not contain an array, an error should occur. This option works in conjunction
 * with the {@link kFLAG_PERSIST_MODIFY} flag.
 */
define( "kFLAG_MODIFY_APPEND",			0x00000200 );		// Append.

/**
 * Modify: Add to set.
 *
 * This bitfield value indicates that we intend to add a value to an existing array field
 * only if this value is not yet present in the receiving array, the options are the same as
 * for the {@link kFLAG_MODIFY_APPEND} flag. This option works in conjunction with the
 * {@link kFLAG_PERSIST_MODIFY} flag.
 */
define( "kFLAG_MODIFY_ADDSET",			0x00000400 );		// Add to set.

/**
 * Modify: Pop.
 *
 * This bitfield value indicates that we intend to remove the first or last element of an
 * array, depending on an application defined parameter. This option works in conjunction
 * with the {@link kFLAG_PERSIST_MODIFY} flag.
 */
define( "kFLAG_MODIFY_POP",				0x00000A00 );		// Pop.

/**
 * Modify: Pull.
 *
 * This bitfield value indicates that we intend to remove all occurrences of a value from
 * an array. If the field exists, but it is not an array, an error should be raised. This
 * option must be provided in conjunction with the {@link kFLAG_PERSIST_MODIFY} flag.
 */
define( "kFLAG_MODIFY_PULL",			0x00000C00 );		// Pull.

/*=======================================================================================
 *	PERSISTENCE MODIFICATION FLAGS - MASKS												*
 *======================================================================================*/

/**
 * Modifications mask.
 *
 * This value masks the access flags that indicate modification options to the
 * {@link kFLAG_PERSIST_MODIFY} persistence action.
 */
define( "kFLAG_MODIFY_MASK",			0x00000F00 );		// Modifications mask.

/*=======================================================================================
 *	STRING MODIFIER FLAGS																*
 *======================================================================================*/

/**
 * Modifier: UTF8 convert.
 *
 * If the flag is set, the string will be converted to the UTF8 character set.
 */
define( "kFLAG_MODIFIER_UTF8",			0x00001000 );		// Convert to UTF8.

/**
 * Modifier: Left trim.
 *
 * If the flag is set the string will be left trimmed.
 *
 * This modification will be applied after the eventual {@link kFLAG_MODIFIER_UTF8}
 * conversion.
 */
define( "kFLAG_MODIFIER_LTRIM",			0x00002000 );		// Left trim.

/**
 * Modifier: Right trim.
 *
 * If the flag is set the string will be right trimmed.
 *
 * This modification will be applied after the eventual {@link kFLAG_MODIFIER_UTF8}
 * conversion.
 */
define( "kFLAG_MODIFIER_RTRIM",			0x00004000 );		// Left trim.

/**
 * Modifier: Trim.
 *
 * If the flag is set the string will be trimmed, both left and right.
 *
 * This modification will be applied after the eventual {@link kFLAG_MODIFIER_UTF8}
 * conversion.
 */
define( "kFLAG_MODIFIER_TRIM",			0x00006000 );		// Trim.

/**
 * Modifier: NULL.
 *
 * If the flag is set and the string is empty, it will be converted to <tt>NULL</tt>.
 *
 * This modification will be applied after the eventual {@link kFLAG_MODIFIER_UTF8} and
 * {@link kFLAG_MODIFIER_TRIM} conversions
 */
define( "kFLAG_MODIFIER_NULL",			0x00008000 );		// NULL.

/**
 * Modifier: NULL string.
 *
 * If the flag is set and the string is empty, it will be converted to the '<tt>NULL</tt>'
 * string.
 *
 * This modification will be applied after the eventual {@link kFLAG_MODIFIER_UTF8} and
 * {@link kFLAG_MODIFIER_TRIM} conversions
 */
define( "kFLAG_MODIFIER_NULLSTR",		0x00018000 );		// NULL string.

/**
 * Modifier: Case insensitive.
 *
 * If the flag is set, the string will be set to lowercase, the default case insensitive
 * modifier.
 *
 * This modification will be applied after the eventual {@link kFLAG_MODIFIER_UTF8},
 * {@link kFLAG_MODIFIER_TRIM} and {@link kFLAG_MODIFIER_NULL} conversions.
 */
define( "kFLAG_MODIFIER_NOCASE",		0x00020000 );		// Case insensitive.

/**
 * Modifier: Encode for URL.
 *
 * If the flag is set, the string will be URL-encoded; this option and
 * {@link kFLAG_MODIFIER_HTML} are mutually exclusive.
 *
 * This modification will be applied after the eventual {@link kFLAG_MODIFIER_UTF8},
 * {@link kFLAG_MODIFIER_TRIM}, {@link kFLAG_MODIFIER_NULL} and
 * {@link kFLAG_MODIFIER_NOCASE} conversions.
 */
define( "kFLAG_MODIFIER_URL",			0x00040000 );		// URL-encode.

/**
 * Modifier: Encode for HTML.
 *
 * If the flag is set, the string will be URL-encoded; this option and
 * {@link kFLAG_MODIFIER_URL} are mutually exclusive.
 *
 * This modification will be applied after the eventual {@link kFLAG_MODIFIER_UTF8},
 * {@link kFLAG_MODIFIER_TRIM}, {@link kFLAG_MODIFIER_NULL} and
 * {@link kFLAG_MODIFIER_NOCASE} conversions.
 */
define( "kFLAG_MODIFIER_HTML",			0x00080000 );		// HTML-encode.

/**
 * Modifier: HEX.
 *
 * If the flag is set the string will be converted to a hexadecimal string; this option is
 * mutually exclusive with the {@link kFLAG_MODIFIER_HASH} and
 * {@link kFLAG_MODIFIER_HASH_BIN} flags.
 *
 * This modification will be applied after the eventual {@link kFLAG_MODIFIER_UTF8},
 * {@link kFLAG_MODIFIER_TRIM}, {@link kFLAG_MODIFIER_NULL}, {@link kFLAG_MODIFIER_NOCASE},
 * {@link kFLAG_MODIFIER_URL} or {@link kFLAG_MODIFIER_HTML} conversions.
 */
define( "kFLAG_MODIFIER_HEX",			0x00100000 );		// Convert to hexadecimal.

/**
 * Modifier: HEX expression.
 *
 * If the flag is set the string will be converted to a hexadecimal string suitable to be
 * used in an expression (<tt>0xABCD</tt>); this option is mutually exclusive with the
 * {@link kFLAG_MODIFIER_HASH} and {@link kFLAG_MODIFIER_HASH_BIN} flags.
 *
 * This modification will be applied after the eventual {@link kFLAG_MODIFIER_UTF8},
 * {@link kFLAG_MODIFIER_TRIM}, {@link kFLAG_MODIFIER_NULL}, {@link kFLAG_MODIFIER_NOCASE},
 * {@link kFLAG_MODIFIER_URL} or {@link kFLAG_MODIFIER_HTML} conversions.
 */
define( "kFLAG_MODIFIER_HEXEXP",		0x00300000 );		// Convert to hexadecimal expr.

/**
 * Modifier: hash.
 *
 * If the flag is set, the string will be hashed into a 32 character hex string; this option
 * is mutually exclusive with the {@link kFLAG_MODIFIER_HEX} and
 * {@link kFLAG_MODIFIER_HEXEXP} flags.
 *
 * This modification will be applied after the eventual {@link kFLAG_MODIFIER_UTF8},
 * {@link kFLAG_MODIFIER_TRIM}, {@link kFLAG_MODIFIER_NULL}, {@link kFLAG_MODIFIER_NOCASE},
 * {@link kFLAG_MODIFIER_URL} or {@link kFLAG_MODIFIER_HTML} conversions.
 */
define( "kFLAG_MODIFIER_HASH",			0x00400000 );		// Hash to 32 character hex.

/**
 * Modifier: binary hash.
 *
 * If the flag is set, the string will be hashed and the resulting string will be
 * a 16 character binary string; this option is mutually exclusive with the
 * {@link kFLAG_MODIFIER_HEX} and {@link kFLAG_MODIFIER_HEXEXP} flags.
 *
 * This modification will be applied after the eventual {@link kFLAG_MODIFIER_UTF8},
 * {@link kFLAG_MODIFIER_TRIM}, {@link kFLAG_MODIFIER_NULL}, {@link kFLAG_MODIFIER_NOCASE},
 * {@link kFLAG_MODIFIER_URL} or {@link kFLAG_MODIFIER_HTML} conversions.
 */
define( "kFLAG_MODIFIER_HASH_BIN",		0x00C00000 );		// Hash to 16 character binary.

/*=======================================================================================
 *	STRING MODIFIER FLAGS - MASKS														*
 *======================================================================================*/

/**
 * TRIM mask.
 *
 * This value masks both trim flags.
 */
define( "kFLAG_MODIFIER_MASK_TRIM",		0x00006000 );		// Trim mask.

/**
 * NULL mask.
 *
 * This value masks both the NULL flags.
 */
define( "kFLAG_MODIFIER_MASK_NULL",		0x00018000 );		// NULL mask.

/**
 * HEX mask.
 *
 * This value masks both the HEX flags.
 */
define( "kFLAG_MODIFIER_MASK_HEX",		0x00300000 );		// HEX mask.

/**
 * Hash mask.
 *
 * This value masks the both hash flags.
 */
define( "kFLAG_MODIFIER_MASK_HASH",		0x00C00000 );		// Hash mask.

/**
 * Modifiers mask.
 *
 * This value masks the string modifier flags.
 */
define( "kFLAG_MODIFIER_MASK",			0x00FFF000 );		// Mask.

/*=======================================================================================
 *	DEFAULT FLAGS																		*
 *======================================================================================*/

/**
 * Default state.
 *
 * This bitfield value represents the default flags state.
 */
define( "kFLAG_DEFAULT",				0x00000000 );		// Default mask.

/**
 * Status mask.
 *
 * This bitfield value represents the default flags mask.
 */
define( "kFLAG_DEFAULT_MASK",			0x7FFFFFFF );		// Default flags mask.


?>
