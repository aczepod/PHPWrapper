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


?>
