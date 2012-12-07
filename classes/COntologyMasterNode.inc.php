<?php

/*=======================================================================================
 *																						*
 *								COntologyMasterNode.inc.php								*
 *																						*
 *======================================================================================*/
 
/**
 *	{@link COntologyMasterNode} definitions.
 *
 *	This file contains common definitions used by the {@link COntologyMasterNode} class.
 *
 *	@package	MyWrapper
 *	@subpackage	Ontology
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 06/12/2012
 */

/*=======================================================================================
 *	REFERENCE SWITCHES																	*
 *======================================================================================*/

/**
 * Node references.
 *
 * This switch determines whether to keep track of alias nodes that reference the current
 * node as a master. The switch can take the following values:
 *
 * <ul>
 *	<li><tt>0x2</tt>: <i>Keep count of references</i>. This means that the
 *		{@link kTAG_NODES} attribute will be an integer representing the number of
 *		times the current node was referenced as a master node from an alias node.
 *	<li><tt>0x3</tt>: <i>Keep list of references</i>. This means that the
 *		{@link kTAG_NODES} attribute will be a list of alias node references representing
 *		the native identifier of all nodes that reference the current node as a master.
 *	<li><tt>0x0</tt> <i>or other</i>: <i>Don't handle this information</i>. This means that
 *		the {@link kTAG_NODES} attribute will not be handled.
 * </ul>
 */
define( "kSWITCH_kTAG_ALIAS_NODES",				0x0 );


?>
