<?php

/*=======================================================================================
 *																						*
 *								COntologyTag.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link COntologyTag} definitions.
 *
 *	This file contains common definitions used by the {@link COntologyTag} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 18/09/2012
 */

/*=======================================================================================
 *	DEFAULT OFFSETS																		*
 *======================================================================================*/

/**
 * Term references.
 *
 * This tag identifies the offset that will contain the list of identifiers of the terms
 * referenced by the tag path's vertex elements.
 */
define( "kOFFSET_TERM_LIST",					'_terms' );

/*=======================================================================================
 *	DEFAULT CONTAINER NAMES																*
 *======================================================================================*/

/**
 * Tags container name.
 *
 * This symbol identifies the default name for the container that will host tag objects.
 */
define( "kCONTAINER_TAG_NAME",					'_tags' );

/*=======================================================================================
 *	DEFAULT SEQUENCE KEY																*
 *======================================================================================*/

/**
 * Tag sequence.
 *
 * This tag identifies the default sequence key associated with tags.
 */
define( "kSEQUENCE_KEY_TAG",					'@tag' );

?>
