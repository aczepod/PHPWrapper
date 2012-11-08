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
 *	WEB-SERVICE RESPONSE PARAMETERS														*
 *======================================================================================*/

/**
 * Identifier elements.
 *
 * This offset tags the element that holds the list of identifiers of the requested items.
 */
define( "kAPI_COLLECTION_ID",					'_ids' );

/**
 * Predicate elements.
 *
 * This offset tags the element that holds the list of referenced predicate items.
 */
define( "kAPI_COLLECTION_PREDICATE",			'_predicate' );

/**
 * Vertex elements.
 *
 * This offset tags the element that holds the list of referenced vertex items.
 */
define( "kAPI_COLLECTION_VERTEX",				'_vertex' );

/**
 * Edge elements.
 *
 * This offset tags the element that holds the list of referenced edge items.
 */
define( "kAPI_COLLECTION_EDGE",					'_edge' );

/**
 * Tag elements.
 *
 * This offset tags the element that holds the list of referenced tag items.
 */
define( "kAPI_COLLECTION_TAG",					'_tag' );

/*=======================================================================================
 *	WEB-SERVICE OPERATIONS																*
 *======================================================================================*/

/**
 * GetRootsByKind web-service.
 *
 * This is the tag that represents the GetRootsByKind web-service operation, which returns
 * a list of root vertexes that match the provided kind criteria. The criteria is provided
 * in the {@link kAPI_QUERY} parameter as an array of values, to these values the
 * {@link kKIND_NODE_ROOT} enumeration will be added and the matching nodes will have to
 * match <i>all</i> the entries.
 *
 * The resulting records will be constituted by a combination of the node and term
 * attributes, where the node attributes will overwrite matching term attributes.
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
 *	<li><i>{@link kAPI_QUERY}</i>: This parameter will hold the list of kind entries, if
 *		omitted, all root nodes will be selected.
 * </ul>
 */
define( "kAPI_OP_GetRootsByKind",	'WS:OP:GetRootsByKind' );


?>
