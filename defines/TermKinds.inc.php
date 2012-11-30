<?php

/*=======================================================================================
 *																						*
 *									TermKinds.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 * Term kind definitions.
 *
 * This file contains the term global identifiers of the default term kind enumerations.
 *
 * Ontology terms have a category called <i>kind</i> which represents the function of the
 * term within the ontology. Terms can be used for any purpose, since they do not consider
 * a context, however, sometimes it may be useful to tag a specific function to a term in
 * order to advise on its use:
 *
 * <ul>
 *	<li><tt>{@link kKIND_TERM_NAMESPACE}</tt>: Namespace. This kind of term represents a
 *		namespace, semantic group or ID space. Terms of this kind will generally be used to
 *		group identifiers.
 *	<li><tt>{@link kKIND_TERM_PREDICATE}</tt>: Predicate. This kind of term represents a
 *		predicate, or element which connects subject and object vertices into a
 *		relationship.
 *	<li><tt>{@link kKIND_TERM_ENUMERATION}</tt>: Enumeration. This kind of term represents
 *		an enumeration, or an element of a controlled vocabulary.
 *	<li><tt>{@link kKIND_TERM_SYMMETRIC}</tt>: Symmetric predicate. This kind of term
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
 *	@version	1.00 29/11/2012
 */

/*=======================================================================================
 *	DEFAULT TERM KINDS																	*
 *======================================================================================*/

/**
 * Namespace term.
 *
 * Namespace.
 *
 * This kind of term represents a namespace, semantic group or ID space. Terms of this kind
 * will generally be used to group identifiers.
 *
 * Version 1: (kKIND_TERM_NAMESPACE)[:TERM-KIND-NAMESPACE]
 */
define( "kKIND_TERM_NAMESPACE",					':TERM-KIND-NAMESPACE' );

/**
 * Predicate term.
 *
 * Predicate.
 *
 * This kind of term represents a predicate, or element which connects subject and object
 * vertices into a relationship.
 *
 * Version 1: (kKIND_TERM_PREDICATE)[:TERM-KIND-PREDICATE]
 */
define( "kKIND_TERM_PREDICATE",					':TERM-KIND-PREDICATE' );

/**
 * Enumeration term.
 *
 * Enumeration.
 *
 * This kind of term represents an enumeration, or an element of a controlled vocabulary.
 * When linking a node to a term, terms of this kind should only be linked by a single node,
 * which means that there should only be one instance of an enumeration.
 *
 * Version 1: (kKIND_TERM_ENUMERATION)[:TERM-KIND-ENUMERATION]
 */
define( "kKIND_TERM_ENUMERATION",				':TERM-KIND-ENUMERATION' );

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
 * Version 1: (kKIND_TERM_SYMMETRIC)[:TERM-KIND-SYMMETRIC]
 */
define( "kKIND_TERM_SYMMETRIC",					':TERM-KIND-SYMMETRIC' );


?>
