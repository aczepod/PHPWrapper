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
 *	@version	1.00 05/06/2011
 *				2.00 22/02/2012
 */

/*=======================================================================================
 *	WEB-SERVICE REQUEST PARAMETERS														*
 *======================================================================================*/

/**
 * Data store filter.
 *
 * This is the tag that represents the data store filter or query, the parameter is provided
 * as an encoded {@link CQuery} object.
 *
 * Type: encoded.
 * Cardinality: one or zero.
 */
define( "kAPI_QUERY",				':WS:QUERY' );

/**
 * Web-service database.
 *
 * This is the tag that represents the database on which we want to operate, the parameter
 * is provided as a string.
 *
 * Type: string.
 * Cardinality: one.
 */
define( "kAPI_DATABASE",			':WS:DATABASE' );

/**
 * Web-service database container.
 *
 * This is the tag that represents the database container on which we want to operate, the
 * parameter is provided as a string.
 *
 * Type: string.
 * Cardinality: one.
 */
define( "kAPI_CONTAINER",			':WS:CONTAINER' );

/**
 * Data store object fields.
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
 * Data store sort order.
 *
 * This is the tag that represents the data store sort elements that should be used for
 * sorting the results.
 *
 * Type: encoded.
 * Cardinality: one or zero.
 */
define( "kAPI_SORT",				':WS:SORT' );

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

/**
 * Data store options.
 *
 * This is the tag that represents the data store options, this value is used to provide
 * additional options to the operation. It is structured as a key/value pair having the
 * following default key elements:
 *
 * <ul>
 *	<li><i>{@link kAPI_OPT_SAFE}</i>: Safe commit option.
 *	<li><i>{@link kAPI_OPT_FSYNC}</i>: Safe and sync commit option.
 *	<li><i>{@link kAPI_OPT_TIMEOUT}</i>: Operation timeout.
 *	<li><i>{@link kAPI_OPT_SINGLE}</i>: Single object selection.
 * </ul>
 *
 * Type: encoded.
 * Cardinality: one or zero.
 */
define( "kAPI_OPTIONS",				':WS:OPTIONS' );

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
 *	WEB-SERVICE PAGING STRUCTURE														*
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

/*=======================================================================================
 *	WEB-SERVICE OPTION ENUMERATIONS														*
 *======================================================================================*/

/**
 * SAFE option.
 *
 * Can be a boolean or integer, defaults to FALSE. If FALSE, the program continues executing
 * without waiting for a database response. If TRUE, the program will wait for the database
 * response and throw an exception if the operation did not succeed.
 */
define( "kAPI_OPT_SAFE",			'safe' );

/**
 * FSYNC option.
 *
 * Boolean, defaults to FALSE. Forces the update to be synced to disk before returning
 * success. If TRUE, a safe update is implied and will override setting safe to FALSE.
 */
define( "kAPI_OPT_FSYNC",			'fsync' );

/**
 * TIMEOUT option.
 *
 * Integer, if "safe" is set, this sets how long (in milliseconds) for the client to wait
 * for a database response. If the database does not respond within the timeout period, an
 * exception will be thrown.
 */
define( "kAPI_OPT_TIMEOUT",			'timeout' );

/**
 * SINGLE option.
 *
 * Boolean, used in the {@link kAPI_OP_DEL} operation: if TRUE, only one object will be
 * deleted; if not, all matching objects will be deleted.
 */
define( "kAPI_OPT_SINGLE",			'justOne' );

/*=======================================================================================
 *	SESSION TAGS																		*
 *======================================================================================*/

/**
 * Server connection.
 *
 * This tag represents the session server offset, it will hold the operations
 * {@link CServer} instance.
 */
define( "kAPI_SESSION_SERVER",		'@S' );

/**
 * Database connection.
 *
 * This tag represents the session database offset, it will hold the operations
 * {@link CDatabase} instance.
 */
define( "kAPI_SESSION_DATABASE",	'@D' );

/**
 * Container connection.
 *
 * This tag represents the session container offset, it will hold the operations
 * {@link CContainer} instance.
 */
define( "kAPI_SESSION_CONTAINER",	'@C' );

/*=======================================================================================
 *	WEB-SERVICE OPERATIONS																*
 *======================================================================================*/

/**
 * COUNT web-service.
 *
 * This is the tag that represents the COUNT web-service operation, used to return the
 * total number of elements satisfying a query.
 *
 * The service expects the following parameters:
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *		encode the request and the response.
 *	<li><i>{@link kAPI_QUERY}</i>: This parameter is required to provide a data filter.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to provide the database
 *		reference.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to provide the container
 *		reference.
 * </ul>
 */
define( "kAPI_OP_COUNT",			'COUNT' );

