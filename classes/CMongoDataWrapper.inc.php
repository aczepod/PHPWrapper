<?php

/*=======================================================================================
 *																						*
 *								CMongoDataWrapper.inc.php								*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link CMongoDataWrapper} definitions.
 *
 * This file contains common definitions used by the {@link CMongoDataWrapper} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 07/06/2011
 *				2.00 23/02/2012
 */

/*=======================================================================================
 *	DEFAULT OPERATION ENUMERATIONS														*
 *======================================================================================*/

/**
 * GET-ONE web-service.
 *
 * This is the tag that represents the findOne Mongo operation, it will return the first
 * matched object.
 */
define( "kAPI_OP_GET_ONE",			'@GET-ONE' );

/*=======================================================================================
 *	DEFAULT STATUS TAGS																	*
 *======================================================================================*/

/**
 * Native status.
 *
 * This tag will hold the native status of the operation.
 */
define( "kAPI_STATUS_NATIVE",		'native' );

/*=======================================================================================
 *	DEFAULT COUNTER TAGS																*
 *======================================================================================*/

/**
 * Count tag.
 *
 * This tag will hold the total number of elements affected by the operation.
 */
define( "kAPI_AFFECTED_COUNT",		'affected' );

/*=======================================================================================
 *	DEFAULT OPTION ENUMERATIONS															*
 *======================================================================================*/

/**
 * No response option.
 *
 * Can be a boolean or integer, defaults to FALSE. If TRUE, the {@link kAPI_RESPONSE}
 * section will not be included in the result. This can be useful when you are only
 * interested in the status of the operation and not in the response.
 */
define( "kAPI_OPT_NO_RESP",			':@no-response' );

?>
