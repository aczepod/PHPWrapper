<?php

/*=======================================================================================
 *																						*
 *								COntologyWrapper.inc.php								*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link COntologyWrapper} definitions.
 *
 *	This file contains common definitions used by the {@link COntologyWrapper} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 07/11/2011
 */

/*=======================================================================================
 *	WEB-SERVICE REQUEST PARAMETERS														*
 *======================================================================================*/

/**
 * Web-service database.
 *
 * This is the tag that represents the kind selector, this is implemented as an array of
 * enumerations that will be matched by <i>AND</i>, which means that if more than one item
 * is provided, it is expected that the matched elements have both of the provided items.
 *
 * The parameter can also be provided as a scalar.
 *
 * Type: string.
 * Cardinality: one or zero.
 */
define( "kAPI_KIND",				':WS:KIND' );

/*=======================================================================================
 *	WEB-SERVICE OPERATIONS																*
 *======================================================================================*/

/**
 * GetNodesByKind web-service.
 *
 * This is the tag that represents the GetNodesByKind web-service operation, which returns
 * a list of exported nodes given a list of matching kinds.
 *
 * The service expects a list of node kind enumerations in the {@link 
 *
 * The service expects the following parameters:
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *		encode the response.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to indicate the working
 *		database.
 *	<li><i>{@link kAPI_SELECT}</i>: This parameter is an array listing which fields are to
 *		be returned by the query, all fields not included in the list will be ignored. An
 *		empty list is equivalent to not providing the list.
 *	<li><i>{@link kAPI_SORT}</i>: This parameter is an array listing which fields are to
 *		be considered in the sort order, the array is indexed by the field name and the
 *		value should be a number that represents the sense: positive or zero will be
 *		considered <i>ascending</i> and negative values <i>descending</i>.
 *	<li><i>{@link kAPI_PAGE_LIMIT}</i>:This parameter is required or enforced, it represents
 *		the maximum number of elements that the query should return, the default value is
 *		{@link kDEFAULT_LIMIT}.
 *	<li><i>{@link kAPI_KIND}</i>:This optional parameter represents the kind enumerations
 *		that the selected nodes must match (<i>AND</i>).
 * </ul>
 */
define( "kAPI_OP_GetNodesByKind",	'WS:OP:GetNodesByKind' );


?>
