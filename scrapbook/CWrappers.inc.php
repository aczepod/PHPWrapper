<?php

/*=======================================================================================
 *																						*
 *									CWrappers.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	Wrapper definitions.
 *
 *	This file contains all common definitions used by the wrapper classes.
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 17/12/2012
 */

/*=======================================================================================
 *	WEB-SERVICE REQUEST PARAMETERS														*
 *======================================================================================*/

/**
 * Web-service operation.
 *
 * This is the tag that represents the web-service operation, it is constituted by an
 * enumerated value that indicates what operation is requested from the web-service.
 *
 * This parameter is required.
 *
 * Type: enum.
 * Cardinality: one.
 */
define( "kAPI_OPERATION",			':WS:OPERATION' );

/**
 * Web-service format.
 *
 * This is the tag that represents the web-service request and response format.
 * All parameters sent or received by the web service, with the exception of parameters that
 * are scalar strings, will be encoded in this format.
 *
 * This parameter is required, or it is set to {@link kTYPE_JSON} if omitted.
 *
 * Type: enum.
 * Cardinality: one.
 */
define( "kAPI_FORMAT",				':WS:FORMAT' );

/**
 * Web-service time stamp.
 *
 * This is the tag that represents the request time stamp, it is an indication that the
 * caller wants to have timing information for the web-service. To signal the request for
 * timing information, the caller must send a timestamp value
 * (<tt>gettimeofday( true )</tt>, in this parameter and the service will return the
 * following elements:
 *
 * <ul>
 *	<li><i>{@link kAPI_STAMP_REC}</i>: Received time stamp, the time when the request was
 *		received. This information can be useful to test network delays.
 *	<li><i>{@link kAPI_STAMP_PARSE}</i>: Parsed time stamp, the time when the request was
 *		parsed. This information can be useful to test how heavy is the parsing activity.
 *	<li><i>{@link kAPI_STAMP_SENT}</i>: Response time stamp, the time when the response was
 *		sent. This information can be useful to determine how long database operations are.
 * </ul>
 *
 * The value of this parameter is provided as floating point numbers such as the result of
 * the <tt>gettimeofday( true )</tt> function.
 *
 * Type: float.
 * Cardinality: one or zero.
 */
define( "kAPI_STAMP_REQUEST",		':WS:STAMP-REQUEST' );

/**
 * Log request.
 *
 * If the value of this tag resolves to <i>TRUE</i>, the request will be logged in the
 * response.
 *
 * Type: boolean.
 * Cardinality: one or zero.
 */
define( "kAPI_LOG_REQUEST",			':WS:LOG-REQUEST' );

/**
 * Trace errors.
 *
 * If the value of this tag resolves to <i>TRUE</i>, eventual errors will bare the trace.
 *
 * Type: boolean.
 * Cardinality: one or zero.
 */
define( "kAPI_LOG_TRACE",			':WS:LOG-TRACE' );

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

/**
 * Language.
 *
 * This offset tags the element that holds the list of languages in which elements of type
 * {@link kTYPE_LSTRING} should be returned in.
 *
 * The parameter must be expressed as an array.
 *
 * Type: string.
 * Cardinality: any.
 */
define( "kAPI_LANGUAGE",						':WS:LANGUAGE' );

/**
 * Predicate.
 *
 * This offset tags the element that holds the list of predicates that the requested
 * relationships must match.
 *
 * The parameter must be expressed as an array and predicate references must be provided as
 * a term {@link kTAG_GID}.
 *
 * Type: string.
 * Cardinality: any.
 */
define( "kAPI_PREDICATE",						':WS:PREDICATE' );

/**
 * Relations sense.
 *
 * This offset tags the element that holds the sense in which relations should be returned:
 *
 * <ul>
 *	<li><tt>{@link kAPI_RELATION_IN}</tt>: Input, all elements that point to the current
 *		vertex.
 *	<li><tt>{@link kAPI_RELATION_OUT}</tt>: Output, all elements to which the current vertex
 *		points to.
 *	<li><tt>{@link kAPI_RELATION_ALL}</tt>: All, all elements with which the current vertex
 *		is related.
 *	<li><i>missing</i>: If the parameter is missing, it is assumed you only want the vertex.
 * </ul>
 *
 * The parameter must be expressed as a string scalar.
 *
 * Type: string.
 * Cardinality: one.
 */
