<?php

/*=======================================================================================
 *																						*
 *								CDataWrapper.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link CDataWrapper} definitions.
 *
 *	This file contains common definitions used by the {@link CDataWrapper} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 06/11/2011
 */

/*=======================================================================================
 *	WEB-SERVICE RESOURCE OFFSETS														*
 *======================================================================================*/

/**
 * Web-service server.
 *
 * This is the tag that represents the server on which we want to operate, no parameter
 * is provided, but this {@link CServer} must be instantiated in the {@link _InitResources}
 * method and set with this offset into the request array.
 *
 * Type: CServer.
 * Cardinality: one.
 */
define( "kAPI_SERVER",				':WS:SERVER' );

/*=======================================================================================
 *	WEB-SERVICE REQUEST PARAMETERS														*
 *======================================================================================*/

/**
 * Web-service database.
 *
 * This is the tag that represents the database on which we want to operate, the parameter
 * is provided as a string and is used as an argument to the {@link CServer::Database()}
 * method.
 *
 * Type: string.
 * Cardinality: one.
 */
define( "kAPI_DATABASE",			':WS:DATABASE' );

/**
 * Web-service database container.
 *
 * This is the tag that represents the database container on which we want to operate, the
 * parameter is provided as a string and is used as an argument to the
 * {@link CDatabase::Container()} method.
 *
 * Type: string.
 * Cardinality: one.
 */
define( "kAPI_CONTAINER",			':WS:CONTAINER' );

/**
 * Page start.
 *
 * This tag is used to define the starting page or record number, the parameter is provided
 * as an integer string.
 *
 * Type: integer.
 * Cardinality: one or zero.
 */
define( "kAPI_PAGE_START",			':WS:PAGE-START' );

/**
 * Page limit tag.
 *
 * This tag is used to define the maximum number of elements to be returned by a request,
 * this should not be confused with the {@link kAPI_PAGE_COUNT} tag which defines the total
 * number of elements affected by a request; the parameter is provided as an integer string.
 *
 * Type: integer.
 * Cardinality: one or zero.
 */
define( "kAPI_PAGE_LIMIT",			':WS:PAGE-LIMIT' );

/**
 * Data filter.
 *
 * This is the tag that represents the data store filter or query, the parameter is provided
 * as an encoded {@link CQuery} object.
 *
 * Type: encoded.
 * Cardinality: one or zero.
 */
define( "kAPI_QUERY",				':WS:QUERY' );

/**
 * Data fields.
 *
 * This is the tag that represents the data store object elements that should be returned:
 * if omitted it is assumed that the whole object is to be returned; the parameter is
 * provided as an encoded array.
 *
 * Type: encoded.
 * Cardinality: one or zero.
 */
define( "kAPI_SELECT",				':WS:SELECT' );

/**
 * Data sort order.
 *
 * This is the tag that represents the data store sort elements that should be used for
 * sorting the results.
 *
 * Type: encoded.
 * Cardinality: one or zero.
 */
define( "kAPI_SORT",				':WS:SORT' );

/*=======================================================================================
 *	WEB-SERVICE RESPONSE PARAMETERS														*
 *======================================================================================*/

/**
 * Data store paging.
 *
 * This is the tag that represents the data store paging parameters, this tag defines a
 * block that will receive the following elements:
 *
 * <ul>
 *	<li><i>{@link kAPI_PAGE_START}</i>: First page index.
 *	<li><i>{@link kAPI_PAGE_LIMIT}</i>: Number of elements per page.
 *	<li><i>{@link kAPI_PAGE_COUNT}</i>: Affected number of elements in the query.
 * </ul>
 *
 * Type: struct.
 * Cardinality: one or zero.
 */
define( "kAPI_PAGING",				':WS:PAGING' );

/*=======================================================================================
 *	WEB-SERVICE RESPONSE ELEMENTS														*
 *======================================================================================*/

/**
 * Page count tag.
 *
 * This tag is used to return the <i>actual</i> number of elements returned by a request,
 * this value will be smaller or equal {@link kAPI_PAGE_LIMIT} tag which defines the
 * maximum number of elements to be returned by a request; the parameter is provided as an
 * integer string.
 *
 * Type: integer.
 * Cardinality: one or zero.
 */
define( "kAPI_PAGE_COUNT",			':WS:PAGE-COUNT' );

/**
 * Count tag.
 *
 * This tag will hold the total number of elements affected by the operation.
 */
define( "kAPI_AFFECTED_COUNT",		':WS:AFFECTED-COUNT' );

/*=======================================================================================
 *	WEB-SERVICE OPERATIONS																*
 *======================================================================================*/

/**
 * COUNT web-service.
 *
 * This is the tag that represents the COUNT web-service operation, which returns the count
 * of a provided query.
 *
 * The service expects the following parameters:
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *		encode the response.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to indicate the working
 *		database.
 *	<li><i>{@link kAPI_CONTAINER}</i>: This parameter is required to indicate the working
 *		container.
 *	<li><i>{@link kAPI_QUERY}</i>: If this parameter is missing, we expect to get the whole
 *		container count.
 * </ul>
 */
define( "kAPI_OP_COUNT",			'WS:OP:COUNT' );

/**
 * QUERY web-service.
 *
 * This is the tag that represents the QUERY web-service operation, which returns the list
 * of records satisfying a provided query.
 *
 * The service expects the following parameters:
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *		encode the response.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to indicate the working
 *		database.
 *	<li><i>{@link kAPI_CONTAINER}</i>: This parameter is required to indicate the working
 *		container.
 *	<li><i>{@link kAPI_QUERY}</i>: If this parameter is missing, we expect to get the whole
 *		container count.
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
 * </ul>
 */
define( "kAPI_OP_QUERY",			'WS:OP:QUERY' );


?>
