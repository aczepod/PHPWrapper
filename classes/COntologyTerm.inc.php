<?php

/*=======================================================================================
 *																						*
 *								COntologyTerm.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link COntologyTerm} definitions.
 *
 *	This file contains common definitions used by the {@link COntologyTerm} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 08/09/2012
 */

/*=======================================================================================
 *	DEFAULT CONTAINER NAMES																*
 *======================================================================================*/

/**
 * Terms container name.
 *
 * This tag identifies the default name for the container that will host term objects.
 */
define( "kCONTAINER_TERM_NAME",					'_terms' );

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
