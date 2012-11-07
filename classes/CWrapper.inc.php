<?php

/*=======================================================================================
 *																						*
 *									CWrapper.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link CWrapper} definitions.
 *
 *	This file contains common definitions used by the {@link CWrapper}
 *	class.
 *
 *	@package	MyWrapper
 *	@subpackage	Wrappers
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 03/06/2011
 *				2.00 22/02/2012
 *				3.00 31/10/2012
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


?>
