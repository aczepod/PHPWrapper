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
 *	DEFAULT NODE KINDS																	*
 *======================================================================================*/

/**
 * Root node.
 *
 * This tag identifies a root or ontology node kind.
 */
define( "kNODE_KIND_ROOT",						'ROOT' );

/**
 * Trait node.
 *
 * This tag identifies a trait or measurable node kind.
 */
define( "kNODE_KIND_TRAIT",						'TRAIT' );

/**
 * Method node.
 *
 * This tag identifies a method node kind.
 */
define( "kNODE_KIND_METH",						'METHOD' );

/**
 * Scale node.
 *
 * This tag identifies a scale or measure node kind.
 */
define( "kNODE_KIND_SCALE",						'SCALE' );

/**
 * Enumeration node.
 *
 * This tag identifies an enumerated value node kind.
 */
define( "kNODE_KIND_ENUM",						'ENUM' );

/*=======================================================================================
 *	DEFAULT PREDICATE TERM CODES														*
 *======================================================================================*/

/**
 * SUBCLASS-OF.
 *
 * This tag identifies the SUBCLASS-OF predicate term local code, this predicate is
 * equivalent to the <i>is-a</i> OBO predicate.
 *
 * Note that this term is expected to belong to the default namespace which has an empty
 * local identifier.
 */
define( "kPREDICATE_SUBCLASS_OF",				'SUBCLASS-OF' );

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
define( "kPREDICATE_METHOD_OF",					'METHOD-OF' );

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
define( "kPREDICATE_SCALE_OF",					'SCALE-OF' );

/**
 * ENUM-OF.
 *
 * This tag identifies the ENUM-OF predicate term local code, this predicate relates
 * enumerated set elements or controlled vocabulary elements.
 *
 * Note that this term is expected to belong to the default namespace which has an empty
 * local identifier.
 */
define( "kPREDICATE_ENUM_OF",					'ENUM-OF' );

?>
