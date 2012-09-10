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
 *	DEFAULT OFFSETS																		*
 *======================================================================================*/

/**
 * Namespace references.
 *
 * This tag identifies namespace references, the attribute contains the count of how many
 * times the term was referenced as a namespace.
 */
define( "kOFFSET_REFS_NAMESPACE",				'_nsr' );

/**
 * Node references.
 *
 * This tag identifies node references, the attribute contains the list of identifiers of
 * nodes that reference the current object.
 */
define( "kOFFSET_REFS_NODE",					'_nor' );

/**
 * Tag references.
 *
 * This tag identifies tag references, the attribute contains the list of identifiers of
 * tags that reference the current term.
 */
define( "kOFFSET_REFS_TAG",						'_tgr' );

?>
