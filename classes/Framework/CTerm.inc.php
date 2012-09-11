<?php

/*=======================================================================================
 *																						*
 *									CTerm.inc.php										*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link CTerm} definitions.
 *
 *	This file contains common definitions used by the {@link CTerm} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 08/09/2012
 */

/*=======================================================================================
 *	DEFAULT OFFSETS																		*
 *======================================================================================*/

/**
 * Local unique identifier.
 *
 * This tag identifies the attribute that contains the local or full unique identifier.
 * This value represents the identifier that uniquely identifies an object within a specific
 * domain or namespace. It is by default a string constituting a portion of the global
 * unique identifier, {@link kOFFSET_GID}.
 */
define( "kOFFSET_LID",							'_lid' );

/**
 * Namespace.
 *
 * This tag is used as the offset for a namespace. By default this attribute contains the
 * native unique identifier, {@link kOFFSET_NID}, of the namespace object; if you want to
 * refer to the namespace code, this is not the offset to use.
 */
define( "kOFFSET_NAMESPACE",					'_nsp' );

/*=======================================================================================
 *	DEFAULT CONTAINER NAMES																*
 *======================================================================================*/

/**
 * Terms container name.
 *
 * This tag identifies the default name for the container that will host term objects.
 */
define( "kCONTAINER_TERM_NAME",					'_terms' );

?>
