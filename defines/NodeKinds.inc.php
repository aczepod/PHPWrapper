<?php

/*=======================================================================================
 *																						*
 *									NodeKinds.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 * Node kind definitions.
 *
 * This file contains the term global identifiers of the default node kind enumerations.
 *
 * Ontology nodes have a category called <i>kind</i> which represents the function of the
 * node within the ontology:
 *
 * <ul>
 *	<li><tt>{@link kKIND_NODE_ROOT}</tt>: Root node. This kind of node represents a door or
 *		entry point of an ontology. It can be either the node from which the whole graph or
 *		tree originates from, or a node that represents a specific thematic entry point.
 *		In general, such nodes will be used as elements of an index to an ontology.
 *	<li><tt>{@link kKIND_NODE_FEATURE}</tt>: Feature node. This kind of node defines a
 *		feature, property or attribute of an object that can be described or measured. This
 *		kind of node will generally be found as a leaf of the structure describing an
 *		object. Plant height is a plant characteristic that belongs to the category of
 *		morphological traits: the latter is not a feature, while plant height is.
 *	<li><tt>{@link kKIND_NODE_METHOD}</tt>: Method node. This kind of node is required
 *		whenever an object's feature can be measured in different ways or with different
 *		workflows without becoming a different feature. Plant height is an attribute of a
 *		plant which can be measured after a month or at flowering time; the attribute is the
 *		same, but the method is different.
 *	<li><tt>{@link kKIND_NODE_SCALE}</tt>: Scale node. This kind of node describes in what
 *		unit or scale a measurement is expressed in. Plant height may be measured in
 *		centimeters or inches, as well as in intervals or finite categories.
 *	<li><tt>{@link kKIND_NODE_ENUM}</tt>: Enumeration node. This kind of node describes a
 *		controlled vocabulary element. These nodes derive from scale nodes and represent the
 *		valid choices of enumeration and enumerated set scale nodes. An ISO 3166 country
 *		code could be considered an enumeration node.
 *	<li><tt>{@link kKIND_NODE_INSTANCE}</tt>: Instance node. In general, ontology nodes
 *		represent metadata, in some cases nodes may represent actual data: an instance node
 *		is a node that represents the metadata and data of an object. An ISO 3166 country
 *		code can be considered an enumeration node that constitutes the metadata for the
 *		country it represents, but if you store data regarding that country in the node,
 *		this may become also an instance node, because it represents the object it defines.
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Definitions
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 22/11/2012
 */

/*=======================================================================================
 *	DEFAULT NODE KINDS																	*
 *======================================================================================*/

/**
 * Root node.
 *
 * An entry point of an ontology.
 *
 * This kind of node represents a door or entry point of an ontology. It can be either the
 * node from which the whole graph or tree originates from, or a node that represents a
 * specific thematic entry point. In general, such nodes will be used as elements of an
 * index to an ontology.
 *
 * Version 1: (kKIND_NODE_ROOT)[:ROOT]
 */
define( "kKIND_NODE_ROOT",						':NODE-KIND-ROOT' );

/**
 * Feature node.
 *
 * A feature or attribute of an object that can be described or measured.
 *
 * This kind of node defines a feature, property or attribute of an object that can be
 * described or measured. This kind of node will generally be found as a leaf of the
 * structure describing an object. Plant height is a plant characteristic that belongs to
 * the category of morphological traits: the latter is not a feature, while plant height is.
 *
 * Version 1: (kKIND_NODE_TRAIT)[:TRAIT]
 */
define( "kKIND_NODE_FEATURE",					':NODE-KIND-FEATURE' );

/**
 * Method node.
 *
 * A method or variation of an object's feature measurement.
 *
 * This kind of node is required whenever an object's feature can be measured in different
 * ways or with different workflows without becoming a different feature. Plant height is an
 * attribute of a plant which can be measured after a month or at flowering time; the
 * attribute is the same, but the method is different.
 *
 * Version 1: (kKIND_NODE_METHOD)[:METHOD]
 */
define( "kKIND_NODE_METHOD",					':NODE-KIND-METHOD' );

/**
 * Scale node.
 *
 * The scale or unit in which a measurement is expressed in.
 *
 * This kind of node describes in what unit or scale a measurement is expressed in. Plant
 * height may be measured in centimeters or inches, as well as in intervals or finite
 * categories.
 *
 * Version 1: (kKIND_NODE_SCALE)[:SCALE]
 */
define( "kKIND_NODE_SCALE",						':NODE-KIND-SCALE' );

/**
 * Enumeration node.
 *
 * An element of a controlled vocabulary.
 *
 * This kind of node describes a controlled vocabulary element. These nodes derive from
 * scale nodes and represent the valid choices of enumeration and enumerated set scale
 * nodes. An ISO 3166 country code could be considered an enumeration node.
 *
 * Version 1: (kKIND_NODE_ENUMERATION)[:ENUMERATION]
 */
define( "kKIND_NODE_ENUMERATION",				':NODE-KIND-ENUMERATION' );

/**
 * Instance node.
 *
 * A metadata instance.
 *
 * In general, ontology nodes represent metadata, in some cases nodes may represent actual
 * data: an instance node is a node that represents the metadata and data of an object. An
 * ISO 3166 country code can be considered an enumeration node that constitutes the metadata
 * for the country it represents, but if you store data regarding that country in the node,
 * this may become also an instance node, because it represents the object it defines.
 *
 * Version 1: (kKIND_NODE_INSTANCE)[:INSTANCE]
 */
define( "kKIND_NODE_INSTANCE",					':NODE-KIND-INSTANCE' );


?>
