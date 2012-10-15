<?php

/*=======================================================================================
 *																						*
 *									COntology.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link COntology} definitions.
 *
 *	This file contains common definitions used by the {@link COntology} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 18/09/2012
 */

/*=======================================================================================
 *	DEFAULT PREDICATE TERM CODES														*
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
