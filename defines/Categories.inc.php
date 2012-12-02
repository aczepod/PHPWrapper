<?php

/*=======================================================================================
 *																						*
 *									Categories.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 * Default categories.
 *
 * This file contains the term definitions for all default categories, these terms represent
 * the concept identifiers for all the default object categories.
 *
 * <ul>
 *	<li><i>Main categories</i>: These terms represent the ontology main default categories:
 *	 <ul>
 *		<li><tt>{@link kTERM_ONTOLOGY}</tt>: <i>Ontology</i>. An ontology is a graph
 *			structure composed of nodes related by a series of directed edges, each node
 *			represents a concept that can be used to illustrate a characteristic or feature
 *			of an object, or to tag a set of data elements that are measurements of that
 *			feature. 
 *		<li><tt>{@link kTERM_NAMESPACES}</tt>: <i>Namespaces</i>. Namespaces are terms which
 *			are containers for a set of term identifiers or names based on their
 *			functionality or semantic origin. Such terms are used to allow the
 *			disambiguation of homonym identifiers residing in different namespaces.
 *		<li><tt>{@link kTERM_PREDICATES}</tt>: <i>Predicates</i>. Predicates are terms which
 *			are used to link a subject vertex to an object vertex into a relationship or
 *			graph directed edge.
 *		<li><tt>{@link kTERM_ATTRIBUTES}</tt>: <i>Attributes</i>. Attributes or properties
 *			are the elements that comprise an object, these may represent categories,
 *			descriptions or features. In this ontology, attributes are implemented by a
 *			term, which represents the attribute definition, a node, which represents the
 *			attribute description and the tag, which represents the attribute name.
 *		<li><tt>{@link kTERM_ENUMERATIONS}</tt>: <i>Enumerations</i>. Enumerations are terms
 *			which represent elements of a controlled vocabulary or enumerated set.
 *			Enumeration term local identifiers can be used in local scope, while their
 *			global identifier can unambiguously be used in any scope.
 *	 </ul>
 *	<li><i>Attribute categories</i>: These terms represent the main categories to which the
 *		attributes belong:
 *	 <ul>
 *		<li><tt>{@link kTERM_IDENTIFICATION}</tt>: <i>Identification</i>. Identification
 *			attributes are those which allow the identification, disambiguation or
 *			discrimination of objects. These attributes are used to make an object unique.
 *		<li><tt>{@link kTERM_REFERENCE}</tt>: <i>Reference</i>. Reference attributes allow
 *			the identification and retrieval of related objects. This type of relationship
 *			differs from the graph kind of relationships in that the object embeds the
 *			reference to the other object and does not attach a predicate to the link.
 *		<li><tt>{@link kTERM_CLASSIFICATION}</tt>: <i>Classification</i>. Classification
 *			attributes are categorical qualifications that group objects around a series of
 *			indicators or aggregators. These indicators are generally used as summary keys.
 *		<li><tt>{@link kTERM_ILLUSTRATION}</tt>: <i>Illustration</i>. Illustration
 *			attributes are used to provide definition, description or qualitative
 *			information for an object.
 *		<li><tt>{@link kTERM_AUTHORSHIP}</tt>: <i>Authorship</i>. Authorship attributes are
 *			used to indicate the origin, provenance or authority for an object.
 *		<li><tt>{@link kTERM_STATUS}</tt>: <i>Status</i>. Status attributes indicate the
 *			state, level or outcome of an object or an event. These attributes are also used
 *			to provide statistical information.
 *	 </ul>
 *	<li><i>Enumeration categories</i>: These terms represent the main categories of
 *		enumerated sets:
 *	 <ul>
 *		<li><tt>{@link kTERM_TYPES}</tt>: <i>Types</i>. A type is a generalised
 *			qualification applied to an object. In general this kind of terms will be used
 *			to indicate a data type, scale or unit.
 *		<li><tt>{@link kTERM_KINDS}</tt>: <i>Kinds</i>. A kind is similar to a type, except
 *			that while the type is general, the kind is specific to the class of the object.
 *			Kinds are used to cluster objects of the same class
 *		<li><tt>{@link kTERM_STATES}</tt>: <i>States</i>. State terms indicate the status,
 *			condition or state of an object or event. These classifications are generally
 *			used to qualify the outcome of an operation.
 *		<li><tt>{@link kTERM_OPERATORS}</tt>: <i>Operators</i>. Operators indicate an
 *			operation type, they require a subject operand and often relate the subject to
 *			an object operand. Operators are predicates, except that they always produce a
 *			result.
 *	 </ul>
 *	<li><i>Type categories</i>: These terms represent the type categories:
 *	 <ul>
 *		<li><tt>{@link kTERM_PRIMITIVES}</tt>: <i>Primitives</i>. Primitive types are
 *			scalar data types that represent base types from which all other composite types
 *			are constituted.
 *		<li><tt>{@link kTERM_STRUCTURES}</tt>: <i>Structures</i>. Structures are nested
 *			collections of primitive data types. The data type refers to the structure, not
 *			to the individual primitives
 *		<li><tt>{@link kTERM_ENUMERATED}</tt>: <i>Enumerated</i>. Enumerated type values
 *			must be selected among a finite set of values or from a controlled vocabulary.
 *			Attributes of this type are validated by the set domain.
 *		<li><tt>{@link kTERM_CARDINALITY}</tt>: <i>Cardinality</i>. Cardinality types are
 *			used in conjunction with other types, they indicate whether the value is
 *			required or whether the value is a list. This type acts as a modifier for the
 *			other types.
 *		<li><tt>{@link kTERM_RELATIONSHIP}</tt>: <i>Relationship</i>. Relationship types
 *			enumerate the different kinds of relation, they qualify the relationship flow.
 *	 </ul>
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Definitions
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 01/12/2012
 */

