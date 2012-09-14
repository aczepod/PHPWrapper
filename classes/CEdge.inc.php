<?php

/*=======================================================================================
 *																						*
 *									CEdge.inc.php										*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link CEdge} definitions.
 *
 *	This file contains common definitions used by the {@link CEdge} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 11/09/2012
 */

/*=======================================================================================
 *	DEFAULT OFFSETS																		*
 *======================================================================================*/

/**
 * Subject reference.
 *
 * This tag identifies the reference to the subject vertex of a subject/predicate/object
 * triplet in a graph.
 */
define( "kOFFSET_VERTEX_SUBJECT",				'_vsb' );

/**
 * Predicate reference.
 *
 * This tag identifies the reference to the predicate object of a subject/predicate/object
 * triplet in a graph.
 */
define( "kOFFSET_PREDICATE",					'_prd' );

/**
 * Object reference.
 *
 * This tag identifies the reference to the object vertex of a subject/predicate/object
 * triplet in a graph.
 */
define( "kOFFSET_VERTEX_OBJECT",				'_vob' );

?>
