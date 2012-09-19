<?php

/*=======================================================================================
 *																						*
 *									CQuery.inc.php										*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link CQuery CQuery} definitions.
 *
 *	This file contains common definitions used by the {@link CQuery CQuery} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 19/09/2012
 */

/*=======================================================================================
 *	DEFAULT QUERY COMPONENT TAGS														*
 *======================================================================================*/

/**
 * Query subject.
 *
 * This is the tag that represents the query subject.
 *
 * Cardinality: one or zero.
 */
define( "kOFFSET_QUERY_SUBJECT",				'_query-subject' );

/**
 * Query operator.
 *
 * This is the tag that represents the query operator.
 *
 * Cardinality: one or zero.
 */
define( "kOFFSET_QUERY_OPERATOR",				'_query-operator' );

/**
 * Query data type.
 *
 * This is the tag that represents the query data type.
 *
 * Cardinality: one or zero.
 */
define( "kOFFSET_QUERY_TYPE",					'_query-data-type' );

/**
 * Query data.
 *
 * This is the tag that represents the query data.
 *
 * Cardinality: one or zero.
 */
define( "kOFFSET_QUERY_DATA",					'_query-data' );

?>
