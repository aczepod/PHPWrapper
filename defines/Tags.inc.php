<?php

/*=======================================================================================
 *																						*
 *										Tags.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 *	Tags.
 *
 *	This file contains default attribute tags used by the elements of the ontology.
 *
 *	@package	MyWrapper
 *	@subpackage	Definitions
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 22/10/2012
 */

/*=======================================================================================
 *	IDENTIFICATION ATTRIBUTES															*
 *======================================================================================*/

/**
 * Local unique identifier.
 *
 * This tag identifies the attribute that contains the local or full unique identifier.
 * This value represents the identifier that uniquely identifies an object within a specific
 * domain or namespace. It is by default a string constituting a portion of the global
 * unique identifier, {@link kTAG_GID}.
 */
define( "kTAG_LID",								'1' );

/**
 * Global unique identifier.
 *
 * This tag identifies the attribute that contains the global or full unique identifier.
 * This value will constitute the object's native key ({@link kOFFSET_NID}) in full or
 * hashed format.
 */
define( "kTAG_GID",								'2' );

/**
 * Unique identifier.
 *
 * This tag represents the hashed unique identifier of an object in which its
 * {@link kOFFSET_NID} is not related to the {@link kTAG_GID}. This is generally used
 * when the {@link kOFFSET_NID} is a sequence number.
 */
define( "kTAG_UID",								'21' );

/*=======================================================================================
 *	QUALIFICATION ATTRIBUTES															*
 *======================================================================================*/

/**
 * Class name.
 *
 * This tag identifies the class name of the object, it can be used to instantiate a class
 * rather than return an array when querying containers.
 */
define( "kTAG_CLASS",							'4' );

/**
 * Object category.
 *
 * This tag identifies the object category or classification, the offset is a set of
 * enumerations that define the category or classification to which the object belongs to.
 */
define( "kTAG_CATEGORY",						'12' );

/**
 * Object kind.
 *
 * This tag identifies the object kind or type, the offset is a set of enumerations that
 * define the kind or specific type of an object, these enumerations will be in the form of
 * native unique identifiers, {@link kOFFSET_NID}, of the terms that define the enumeration.
 */
define( "kTAG_KIND",							'13' );

/**
 * Object data type.
 *
 * This tag identifies the object data type, the offset is an enumerated scalar that defines
 * the specific data type of an object, this value will be in the form of the native unique
 * identifier, {@link kOFFSET_NID}, of the term that defines the enumeration.
 */
define( "kTAG_TYPE",							'14' );

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
define( "kTAG_NAMESPACE",						'3' );

/**
 * Term.
 *
 * This tag identifies a reference to a term object, its value will be the native unique
 * identifier, {@link kOFFSET_NID}, of the referenced term.
 */
define( "kTAG_TERM",							'8' );

/**
 * Subject reference.
 *
 * This tag identifies the reference to the subject vertex of a subject/predicate/object
 * triplet in a graph.
 */
define( "kTAG_VERTEX_SUBJECT",					'18' );

/**
 * Object reference.
 *
 * This tag identifies the reference to the object vertex of a subject/predicate/object
 * triplet in a graph.
 */
define( "kTAG_VERTEX_OBJECT",					'20' );

/**
 * Predicate reference.
 *
 * This tag identifies the reference to the predicate object of a subject/predicate/object
 * triplet in a graph.
 */
define( "kTAG_PREDICATE",						'19' );

/**
 * Synonyms.
 *
 * This tag identifies the synonyms offset, this attribute is a list of strings that
 * represent alternate codes or names that identify the specific term.
 */
define( "kTAG_SYNONYMS",						'7' );

/*=======================================================================================
 *	REFERENCE ATTRIBUTES																*
 *======================================================================================*/

/**
 * Vertex terms.
 *
 * This tag identifies the offset that will contain the list of identifiers of the terms
 * referenced by the tag path's vertex elements.
 */
define( "kTAG_VERTEX_TERMS",					'23' );

/**
 * Tag path.
 *
 * This tag identifies a list of items constituting the path or sequence of a tag.
 */