/**
 * MATCH web-service.
 *
 * This is the tag that represents the MATCH web-service operation, used to retrieve objects
 * matching the first query of a list of provided queries.
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *		encode the request and the response.
 *	<li><i>{@link kAPI_QUERY}</i>: This parameter is required to provide a data filter.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to provide the database
 *		reference.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to provide the container
 *		reference.
 *	<li><i>{@link kAPI_PAGE_LIMIT}</i>: This parameter is required to provide the maximum
 *		number of elements to be returned; if omitted, the {@link kDEFAULT_LIMIT} value will
 *		be enforced.
 * </ul>
 *
 * Note that the {@link kAPI_QUERY} parameter,
 * in this case, is expected to be a list of individual queries, not a single query.
 */
define( "kAPI_OP_MATCH",			'MATCH' );

/**
 * GET web-service.
 *
 * This is the tag that represents the GET web-service operation, used to retrieve a list
 * of matching objects from the data store.
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *		encode the request and the response.
 *	<li><i>{@link kAPI_QUERY}</i>: This parameter is required to provide a data filter.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to provide the database
 *		reference.
 *	<li><i>{@link kAPI_CONTAINER}</i>: This parameter is required to provide the container
 *		reference.
 *	<li><i>{@link kAPI_PAGE_LIMIT}</i>: This parameter is required to provide the maximum
 *		number of elements to be returned; if omitted, the {@link kDEFAULT_LIMIT} value will
 *		be enforced.
 * </ul>
 */
define( "kAPI_OP_GET",				'GET' );

/**
 * SET web-service.
 *
 * This is the tag that represents the SET web-service operation, used to insert or update
 * objects in the data store.
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *		encode the request and the response.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to provide the database
 *		reference.
 *	<li><i>{@link kAPI_CONTAINER}</i>: This parameter is required to provide the container
 *		reference.
 *	<li><i>{@link kAPI_OBJECT}</i>: This parameter is required to provide the object to be
 *		set.
 * </ul>
 */
define( "kAPI_OP_SET",				'SET' );

/**
 * UPDATE web-service.
 *
 * This is the tag that represents the UPDATE web-service operation, used to update existing
 * objects in the data store.
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *		encode the request and the response.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to provide the database
 *		reference.
 *	<li><i>{@link kAPI_CONTAINER}</i>: This parameter is required to provide the container
 *		reference.
 *	<li><i>{@link kAPI_OBJECT}</i>: This parameter is required to provide the object to be
 *		set.
 * </ul>
 *
 * This option implies that the object already exists, or the operation should fail.
 */
define( "kAPI_OP_UPDATE",			'UPDATE' );

/**
 * INSERT web-service.
 *
 * This is the tag that represents the INSERT web-service operation, used to insert new
 * objects in the data store.
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *		encode the request and the response.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to provide the database
 *		reference.
 *	<li><i>{@link kAPI_CONTAINER}</i>: This parameter is required to provide the container
 *		reference.
 *	<li><i>{@link kAPI_OBJECT}</i>: This parameter is required to provide the object to be
 *		set.
 * </ul>
 *
 * This option implies that the object does not exists, or the operation should fail.
 */
define( "kAPI_OP_INSERT",			'INSERT' );

/**
 * BATCH-INSERT web-service.
 *
 * This service is equivalent to the {@link kAPI_OP_INSERT} command, except that in this
 * case you provide a list of objects to be  inserted.
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *		encode the request and the response.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to provide the database
 *		reference.
 *	<li><i>{@link kAPI_CONTAINER}</i>: This parameter is required to provide the container
 *		reference.
 *	<li><i>{@link kAPI_OBJECT}</i>: This parameter is required to provide the objects to be
 *		set; in this case this should be an array of objects.
 * </ul>
 *
 * This option implies that the objects do not exists, or the operation should fail.
 */
define( "kAPI_OP_BATCH_INSERT",		'BINSERT' );

/**
 * MODIFY web-service.
 *
 * This is the tag that represents the MODIFY web-service operation, used to modify partial
 * contents of objects in the data store.
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *		encode the request and the response.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to provide the database
 *		reference.
 *	<li><i>{@link kAPI_CONTAINER}</i>: This parameter is required to provide the container
 *		reference.
 *	<li><i>{@link kAPI_QUERY}</i>: This parameter is required to provide a data filter to
 *		select which objects are to be modified.
 *	<li><i>{@link kAPI_OBJECT}</i>: This parameter is required to provide the modification
 *		criteria.
 * </ul>
 *
 * This option implies that the object already exists, or the operation should fail.
 */
define( "kAPI_OP_MODIFY",			'MODIFY' );

/**
 * DELETE web-service.
 *
 * This is the tag that represents the DELETE web-service operation, used to delete objects
 * from the data store.
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *		encode the request and the response.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to provide the database
 *		reference.
 *	<li><i>{@link kAPI_CONTAINER}</i>: This parameter is required to provide the container
 *		reference.
 *	<li><i>{@link kAPI_QUERY}</i>: This parameter is required to provide a data filter to
 *		select which objects are to be deleted.
 * </ul>
 */
define( "kAPI_OP_DEL",				'DELETE' );


?>
