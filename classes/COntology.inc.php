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
define( "kNODE_KIND_ROOT",						'R' );

/**
 * Trait node.
 *
 * This tag identifies a trait or measurable node kind.
 */
define( "kNODE_KIND_TRAIT",						'T' );

/**
 * Method node.
 *
 * This tag identifies a method node kind.
 */
define( "kNODE_KIND_METH",						'M' );

/**
 * Scale node.
 *
 * This tag identifies a scale or measure node kind.
 */
define( "kNODE_KIND_SCALE",						'S' );

/**
 * Enumeration node.
 *
 * This tag identifies an enumerated value node kind.
 */
define( "kNODE_KIND_ENUM",						'E' );

?>
