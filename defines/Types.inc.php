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
define( "kTYPE_STRING",						':STRING' );			// String.

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

/*=======================================================================================
 *	STRUCTURED DATA TYPE ENUMERATIONS													*
 *======================================================================================*/

/**
 * Structure.
 *
 * This data type refers to a structure, it implies that the offset to which it refers to
 * is a container of other offsets that will hold the actual data.
 */
define( "kTYPE_STRUCT",						':STRUCT' );			// Structure.

/**
 * Timestamp type.
 *
 * This data type should be used for native time-stamps.
 */
define( "kTYPE_STAMP",						':TIME-STAMP' );		// Timestamp.

/*=======================================================================================
 *	NODE DATA TYPES																		*
 *======================================================================================*/

/**
 * Enumeration type.
 *
 * This value represents the enumeration data type, it represents an enumeration element or
 * container.
 *
 * Enumerations represent a vocabulary from which one value must be chosen, this particular
 * data type is used in {@link COntologyNode} objects: it indicates that the node refers to
 * a controlled vocabulary scalar data type and that the enumerated set follows in the graph
 * definition.
 */
define( "kTYPE_ENUM",							':ENUM' );

/**
 * Set type.
 *
 * This value represents the enumerated set data type, it represents an enumerated set
 * element or container.
 *
 * Sets represent a vocabulary from which one or more value must be chosen, this particular
 * data type is used in {@link COntologyNode} objects: it indicates that the node refers to
 * a controlled vocabulary array data type and that the enumerated set follows in the graph
 * definition.
 */
define( "kTYPE_ENUM_SET",						':SET' );

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
 *	DEFAULT NODE KINDS																	*
 *======================================================================================*/

/**
 * Root node.
 *
 * This tag identifies a root or ontology node kind.
 */
define( "kKIND_NODE_ROOT",						':ROOT' );

/**
 * Data dictionary node.
 *
 * This tag identifies a structure definition or data dictionary node kind, in general this
 * will be used in conjunction to the {@link kKIND_NODE_ROOT} node kind to indicate a data
 * structure description.
 */
define( "kKIND_NODE_DDICT",						':DDICT' );

/**
 * Trait node.
 *
 * This tag identifies a trait or measurable node kind.
 */
define( "kKIND_NODE_TRAIT",						':TRAIT' );

/**
 * Method node.
 *
 * This tag identifies a method node kind.
 */
define( "kKIND_NODE_METHOD",					':METHOD' );

/**
 * Scale node.
 *
 * This tag identifies a scale or measure node kind.
 */
define( "kKIND_NODE_SCALE",						':SCALE' );

/**
 * Enumeration node.
 *
 * This tag identifies an enumeration node kind.
 */
define( "kKIND_NODE_ENUMERATION",				':ENUMERATION' );

/**
 * Instance node.
 *
 * This tag identifies an instance node kind.
 */
define( "kKIND_NODE_INSTANCE",					':INSTANCE' );

/*=======================================================================================
 *	DEFAULT PREDICATES																	*
 *======================================================================================*/

/**
 * SUBCLASS-OF.
 *
 * This tag identifies the SUBCLASS-OF predicate term local code, this predicate indicates
 * that the subject of the relationship is a subclass of the object of the relationship, in
 * other words, the subject is derived from the object.
 *
 * Note that this term is expected to belong to the default namespace which has an empty
 * local identifier.
 */
define( "kPREDICATE_SUBCLASS_OF",				':SUBCLASS-OF' );

/**
 * SUBSET-OF.
 *
 * This tag identifies the SUBSET-OF predicate term local code, this predicate indicates
 * that the subject of the relationship represents a subset of the object of the
 * relationship, in other words, the subject is a subset of the object, or the subject is
 * contained by the object.
 *
 * Note that this term is expected to belong to the default namespace which has an empty
 * local identifier.
 */
define( "kPREDICATE_SUBSET_OF",					':SUBSET-OF' );

/**
 * METHOD-OF.
 *
 * This tag identifies the METHOD-OF predicate term local code, this predicate relates
 * method nodes with trait nodes or other method nodes, it indicates that the subject of the
 * relationship is a method variation of the object of the relationship.
 *
 * Note that this term is expected to belong to the default namespace which has an empty
 * local identifier.
 */
define( "kPREDICATE_METHOD_OF",					':METHOD-OF' );

/**
 * SCALE-OF.
 *
 * This tag identifies the SCALE-OF predicate term local code, this predicate relates scale
 * nodes with Method or trait nodes, it indicates that the subject of the relationship
 * represents a scale or measure that is used by a trait or method node.
 *
 * Note that this term is expected to belong to the default namespace which has an empty
 * local identifier.
 */
define( "kPREDICATE_SCALE_OF",					':SCALE-OF' );

/**
 * ENUM-OF.
 *
 * This tag identifies the ENUM-OF predicate term local code, this predicate relates
 * enumerated set elements or controlled vocabulary elements.
 *
 * Note that this term is expected to belong to the default namespace which has an empty
 * local identifier.
 */
define( "kPREDICATE_ENUM_OF",					':ENUM-OF' );

/**
 * PREFERRED.
 *
 * This tag identifies the PREFERRED predicate term local code, this predicate indicates
 * that the object of the relationship is the preferred choice, in other words, if possible,
 * one should use the object of the relationship in place of the subject.
 *
 * Note that this term is expected to belong to the default namespace which has an empty
 * local identifier.
 */
define( "kPREDICATE_PREFERRED",					':PREFERRED' );

/**
 * VALID.
 *
 * This tag identifies the VALID predicate term local code, this predicate indicates
 * that the object of the relationship is the valid choice, in other words, the subject of
 * the relationship is obsolete or not valid, and one should use the object od the
 * relationship in its place.
 *
 * Note that this term is expected to belong to the default namespace which has an empty
 * local identifier.
 */
define( "kPREDICATE_VALID",						':VALID' );

/**
 * LEGACY.
 *
 * This tag identifies the LEGACY predicate term local code, this predicate indicates
 * that the object of the relationship is the former or legacy choice, in other words, the
 * object of the relationship is obsolete or not valid, and one should use the subject of
 * the relationship in its place.
 *
 * Note that this term is expected to belong to the default namespace which has an empty
 * local identifier.
 */
define( "kPREDICATE_LEGACY",					':LEGACY' );

/**
 * XREF-EXACT.
 *
 * This tag identifies the XREF-EXACT predicate term local code, this predicate indicates
 * that the subject and the object of the relationship represent an exact cross-reference,
 * in other words, both elements are interchangeable.
 *
 * Note that this term is expected to belong to the default namespace which has an empty
 * local identifier.
 */
define( "kPREDICATE_XREF_EXACT",				':XREF-EXACT' );


?>
