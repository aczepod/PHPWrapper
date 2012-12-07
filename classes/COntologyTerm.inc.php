<?php

/*=======================================================================================
 *																						*
 *								COntologyTerm.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link COntologyTerm} definitions.
 *
 *	This file contains common definitions used by the {@link COntologyTerm} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 08/09/2012
 */

/*=======================================================================================
 *	DEFAULT CONTAINER NAMES																*
 *======================================================================================*/

/**
 * Terms container name.
 *
 * This tag identifies the default name for the container that will host term objects.
 */
define( "kCONTAINER_TERM_NAME",					':_terms' );

/*=======================================================================================
 *	REFERENCE SWITCHES																	*
 *======================================================================================*/

/**
 * Namespace references.
 *
 * This switch determines whether to keep track of terms that reference the current term as
 * a namespace. The switch can take the following values:
 *
 * <ul>
 *	<li><tt>0x2</tt>: <i>Keep count of namespace references</i>. This means that the
 *		{@link kTAG_NAMESPACE_REFS} attribute will be an integer representing the number of
 *		times the current term was referenced as a namespace.
 *	<li><tt>0x3</tt>: <i>Keep list of namespace references</i>. This means that the
 *		{@link kTAG_NAMESPACE_REFS} attribute will be a list of term references representing
 *		the native identifier of all terms that reference the current one as a namespace.
 *	<li><tt>0x0</tt> <i>or other</i>: <i>Don't handle this information</i>. This means that
 *		the {@link kTAG_NAMESPACE_REFS} attribute will not be handled.
 * </ul>
 */
define( "kSWITCH_kTAG_NAMESPACE_REFS",			0x0 );

/**
 * Node references.
 *
 * This switch determines whether to keep track of nodes that reference the current term,
 * it determines how the {@link kTAG_NODES} is managed: please refer to the documentation
 * on the {@link kSWITCH_kTAG_NAMESPACE_REFS} switch.
 */
define( "kSWITCH_kTAG_NODES",					0x0 );

/**
 * Feature references.
 *
 * This switch determines whether to keep track of tags whose first node in their path
 * references the current term, it determines how the {@link kTAG_FEATURES} attribute is
 * managed: please refer to the documentation on the {@link kSWITCH_kTAG_NAMESPACE_REFS}
 * switch.
 */
define( "kSWITCH_kTAG_FEATURES",				0x3 );

/**
 * Method references.
 *
 * This switch determines whether to keep track of tags whose path nodes, that are between
 * the first and last elements, reference the current term, it determines how the
 * {@link kTAG_METHODS} attribute is managed: please refer to the documentation on the
 * {@link kSWITCH_kTAG_NAMESPACE_REFS} switch.
 */
define( "kSWITCH_kTAG_METHODS",					0x3 );

/**
 * Scale references.
 *
 * This switch determines whether to keep track of tags whose last node in their path
 * references the current term, it determines how the {@link kTAG_SCALES} attribute is
 * managed: please refer to the documentation on the {@link kSWITCH_kTAG_NAMESPACE_REFS}
 * switch.
 */
define( "kSWITCH_kTAG_SCALES",					0x3 );


?>