/*=======================================================================================
 *	MAIN CATEGORY TERMS																	*
 *======================================================================================*/

/**
 * Ontology.
 *
 * An ontology is a graph structure composed of nodes related by a series of directed edges,
 * each node represents a concept that can be used to illustrate a characteristic or feature
 * of an object, or to tag a set of data elements that are measurements of that feature.
 */
define( "kTERM_ONTOLOGY",						':ONTOLOGY' );

/**
 * Namespaces.
 *
 * Namespaces are terms that are containers for a set of term identifiers or names based on
 * their functionality or semantic origin. Such terms are used to allow the disambiguation
 * of homonym identifiers residing in different namespaces.
 */
define( "kTERM_NAMESPACES",						':NAMESPACES' );

/**
 * Predicates.
 *
 * Predicates are terms which are used to link a subject vertex to an object vertex into
 * a relationship or graph directed edge. 
 */
define( "kTERM_PREDICATES",						':PREDICATES' );

/**
 * Attributes.
 *
 * Attributes or properties are the elements that comprise an object, these may represent
 * categories, descriptions or features. In this ontology, attributes are implemented by a
 * term, which represents the attribute definition, a node, which represents the attribute
 * description and the tag, which represents the attribute name.
 */
define( "kTERM_ATTRIBUTES",						':ATTRIBUTES' );

/**
 * Enumerations.
 *
 * Enumerations are terms which represent elements of a controlled vocabulary or enumerated
 * set. The local identifier of these terms can be used as the value of an attribute typed
 * as an enumerated set, while their global identifier can unambiguously be used in any
 * scope.
 */
define( "kTERM_ENUMERATIONS",					':ENUMERATIONS' );

/*=======================================================================================
 *	ATTRIBUTE CATEGORY TERMS															*
 *======================================================================================*/

/**
 * Identification.
 *
 * Identification attributes are those which allow the identification, disambiguation or
 * discrimination of objects. These attributes are used to make an object unique.
 */
define( "kTERM_IDENTIFICATION",					':IDENTIFICATION' );

/**
 * Reference.
 *
 * Reference attributes allow the identification and retrieval of related objects. This type
 * of relationship differs from the graph kind of relationships in that the object embeds
 * the reference to the other object and does not attach a predicate to the link.
 */
define( "kTERM_REFERENCE",						':REFERENCE' );

/**
 * Classification.
 *
 * Classification attributes are categorical qualifications that group objects around a
 * series of indicators or aggregators. These indicators are generally used as summary keys.
 */
define( "kTERM_CLASSIFICATION",					':CLASSIFICATION' );

/**
 * Illustration.
 *
 * Illustration attributes are used to provide definition, description or qualitative
 * information for an object. 
 */
define( "kTERM_ILLUSTRATION",					':ILLUSTRATION' );

/**
 * Authorship.
 *
 * Authorship attributes are used to indicate the origin, provenance or authority for an
 * object.
 */
define( "kTERM_AUTHORSHIP",						':AUTHORSHIP' );

/**
 * Status.
 *
 * Status attributes indicate the state, level or outcome of an object or an event. These
 * attributes are also used to provide statistical information.
 */
define( "kTERM_STATUS",							':STATUS' );

/*=======================================================================================
 *	ENUMERATION CATEGORY TERMS															*
 *======================================================================================*/

/**
 * Types.
 *
 * A type is a generalised qualification applied to an object. In general this kind of terms
 * will be used to indicate a data type, scale or unit.
 */
define( "kTERM_TYPES",							':TYPES' );

/**
 * Kinds.
 *
 * A kind is similar to a type, except that while the type is general, the kind is specific
 * to the class of the object. Kinds are used to cluster objects of the same class.
 */
define( "kTERM_KINDS",							':KINDS' );

/**
 * States.
 *
 * State terms indicate the status, condition or state of an object or event. These
 * classifications are generally used to qualify the outcome of an operation.
 */
define( "kTERM_STATES",							':STATES' );

/**
 * Operators.
 *
 * Operators indicate an operation type, they require a subject operand and often relate the
 * subject to an object operand. Operators are predicates, except that they always produce a
 * result.
 */
define( "kTERM_OPERATORS",						':OPERATORS' );

/*=======================================================================================
 *	TYPE CATEGORY TERMS																	*
 *======================================================================================*/

/**
 * Primitives.
 *
 * Primitives are scalar types that represent the building blocks of all other composite
 * types.
 */
define( "kTERM_PRIMITIVES",						':PRIMITIVES' );

/**
 * Structures.
 *
 * Structures are nested collections of primitive data types. The data type refers to the
 * structure, not to the individual primitives.
 */
define( "kTERM_STRUCTURES",						':STRUCTURES' );

/**
 * Enumerated.
 *
 * Enumerated type values must be selected among a finite set of values or from a controlled
 * vocabulary. Attributes of this type are validated by the set domain.
 */
define( "kTERM_ENUMERATED",						':ENUMERATED' );

/**
 * Cardinality.
 *
 * Cardinality types are used in conjunction with other types, they indicate whether the
 * value is required or whether the value is a list. This type acts as a modifier for the
 * other types.
 */
define( "kTERM_CARDINALITY",					':CARDINALITY' );

/**
 * Relationship.
 *
 * Relationship types enumerate the different kinds of relation, they qualify the
 * relationship flow.
 */
define( "kTERM_RELATIONSHIP",					':RELATIONSHIP' );


?>