define( "kTAG_TAG_PATH",						'22' );

/**
 * Namespace references.
 *
 * This tag identifies namespace references, the attribute contains the count of how many
 * times the term was referenced as a namespace.
 */
define( "kTAG_REFS_NAMESPACE",					'9' );

/**
 * Node references.
 *
 * This tag identifies node references, the attribute contains the list of identifiers of
 * nodes that reference the current object.
 */
define( "kTAG_REFS_NODE",						'10' );

/**
 * Tag references.
 *
 * This tag identifies tag references, the attribute contains the list of identifiers of
 * tags that reference the current term.
 */
define( "kTAG_REFS_TAG",						'11' );

/**
 * Feature tag references.
 *
 * This tag identifies feature tag references, the attribute contains the list of
 * identifiers of tags that reference the current term as a feature.
 */
define( "kTAG_REFS_TAG_FEATURE",				'15' );

/**
 * Method tag references.
 *
 * This tag identifies method tag references, the attribute contains the list of
 * identifiers of tags that reference the current term as a method.
 */
define( "kTAG_REFS_TAG_METHOD",					'??' );

/**
 * Scale tag references.
 *
 * This tag identifies scale tag references, the attribute contains the list of identifiers
 * of tags that reference the current term as a scale.
 */
define( "kTAG_REFS_TAG_SCALE",					'16' );

/**
 * Edge references.
 *
 * This tag identifies edge references, the attribute contains the list of identifiers of
 * edges that reference the current node.
 */
define( "kTAG_REFS_EDGE",						'17' );

/*=======================================================================================
 *	GENERIC ATTRIBUTES																	*
 *======================================================================================*/

/**
 * Label.
 *
 * This tag is used as the offset for the term's label, this attribute represents the term
 * name or short description structure that is an array of elements in which the index
 * represents the language code of the string that is stored as the element value.
 */
define( "kTAG_LABEL",							'5' );

/**
 * Description.
 *
 * This tag is used as the offset for the term's description, this attribute represents the
 * term description or definition structure that is an array of elements in which the index
 * represents the language code of the string that is stored as the element value.
 */
define( "kTAG_DESCRIPTION",						'6' );

/**
 * Authors.
 *
 * This tag is used as the offset for a list of authors.
 */
define( "kTAG_AUTHORS",							'24' );

/**
 * Notes.
 *
 * This tag is used as the offset for generic notes.
 */
define( "kTAG_NOTES",							'25' );

/**
 * Acknowledgments.
 *
 * This tag is used as the offset for generic acknowledgments.
 */
define( "kTAG_ACKNOWLEDGMENTS",					'26' );

/**
 * Bibliography.
 *
 * This tag represents the offset for a bibliography list.
 */
define( "kTAG_BIBLIOGRAPHY",					'27' );

/**
 * Examples.
 *
 * This tag represents the offset for a list of examples or templates.
 */
define( "kTAG_EXAMPLES",						'28' );

/*=======================================================================================
 *	CUSTOM TYPE SUB ATTRIBUTES															*
 *======================================================================================*/

/**
 * Custom data type.
 *
 * This tag is used as the default offset for indicating a custom data type, in general it
 * is used in a structure in conjunction with the {@link kTAG_CUSTOM_DATA} offset to indicate the
 * data type of the item.
 */
define( "kTAG_CUSTOM_TYPE",						'type' );

/**
 * Custom data type data.
 *
 * This tag is used as the default offset for indicating a custom data type content, in
 * general this tag is used in conjunction with the {@link kTAG_CUSTOM_TYPE} to wrap a custom data
 * type in a standard structure.
 */
define( "kTAG_CUSTOM_DATA",						'data' );

/*=======================================================================================
 *	SUB-OBJECT TYPES																	*
 *======================================================================================*/

/**
 * Seconds.
 *
 * This tag defines the number of seconds since January 1st, 1970.
 */
define( "kTYPE_STAMP_SEC",						'sec' );

/**
 * Microseconds.
 *
 * This tag defines microseconds.
 */
define( "kTYPE_STAMP_USEC",						'usec' );


?>
