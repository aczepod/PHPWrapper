<?php

/*=======================================================================================
 *																						*
 *									Status.inc.php										*
 *																						*
 *======================================================================================*/
 
/**
 *	Status codes.
 *
 *	This file contains the HTTP status codes that will be used in this library.
 *
 *	@package	MyWrapper
 *	@subpackage	Definitions
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 30/10/2009
 */

/**
 * HTTP_STATUS_CONTINUE.
 *
 * The request can be continued.
 */
define( "HTTP_STATUS_CONTINUE",							100 );

/**
 * HTTP_STATUS_SWITCH_PROTOCOLS.
 *
 * The server has switched protocols in an upgrade header.
 */
define( "HTTP_STATUS_SWITCH_PROTOCOLS",					101 );

/**
 * HTTP_STATUS_OK.
 *
 * The request completed successfully.
 */
define( "HTTP_STATUS_OK",								200 );

/**
 * HTTP_STATUS_CREATED.
 *
 * The request has been fulfilled and resulted in the creation of a new resource.
 */
define( "HTTP_STATUS_CREATED",							201 );

/**
 * HTTP_STATUS_ACCEPTED.
 *
 * The request has been accepted for processing, but the processing has not been completed.
 */
define( "HTTP_STATUS_ACCEPTED",							202 );

/**
 * HTTP_STATUS_PARTIAL.
 *
 * The returned meta information in the entity-header is not the definitive set available
 * from the origin server.
 */
define( "HTTP_STATUS_PARTIAL",							203 );

/**
 * HTTP_STATUS_NO_CONTENT.
 *
 * The server has fulfilled the request, but there is no new information to send back.
 */
define( "HTTP_STATUS_NO_CONTENT",						204 );

/**
 * HTTP_STATUS_RESET_CONTENT.
 *
 * The request has been completed, and the client program should reset the document view
 * that caused the request to be sent to allow the user to easily initiate another input
 * action.
 */
define( "HTTP_STATUS_RESET_CONTENT",					205 );

/**
 * HTTP_STATUS_PARTIAL_CONTENT.
 *
 * The server has fulfilled the partial GET request for the resource.
 */
define( "HTTP_STATUS_PARTIAL_CONTENT",					206 );

/**
 * HTTP_STATUS_AMBIGUOUS.
 *
 * The server couldn't decide what to return.
 */
define( "HTTP_STATUS_AMBIGUOUS",						300 );

/**
 * HTTP_STATUS_MOVED.
 *
 * The requested resource has been assigned to a new permanent URI (Uniform Resource
 * Identifier), and any future references to this resource should be done using one of the
 * returned URIs.
 */
define( "HTTP_STATUS_MOVED",							301 );

/**
 * HTTP_STATUS_REDIRECT.
 *
 * The requested resource resides temporarily under a different URI (Uniform Resource
 * Identifier).
 */
define( "HTTP_STATUS_REDIRECT",							302 );

/**
 * HTTP_STATUS_REDIRECT_METHOD.
 *
 * The response to the request can be found under a different URI (Uniform Resource
 * Identifier) and should be retrieved using a GET HTTP verb on that resource.
 */
define( "HTTP_STATUS_REDIRECT_METHOD",					303 );

/**
 * HTTP_STATUS_NOT_MODIFIED.
 *
 * The requested resource has not been modified.
 */
define( "HTTP_STATUS_NOT_MODIFIED",						304 );

/**
 * HTTP_STATUS_USE_PROXY.
 *
 * The requested resource must be accessed through the proxy given by the location field.
 */
define( "HTTP_STATUS_USE_PROXY",						305 );

/**
 * HTTP_STATUS_REDIRECT_KEEP_VERB.
 *
 * The redirected request keeps the same HTTP verb. HTTP/1.1 behavior.
 */
define( "HTTP_STATUS_REDIRECT_KEEP_VERB",				307 );

/**
 * HTTP_STATUS_BAD_REQUEST.
 *
 * The request could not be processed by the server due to invalid syntax.
 */
define( "HTTP_STATUS_BAD_REQUEST",						400 );

/**
 * HTTP_STATUS_DENIED.
 *
 * The requested resource requires user authentication.
 */
define( "HTTP_STATUS_DENIED",							401 );

/**
 * HTTP_STATUS_PAYMENT_REQ.
 *
 * Not currently implemented in the HTTP protocol.
 */
define( "HTTP_STATUS_PAYMENT_REQ",						402 );

/**
 * HTTP_STATUS_FORBIDDEN.
 *
 * The server understood the request, but is refusing to fulfill it.
 */
