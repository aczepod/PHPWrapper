<?php

/*=======================================================================================
 *																						*
 *									CContainer.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link CContainer} definitions.
 *
 *	This file contains common definitions used by the {@link CContainer} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 11/09/2012
 */

/*=======================================================================================
 *	DEFAULT OFFSETS																		*
 *======================================================================================*/

/**
 * Sequence.
 *
 * This tag identifies a sequence key, the value corresponds to an offset that represents
 * the key to a number sequence generator. This offset is used by container objects that are
 * able to function as sequence number generators.
 */
define( "kOFFSET_SEQUENCE",						'_seq' );

/*=======================================================================================
 *	DEFAULT CONTAINER NAMES																*
 *======================================================================================*/

/**
 * Sequence container name.
 *
 * This tag identifies the default sequences container name, this can be used as the default
 * container name where sequence numbers are stored.
 */
define( "kCONTAINER_SEQUENCE_NAME",				'_sequences' );

?>