define( "kAPI_RELATION",						':WS:RELATION' );

/**
 * Credentials.
 *
 * This offset tags the element that holds the login credentials, the parameter must be
 * expressed as an array whose contents depend on the operation.
 *
 * Type: string.
 * Cardinality: any.
 */
define( "kAPI_CREDENTIALS",						':WS:CREDENTIALS' );

/*=======================================================================================
 *	WEB-SERVICE REQUEST ELEMENTS														*
 *======================================================================================*/

/**
 * User code.
 *
 * This offset tags the user code in the {@link kAPI_CREDENTIALS} parameter.
 *
 * Type: string.
 * Cardinality: one.
 */
define( "kAPI_CREDENTIALS_CODE",				':WS:CREDENTIALS-CODE' );

/**
 * User password.
 *
 * This offset tags the user password in the {@link kAPI_CREDENTIALS} parameter.
 *
 * Type: string.
 * Cardinality: one.
 */
define( "kAPI_CREDENTIALS_PASS",				':WS:CREDENTIALS-PASS' );

/*=======================================================================================
 *	WEB-SERVICE RESPONSE PARAMETERS														*
 *======================================================================================*/

/**
 * Status.
 *
 * This tag holds the operation status block, this element is returned by default.
 *
 * Type: struct.
 * Cardinality: one.
 */
define( "kAPI_STATUS",				':WS:STATUS' );

/**
 * Request.
 *
 * This tag holds the request block: if the {@link kAPI_LOG_REQUEST} parameter is set,
 * this parameter will hold a copy of the provided request.
 *
 * Type: struct.
 * Cardinality: one or zero.
 */
define( "kAPI_REQUEST",				':WS:REQUEST' );

/**
 * Response.
 *
 * This tag holds the response block.
 *
 * Type: struct.
 * Cardinality: one or zero.
 */
define( "kAPI_RESPONSE",			':WS:RESPONSE' );

/**
 * Timing.
 *
 * This offset represents the collector tag for request timing parameters.
 *
 * <i>Note: this is a <b>reserved offset tag</b>.</i>
 *
 * Type: struct.
 * Cardinality: one or zero.
 */
define( "kAPI_STAMP",				':WS:STAMP' );

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
define( "kAPI_COLLECTION_TERM",					'_term' );

/**
 * Vertex elements.
 *
 * This offset tags the element that holds the list of referenced vertex items.
 */
define( "kAPI_COLLECTION_NODE",					'_node' );

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
 *	WEB-SERVICE TIMER STRUCTURE															*
 *======================================================================================*/

/**
 * Web-service received time stamp.
 *
 * This is the tag that represents the time stamp in which the request was received.
 *
 * These values are provided as floating point numbers such as the result of the
 * <i>gettimeofday( true )</i> function.
 *
 * Type: float.
 * Cardinality: one or zero.
 */
define( "kAPI_STAMP_REC",			':WS:STAMP-RECEIVED' );

/**
 * Web-service parsed time stamp.
 *
 * This is the tag that represents the time stamp in which the request was parsed.
 *
 * These values are provided as floating point numbers such as the result of the
 * <i>gettimeofday( true )</i> function.
 *
 * Type: float.
 * Cardinality: one or zero.
 */
define( "kAPI_STAMP_PARSE",			':WS:STAMP:PARSED' );

/**
 * Web-service response time stamp.
 *
 * This is the tag that represents the time stamp in which the response was sent.
 *
 * These values are provided as floating point numbers such as the result of the
 * <i>gettimeofday( true )</i> function.
 *
 * Type: float.
 * Cardinality: one or zero.
 */
define( "kAPI_STAMP_SENT",			':WS:STAMP-SENT' );

/*=======================================================================================
 *	RELATIONSHIP SENSE ENUMERATIONS														*
 *======================================================================================*/

/**
 * Input relationships.
 *
 * This enumeration represents an input relationship, or the collection of vertices that
 * point to the current node.
 */
define( "kAPI_RELATION_IN",			'WS:RELATION:IN' );

/**
 * Output relationships.
 *
 * This enumeration represents an output relationship, or the collection of vertices to
 * which the current vertex points.
 */
define( "kAPI_RELATION_OUT",		'WS:RELATION:OUT' );

/**
 * All relationships.
 *
 * This enumeration represents both input and output relationships, or the collection of
 * vertices related to the current vertex.
 */
