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
 *	DEFAULT OPERATION ENUMERATIONS														*
 *======================================================================================*/

/**
 * HELP web-service.
 *
 * This is the tag that represents the HELP web-service operation, which returns the list
 * of supported operations and options.
 */
define( "kAPI_OP_HELP",				'$HELP' );

/**
 * PING web-service.
 *
 * This is the tag that represents the PING web-service operation, which returns a status
 * response.
 */
define( "kAPI_OP_PING",				'$PING' );

/*=======================================================================================
 *	DEFAULT PROPERTY TAGS																*
 *======================================================================================*/

/**
 * Web-service format.
 *
 * This is the tag that represents the web-service request and response format.
 *
 * This applies both to the request and the response; if the parameter is not provided we
 * assume the {@link kTYPE_JSON JSON} format.
 *
 * Cardinality: one.
 */
define( "kAPI_FORMAT",				':@format' );

/**
 * Web-service operation.
 *
 * This is the tag that represents the web-service operation.
 *
 * Cardinality: one.
 */
define( "kAPI_OPERATION",			':@operation' );

/*=======================================================================================
 *	DEFAULT OPTION TAGS																	*
 *======================================================================================*/

/**
 * Log request.
 *
 * If the value of this tag resolves to <i>TRUE</i>, the request will be logged in the
 * response.
 *
 * Cardinality: one or zero.
 */
define( "kAPI_OPT_LOG_REQUEST",		':@log-request' );

/**
 * Trace errors.
 *
 * If the value of this tag resolves to <i>TRUE</i>, eventual errors will bare the trace.
 *
 * Cardinality: one or zero.
 */
define( "kAPI_OPT_LOG_TRACE",		':@log-trace' );

/*=======================================================================================
 *	DEFAULT TIMING TAGS																	*
 *======================================================================================*/

/**
 * Web-service request time stamp.
 *
 * This is the tag that represents the request time stamp, it should contain the timestamp
 * in which the client sent the request; if present, the service will return the following
 * time stamps:
 *
 * <ul>
 *	<li><i>{@link kAPI_REC_STAMP}</i>: Received time stamp.
 *	<li><i>{@link kAPI_PARSE_STAMP}</i>: Parsed time stamp.
 *	<li><i>{@link kAPI_RES_STAMP}</i>: Response time stamp.
 * </ul>
 *
 * These values are provided as floating point numbers such as the result of the
 * <i>gettimeofday( true )</i> function.
 *
 * Cardinality: one or zero.
 */
define( "kAPI_REQ_STAMP",			':@time-request' );

/**
 * Web-service received time stamp.
 *
 * This is the tag that represents the time stamp in which the request was received.
 *
 * These values are provided as floating point numbers such as the result of the
 * <i>gettimeofday( true )</i> function.
 *
 * Cardinality: one or zero.
 */
define( "kAPI_REC_STAMP",			':@time-received' );

/**
 * Web-service parsed time stamp.
 *
 * This is the tag that represents the time stamp in which the request was parsed.
 *
 * These values are provided as floating point numbers such as the result of the
 * <i>gettimeofday( true )</i> function.
 *
 * Cardinality: one or zero.
 */
define( "kAPI_PARSE_STAMP",			':@time-parsed' );

/**
 * Web-service response time stamp.
 *
 * This is the tag that represents the time stamp in which the response was sent.
 *
 * These values are provided as floating point numbers such as the result of the
 * <i>gettimeofday( true )</i> function.
 *
 * Cardinality: one or zero.
 */
define( "kAPI_RES_STAMP",			':@time-sent' );

/*=======================================================================================
 *	DEFAULT RESPONSE TAGS																*
 *======================================================================================*/

/**
 * Request.
 *
 * This tag holds the request block.
 */
define( "kAPI_DATA_REQUEST",		'_request' );

/**
 * Status.
 *
 * This tag holds the operation status block.
 */
define( "kAPI_DATA_STATUS",			'_status' );

/**
 * Severity.
 *
 * This tag holds the response severity code.
 */
define( "kAPI_SEVERITY",			'_severity' );

/**
 * Code.
 *
 * This tag holds the response status code.
 */
define( "kAPI_RESPONSE_CODE",		'_code' );

/**
 * Message block.
 *
 * This tag holds the response message block.
 */
define( "kAPI_MESSAGE",				'_message' );

/**
 * Message language.
 *
 * This tag holds the response message language code.
 */
define( "kAPI_MESSAGE_LANGUAGE",	'_message_lang' );

/**
 * Message string.
 *
 * This tag holds the response message string.
 */
define( "kAPI_MESSAGE_STRING",		'_message_string' );

/**
 * Annotations.
 *
 * This offset represents the collector tag for response annotations.
 */
define( "kAPI_ANNOTATIONS",			'_annotations' );

/**
 * Timing.
 *
 * This offset represents the collector tag for request timing parameters.
 *
 * <i>Note: this is a <b>reserved offset tag</b>.</i>
 */
define( "kAPI_DATA_TIMING",			'_timing' );

/**
 * Response.
 *
 * This tag holds the response block.
 */
define( "kAPI_DATA_RESPONSE",		'_response' );

?>
