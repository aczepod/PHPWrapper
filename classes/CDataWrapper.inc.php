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

/**
 * Data store object class.
 *
 * This is the tag that represents the data store object class, this value is used when
 * committing objects to the data store, if provided, the object will be committed as an
 * instance of the class provided in this parameter, if the class is unavailable, the
 * service will fail.
 *
 * This parameter may also be used to resolve the container name: if provided, the service will
 * attempt to set the default container name.
 *
 * Type: encoded.
 * Cardinality: one or zero.
 */
define( "kAPI_CLASS",				':WS:CLASS' );

/**
 * Data store object.
 *
 * This is the tag that represents the data store object, this value is used when committing
 * data back to the data store; the parameter is provided as an encoded array or object.
 *
 * Type: encoded.
 * Cardinality: one or zero.
 */
define( "kAPI_OBJECT",				':WS:OBJECT' );

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
 *
 * Type: integer.
 * Cardinality: one.
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
 * GET web-service.
 *
 * This is the tag that represents the GET web-service operation, which returns the records
 * satisfying a provided query.
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
 *		value should be a number that represents the sense: positive will be considered
 *		<i>ascending</i> and negative values <i>descending</i>; zero values will be ignored.
 *	<li><i>{@link kAPI_PAGE_LIMIT}</i>:This parameter is required or enforced, it represents
 *		the maximum number of elements that the query should return, the default value is
 *		{@link kDEFAULT_LIMIT}.
 * </ul>
 */
define( "kAPI_OP_GET",				'WS:OP:GET' );

/**
 * GET-ONE web-service.
 *
 * This is the tag that represents the GET-ONE web-service operation, which returns the
 * first record that satisfies a provided query.
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
 * </ul>
 */
define( "kAPI_OP_GET_ONE",			'WS:OP:GET-ONE' );

/**
 * MATCH web-service.
 *
 * This is the tag that represents the MATCH web-service operation, which returns the
 * the first matching record of a series of queries.
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
 *	<li><i>{@link kAPI_QUERY}</i>: This parameter is required and contains an array of
 *		queries.
 *	<li><i>{@link kAPI_SELECT}</i>: This parameter is an array listing which fields are to
 *		be returned by the query, all fields not included in the list will be ignored. An
 *		empty list is equivalent to not providing the list.
 * </ul>
 *
 * The service will execute each provided query and the first matched record will be
 * returned.
 */
define( "kAPI_OP_MATCH",			'WS:OP:MATCH' );

/**
 * RESOLVE web-service.
 *
 * This is the tag that represents the RESOLVE web-service operation, which matches the
 * object corresponding to the provided value.
 *
 * The service expects the following parameters:
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *		encode the response.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to indicate the working
 *		database.
 *	<li><i>{@link kAPI_CONTAINER}</i>: This parameter is required to indicate the working
 *		container. Note that in some cases this parameter is not required, in particular,
 *		when providing the {@link kAPI_CLASS} parameter, the container might be implicit.
 *	<li><i>{@link kAPI_OBJECT}</i>: This parameter is required and contains the value to be
 *		matched.
 *	<li><i>{@link kAPI_CLASS}</i>: This parameter is required, it represents the class from
 *		which the <tt>Resolve()</tt> static method will be used.
 * </ul>
 *
 * The service will attempt to <i>resolve</i> the provided object by calling the static
 * <tt>Resolve()</tt> method of the provided {@link kAPI_CLASS} parameter with the value
 * provided in the {@link kAPI_OBJECT} parameter.
 */
define( "kAPI_OP_RESOLVE",			'WS:OP:RESOLVE' );

/**
 * INSERT web-service.
 *
 * This is the tag that represents the INSERT web-service operation, which inserts the
 * provided object in the provided database or container.
 *
 * The service expects the following parameters:
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *		encode the response.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to indicate the working
 *		database.
 *	<li><i>{@link kAPI_CONTAINER}</i>: This parameter is required to indicate the working
 *		container. Note that in some cases this parameter is not required, in particular,
 *		when providing the {@link kAPI_CLASS} parameter, the container might be implicit.
 *	<li><i>{@link kAPI_OBJECT}</i>: This parameter is required and contains an array
 *		corresponding to the new record.
 *	<li><i>{@link kAPI_CLASS}</i>: If provided, this parameter indicates which instance the
 *		object should be; if not provided, the {@link kAPI_CONTAINER} parameter is required
 *		and the object will simply be added to the container.
 * </ul>
 *
 * The service will attempt to <i>insert</i> the provided object, if successful, it will
 * return the newly created {@link kTAG_NID} identifier in the
 * {@link kTERM_STATUS_IDENTIFIER} return parameter.
 */
define( "kAPI_OP_INSERT",			'WS:OP:INSERT' );

/**
 * DEL web-service.
 *
 * This is the tag that represents the DEL web-service operation, which deletes either a
 * selection of objects matching a query or one object matching a value.
 *
 * The service expects the following parameters:
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *		encode the response.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to indicate the working
 *		database.
 *	<li><i>{@link kAPI_CONTAINER}</i>: This parameter is required to indicate the working
 *		container. Note that in some cases this parameter is not required, in particular,
 *		when providing the {@link kAPI_CLASS} parameter, the container might be implicit.
 *	<li><i>{@link kAPI_QUERY}</i>: This parameter contains the query that selects the items
 *		to be deleted.
 *	<li><i>{@link kAPI_OBJECT}</i>: This parameter is required and contains the value by
 *		which the object will be identified, some classes feature a <i>Resolve()</i> method,
 *		in that case  this value will be handled by that method, if not, the value is
 *		assumed to be the object0s {@link kTAG_NID}. If this parameter is provided, the
 *		{@link kAPI_QUERY} parameter will be ignored.
 *	<li><i>{@link kAPI_CLASS}</i>: If provided, this parameter indicates to which class the
 *		object to be deleted belongs to; if not provided, the {@link kAPI_CONTAINER}
 *		parameter is required and the object is assumed to be the object's {@link kTAG_NID}.
 *		This parameter is ignored if the {@link kAPI_OBJECT} parameter is missing.
 * </ul>
 */
define( "kAPI_OP_DELETE",			'WS:OP:DEL' );


?>