define( "kAPI_RELATION_ALL",		'WS:RELATION:ALL' );

/*=======================================================================================
 *	WEB-SERVICE OPERATIONS																*
 *======================================================================================*/

/**
 * HELP web-service.
 *
 * This is the tag that represents the HELP web-service operation, which returns the list
 * of supported operations and options.
 *
 * The service expects the following parameters:
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *		encode the response.
 * </ul>
 */
define( "kAPI_OP_HELP",				'WS:OP:HELP' );

/**
 * PING web-service.
 *
 * This is the tag that represents the PING web-service operation, which returns a status
 * response.
 *
 * The service expects the following parameters:
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to
 *		encode the response.
 * </ul>
 */
define( "kAPI_OP_PING",				'WS:OP:PING' );

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

/**
 * GetVertex web-service.
 *
 * This is the tag that represents the GetVertex web-service operation, which will return a
 * list of vertices according to the provided parameters:
 *
 * <ul>
 *	<li><tt>{@link kAPI_RELATION}</tt> omitted: If this parameter is omitted, it is assumed
 *		you want the vertices selected by the provided query.
 *	<li><tt>{@link kAPI_RELATION} provided</tt>: If this parameter is provided, it is
 *		assumed you want the relationships of the first vertex selected by the provided
 *		query.
 * </ul>
 *
 * The service expects the following parameters:
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to encode the
 *		response.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to indicate the working
 *		database.
 *	<li><i>{@link kAPI_SELECT}</i>: This parameter is an array listing which fields are to
 *		be returned by the query, all fields not included in the list will be ignored. An
 *		empty list is equivalent to requesting all fields.
 *	<li><i>{@link kAPI_SORT}</i>: This parameter is an array listing which fields are to
 *		be considered in the sort order, the array is indexed by the field name and the
 *		value should be a number that represents the sense: positive will be considered
 *		<i>ascending</i> and negative values <i>descending</i>; zero values will be ignored.
 *	<li><i>{@link kAPI_PAGE_LIMIT}</i>:This parameter is required or enforced, it represents
 *		the maximum number of elements that the query should return, the default value is
 *		{@link kDEFAULT_LIMIT}.
 *	<li><i>{@link kAPI_QUERY}</i>: This parameter will hold the selection criteria of the
 *		reference vertex, the nodes container will be searched.
 *	<li><i>{@link kAPI_RELATION}</i>: Depending on whether the parameter is provided:
 *	 <ul>
 *		<li><tt>{@link kAPI_RELATION_IN}</tt>: Return all vertices that point to the first
 *			vertex selected by the provided query.
 *		<li><tt>{@link kAPI_RELATION_OUT}</tt>: Return all vertices to which the first
 *			vertex selected by the provided query point to.
 *		<li><tt>{@link kAPI_RELATION_ALL}</tt>: Return all vertices related to the first
 *			vertex selected by the provided query.
 *		<li><i>missing</i>: If the parameter is missing, it is assumed you only want the
 *			vertices selected by the provided query.
 *	 </ul>
 * </ul>
 */
define( "kAPI_OP_GetVertex",		'WS:OP:GetVertex' );

/**
 * Login web-service.
 *
 * This is the tag that represents the Login web-service operation, which will return a user
 * record upon providing correct credentials in the {@link kAPI_CREDENTIALS} parameter.
 *
 * The service expects the following parameters:
 *
 * <ul>
 *	<li><i>{@link kAPI_FORMAT}</i>: This parameter is required to indicate how to encode the
 *		response.
 *	<li><i>{@link kAPI_DATABASE}</i>: This parameter is required to indicate the working
 *		database.
 *	<li><i>{@link kAPI_CONTAINER}</i>: This optional parameter is used to indicate the
 *		working container in case of a non-standard configuration.
 *	<li><i>{@link kAPI_CREDENTIALS}</i>: This parameter is required for validating the user:
 *	 <ul>
 *		<li><tt>{@link kAPI_CREDENTIALS_CODE}</tt>: User code.
 *		<li><tt>{@link kAPI_CREDENTIALS_PASS}</tt>: User password.
 *	 </ul>
 *		Note that these parameters may grow in derived classes, this represents the bare minimum.
 * </ul>
 */
define( "kAPI_OP_Login",						'WS:OP:Login' );


?>
