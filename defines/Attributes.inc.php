<?php

/*=======================================================================================
 *																						*
 *									Attributes.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	Attributes.
 *
 *	This file contains common attribute terms used by all elements of the ontology.
 *
 *	@package	MyWrapper
 *	@subpackage	Definitions
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 15/10/2012
 */

/*=======================================================================================
 *	IDENTIFICATION ATTRIBUTES															*
 *======================================================================================*/

/**
 * Native unique identifier.
 *
 * This tag identifies the attribute that contains the native unique identifier.
 * This value is a full or hashed representation of the object's global unique identifier
 * ({@link kOFFSET_GID}) optimised specifically for the container in which the object will
 * be stored.
 */
define( "kOFFSET_NID",							'_id' );

/**
 * Local unique identifier.
 *
 * This tag identifies the attribute that contains the local or full unique identifier.
 * This value represents the identifier that uniquely identifies an object within a specific
 * domain or namespace. It is by default a string constituting a portion of the global
 * unique identifier, {@link kOFFSET_GID}.
 */
define( "kOFFSET_LID",							':LID' );

/**
 * Global unique identifier.
 *
 * This tag identifies the attribute that contains the global or full unique identifier.
 * This value will constitute the object's native key ({@link kOFFSET_NID}) in full or
 * hashed format.
 */
define( "kOFFSET_GID",							':GID' );

/**
 * Unique identifier.
 *
 * This tag represents the hashed unique identifier of an object in which its
 * {@link kOFFSET_NID} is not related to the {@link kOFFSET_GID}. This is generally used
 * when the {@link kOFFSET_NID} is a sequence number.
 */
define( "kOFFSET_UID",							':UID' );

/*=======================================================================================
 *	QUALIFICATION ATTRIBUTES															*
 *======================================================================================*/

/**
 * Class name.
 *
 * This tag identifies the class name of the object, it can be used to instantiate a class
 * rather than return an array when querying containers.
 */
define( "kOFFSET_CLASS",						':CLS' );

/**
 * Object kind.
 *
 * This tag identifies the object kind or type, the offset is a set of enumerations that
 * define the kind or specific type of an object, these enumerations will be in the form of
 * native unique identifiers, {@link kOFFSET_NID}, of the terms that define the enumeration.
 */
define( "kOFFSET_KIND",							':KIND' );

/**
 * Object data type.
 *
 * This tag identifies the object data type, the offset is an enumerated scalar that defines
 * the specific data type of an object, this value will be in the form of the native unique
 * identifier, {@link kOFFSET_NID}, of the term that defines the enumeration.
 */
define( "kOFFSET_TYPE",							':TYPE' );

/*=======================================================================================
 *	GENERIC ATTRIBUTES																	*
 *======================================================================================*/

/**
 * Label.
 *
 * This tag is used as the offset for an object's label, name or short description.
 */
define( "kOFFSET_LABEL",						':LABEL' );

/**
 * Description.
 *
 * This tag is used as the offset for an object's description or definition.
 */
define( "kOFFSET_DESCRIPTION",					':DESCR' );

/*=======================================================================================
 *	ONTOLOGY ATTRIBUTES																	*
 *======================================================================================*/

/**
 * Namespace.
 *
 * This tag is used as the offset for a namespace. By default this attribute contains the
 * native unique identifier, {@link kOFFSET_NID}, of the namespace object; if you want to
 * refer to the namespace code, this is not the offset to use.
 */
define( "kOFFSET_NAMESPACE",					':NS' );

/**
 * Term.
 *
 * This tag identifies a reference to a term object, its value will be the native unique
 * identifier, {@link kOFFSET_NID}, of the referenced term.
 */
define( "kOFFSET_TERM",							':TERM' );

/**
 * Subject reference.
 *
 * This tag identifies the reference to the subject vertex of a subject/predicate/object
 * triplet in a graph.
 */
define( "kOFFSET_VERTEX_SUBJECT",				':SUBJECT' );

/**
 * Object reference.
 *
 * This tag identifies the reference to the object vertex of a subject/predicate/object
 * triplet in a graph.
 */
define( "kOFFSET_VERTEX_OBJECT",				':OBJECT' );

/**
 * Predicate reference.
 *
 * This tag identifies the reference to the predicate object of a subject/predicate/object
 * triplet in a graph.
 */
define( "kOFFSET_PREDICATE",					':PREDICATE' );

/**
 * Synonyms.
 *
 * This tag identifies the synonyms offset, this attribute is a list of strings that
 * represent alternate codes or names that identify the specific term.
 */
define( "kOFFSET_SYNONYMS",						':SYN' );

/**
 * Vertex terms.
 *
 * This tag identifies the offset that will contain the list of identifiers of the terms
 * referenced by the tag path's vertex elements.
 */
define( "kOFFSET_VERTEX_TERMS",					':VERTEX-TERMS' );

/**
 * Tag path.
 *
 * This tag identifies a list of items constituting the path or sequence of a tag.
 */
define( "kOFFSET_TAG_PATH",						':TAG-PATH' );

/**
 * Namespace references.
 *
 * This tag identifies namespace references, the attribute contains the count of how many
 * times the term was referenced as a namespace.
 */
define( "kOFFSET_REFS_NAMESPACE",				':REF-NS' );

/**
 * Node references.
 *
 * This tag identifies node references, the attribute contains the list of identifiers of
 * nodes that reference the current object.
 */
define( "kOFFSET_REFS_NODE",					':REF-NODE' );

/**
 * Tag references.
 *
 * This tag identifies tag references, the attribute contains the list of identifiers of
 * tags that reference the current term.
 */
define( "kOFFSET_REFS_TAG",						':REF-TAG' );

/**
 * Edge references.
 *
 * This tag identifies edge references, the attribute contains the list of identifiers of
 * edges that reference the current node.
 */
define( "kOFFSET_REFS_EDGE",					':REF-EDGE' );

/*=======================================================================================
 *	STRUCTURED DATA TYPE OFFSETS														*
 *======================================================================================*/

/**
 * Language code.
 *
 * This tag is generally used as a sub-offset containing a language character code that
 * identifies the language in which the {@link kOFFSET_STRING} attribute is expressed in.
 */
define( "kOFFSET_LANGUAGE",						':SUB-LANGUAGE' );

/**
 * String.
 *
 * This tag is used as a sub-offset containing a string, which generally is expressed in the
 * {@link kOFFSET_LANGUAGE} language.
 */
define( "kOFFSET_STRING",						':SUB-STRING' );


?>
