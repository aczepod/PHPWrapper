<?php

/*=======================================================================================
 *																						*
 *										Kinds.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 * Kind definitions.
 *
 * This file contains the term global identifiers of the default node and term kind
 * enumerations.
 *
 * Ontology terms and nodes have a category called <i>kind</i> which represents the function
 * of the term or node within the ontology:
 *
 * <ul>
 *	<li><tt>{@link kKIND_ROOT}</tt>: Root. This represents a door or entry point of an
 *		ontology. It can be either the node from which the whole graph or tree originates
 *		from, or a node that represents a specific thematic entry point. In general, such
 *		objects will be used as elements of an index to an ontology.
 *	<li><tt>{@link kKIND_FEATURE}</tt>: Feature . This kind of object defines a feature,
 *		property or attribute of an object that can be described or measured. This kind of
 *		node will generally be found as a leaf of the structure describing an
 *		object. Plant height is a plant characteristic that belongs to the category of
 *		morphological traits: the latter is not a feature, while plant height is.
 *	<li><tt>{@link kKIND_METHOD}</tt>: Method node. This kind of node is required
 *		whenever an object's feature can be measured in different ways or with different
 *		workflows without becoming a different feature. Plant height is an attribute of a
 *		plant which can be measured after a month or at flowering time; the attribute is the
 *		same, but the method is different.
 *	<li><tt>{@link kKIND_SCALE}</tt>: Scale node. This kind of node describes in what
 *		unit or scale a measurement is expressed in. Plant height may be measured in
 *		centimeters or inches, as well as in intervals or finite categories.
 *	<li><tt>{@link kKIND_INSTANCE}</tt>: Instance node. In general, ontology nodes
 *		represent metadata, in some cases nodes may represent actual data: an instance node
 *		is a node that represents the metadata and data of an object. An ISO 3166 country
 *		code can be considered an enumeration node that constitutes the metadata for the
 *		country it represents, but if you store data regarding that country in the node,
 *		this may become also an instance node, because it represents the object it defines.
 *	<li><tt>{@link kKIND_ENUMERATION}</tt>: Enumeration. This kind of node describes a
 *		controlled vocabulary element. These nodes derive from scale nodes and represent the
 *		valid choices of enumeration and enumerated set scale nodes. An ISO 3166 country
 *		code could be considered an enumeration node.
 *	<li><tt>{@link kKIND_NAMESPACE}</tt>: Namespace. This kind of term represents a
 *		namespace, semantic group or ID space. Terms of this kind will generally be used to
 *		group identifiers.
 *	<li><tt>{@link kKIND_PREDICATE}</tt>: Predicate. This kind of term represents a
 *		predicate, or element which connects subject and object vertices into a
 *		relationship.
 *	<li><tt>{@link kKIND_SYMMETRIC}</tt>: Symmetric predicate. This kind of term
 *		represents a predicate which relates two terms in both directions. By default,
 *		relationships are directional, that is they originate from the subject towards the
 *		object, but not in the opposite direction: this kind of predicate, instead, does not
 *		have the concept of direction, the relationship flows in both directions.
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
 * Root.
 *
 * An entry point of an ontology.
 *
 * This represents a door or entry point of an ontology. It can be either the node from
 * which the whole graph or tree originates from, or a node that represents a specific
 * thematic entry point. In general, such objects will be used as elements of an index to an
 * ontology.
 *
 * Version 1: (kKIND_ROOT)[:ROOT]
 */
define( "kKIND_ROOT",							':KIND-ROOT' );

/**
 * Feature.
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
define( "kKIND_FEATURE",						':KIND-FEATURE' );

/**
 * Method.
 *
 * A method or variation of an object's feature measurement.
 *
 * This kind of node is required whenever an object's feature can be measured in different
 * ways or with different workflows without becoming a different feature. Plant height is an
 * attribute of a plant which can be measured after a month or at flowering time; the
 * attribute is the same, but the method is different.
 *
 * Version 1: (kKIND_METHOD)[:METHOD]
 */
define( "kKIND_METHOD",							':KIND-METHOD' );

/**
 * Scale.
 *
 * The scale or unit in which a measurement is expressed in.
 *
 * This kind of node describes in what unit or scale a measurement is expressed in. Plant
 * height may be measured in centimeters or inches, as well as in intervals or finite
 * categories.
 *
 * Version 1: (kKIND_SCALE)[:SCALE]
 */
define( "kKIND_SCALE",							':KIND-SCALE' );

/**
 * Instance.
 *
 * A metadata instance.
 *
 * In general, ontology nodes represent metadata, in some cases nodes may represent actual
 * data: an instance node is a node that represents the metadata and data of an object. An
 * ISO 3166 country code can be considered an enumeration node that constitutes the metadata
 * for the country it represents, but if you store data regarding that country in the node,
 * this may become also an instance node, because it represents the object it defines.
 *
 * Version 1: (kKIND_INSTANCE)[:INSTANCE]
 */
define( "kKIND_INSTANCE",						':KIND-INSTANCE' );

/**
 * Enumeration.
 *
 * An element of a controlled vocabulary.
 *
 * This kind of node describes a controlled vocabulary element. These nodes derive from
 * scale nodes and represent the valid choices of enumeration and enumerated set scale
 * nodes. An ISO 3166 country code could be considered an enumeration node.
 *
 * Version 1: (kKIND_ENUMERATION)[:ENUMERATION]
 */
define( "kKIND_ENUMERATION",					':KIND-ENUMERATION' );

/**
 * Namespace.
 *
 * Namespace.
 *
 * This kind of term represents a namespace, semantic group or ID space. Terms of this kind
 * will generally be used to group identifiers.
 *
 * Version 1: (kKIND_NAMESPACE)[:KIND-NAMESPACE]
 */
define( "kKIND_NAMESPACE",						':KIND-NAMESPACE' );

/**
 * Predicate.
 *
 * Predicate.
 *
 * This kind of term represents a predicate, or element which connects subject and object
 * vertices into a relationship.
 *
 * Version 1: (kKIND_PREDICATE)[:KIND-PREDICATE]
 */
define( "kKIND_PREDICATE",						':KIND-PREDICATE' );

/**
 * Symmetric predicate term.
 *
 * Symmetric predicate.
 *
 * This kind of term represents a predicate which relates two terms in both directions. By
 * default, relationships are directional, that is they originate from the subject towards
 * the object, but not in the opposite direction: this kind of predicate, instead, does not
 * have the concept of direction, the relationship flows in both directions.
 *
 * Version 1: (kKIND_SYMMETRIC)[:KIND-SYMMETRIC]
 */
define( "kKIND_SYMMETRIC",						':KIND-SYMMETRIC' );


?>