define( "HTTP_STATUS_FORBIDDEN",						403 );

/**
 * HTTP_STATUS_NOT_FOUND.
 *
 * The server has not found anything matching the requested URI (Uniform Resource
 * Identifier).
 */
define( "HTTP_STATUS_NOT_FOUND",						404 );

/**
 * HTTP_STATUS_BAD_METHOD.
 *
 * The HTTP verb used is not allowed.
 */
define( "HTTP_STATUS_BAD_METHOD",						405 );

/**
 * HTTP_STATUS_NONE_ACCEPTABLE.
 *
 * No responses acceptable to the client were found.
 */
define( "HTTP_STATUS_NONE_ACCEPTABLE",					406 );

/**
 * HTTP_STATUS_PROXY_AUTH_REQ.
 *
 * Proxy authentication required.
 */
define( "HTTP_STATUS_PROXY_AUTH_REQ",					407 );

/**
 * HTTP_STATUS_REQUEST_TIMEOUT.
 *
 * The server timed out waiting for the request.
 */
define( "HTTP_STATUS_REQUEST_TIMEOUT",					408 );

/**
 * HTTP_STATUS_CONFLICT.
 *
 * The request could not be completed due to a conflict with the current state of the
 * resource. The user should resubmit with more information.
 */
define( "HTTP_STATUS_CONFLICT",							409 );

/**
 * HTTP_STATUS_GONE.
 *
 * The requested resource is no longer available at the server, and no forwarding address is
 * known.
 */
define( "HTTP_STATUS_GONE",								410 );

/**
 * HTTP_STATUS_LENGTH_REQUIRED.
 *
 * The server refuses to accept the request without a defined content length.
 */
define( "HTTP_STATUS_LENGTH_REQUIRED",					411 );

/**
 * HTTP_STATUS_PRECOND_FAILED.
 *
 * The precondition given in one or more of the request header fields evaluated to false
 * when it was tested on the server.
 */
define( "HTTP_STATUS_PRECOND_FAILED",					412 );

/**
 * HTTP_STATUS_REQUEST_TOO_LARGE.
 *
 * The server is refusing to process a request because the request entity is larger than the
 * server is willing or able to process.
 */
define( "HTTP_STATUS_REQUEST_TOO_LARGE",				413 );

/**
 * HTTP_STATUS_URI_TOO_LONG.
 *
 * The server is refusing to service the request because the request URI (Uniform Resource
 * Identifier) is longer than the server is willing to interpret.
 */
define( "HTTP_STATUS_URI_TOO_LONG",						414 );

/**
 * HTTP_STATUS_UNSUPPORTED_MEDIA.
 *
 * The server is refusing to service the request because the entity of the request is in a
 * format not supported by the requested resource for the requested method.
 */
define( "HTTP_STATUS_UNSUPPORTED_MEDIA",				415 );

/**
 * HTTP_STATUS_RETRY_WITH.
 *
 * The request should be retried after doing the appropriate action.
 */
define( "HTTP_STATUS_RETRY_WITH",						449 );

/**
 * HTTP_STATUS_SERVER_ERROR.
 *
 * The server encountered an unexpected condition that prevented it from fulfilling the
 * request.
 */
define( "HTTP_STATUS_SERVER_ERROR",						500 );

/**
 * HTTP_STATUS_NOT_SUPPORTED.
 *
 * The server does not support the functionality required to fulfill the request.
 */
define( "HTTP_STATUS_NOT_SUPPORTED",					501 );

/**
 * HTTP_STATUS_BAD_GATEWAY.
 *
 * The server, while acting as a gateway or proxy, received an invalid response from the
 * upstream server it accessed in attempting to fulfill the request.
 */
define( "HTTP_STATUS_BAD_GATEWAY",						502 );

/**
 * HTTP_STATUS_SERVICE_UNAVAIL.
 *
 * The service is temporarily overloaded.
 */
define( "HTTP_STATUS_SERVICE_UNAVAIL",					503 );

/**
 * HTTP_STATUS_GATEWAY_TIMEOUT.
 *
 * The request was timed out waiting for a gateway.
 */
define( "HTTP_STATUS_GATEWAY_TIMEOUT",					504 );

/**
 * HTTP_STATUS_VERSION_NOT_SUP.
 *
 * The server does not support, or refuses to support, the HTTP protocol version that was
 * used in the request message.
 */
define( "HTTP_STATUS_VERSION_NOT_SUP",					505 );


?>
