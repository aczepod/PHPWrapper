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
 * unique identifier, {@link kOFFSET_GID}.
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
 * {@link kOFFSET_NID} is not related to the {@link kOFFSET_GID}. This is generally used
 * when the {@link kOFFSET_NID} is a sequence number.
 */
define( "kTAG_UID",								'22' );

/*=======================================================================================
 *	QUALIFICATION ATTRIBUTES															*
 *======================================================================================*/

/**
 * Class name.
 *
 * This tag identifies the class name of the object, it can be used to instantiate a class
 * rather than return an array when querying containers.
 */
define( "kTAG_CLASS",							'3' );

/**
 * Object kind.
 *
 * This tag identifies the object kind or type, the offset is a set of enumerations that
 * define the kind or specific type of an object, these enumerations will be in the form of
 * native unique identifiers, {@link kOFFSET_NID}, of the terms that define the enumeration.
 */
define( "kTAG_KIND",							'16' );

/**
 * Object data type.
 *
 * This tag identifies the object data type, the offset is an enumerated scalar that defines
 * the specific data type of an object, this value will be in the form of the native unique
 * identifier, {@link kOFFSET_NID}, of the term that defines the enumeration.
 */
define( "kTAG_TYPE",							'17' );

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
define( "kTAG_NAMESPACE",						'10' );

/**
 * Term.
 *
 * This tag identifies a reference to a term object, its value will be the native unique
 * identifier, {@link kOFFSET_NID}, of the referenced term.
 */
define( "kTAG_TERM",							'12' );

/**
 * Subject reference.
 *
 * This tag identifies the reference to the subject vertex of a subject/predicate/object
 * triplet in a graph.
 */
define( "kTAG_VERTEX_SUBJECT",					'19' );

/**
 * Object reference.
 *
 * This tag identifies the reference to the object vertex of a subject/predicate/object
 * triplet in a graph.
 */
define( "kTAG_VERTEX_OBJECT",					'21' );

/**
 * Predicate reference.
 *
 * This tag identifies the reference to the predicate object of a subject/predicate/object
 * triplet in a graph.
 */
define( "kTAG_PREDICATE",						'20' );

/**
 * Synonyms.
 *
 * This tag identifies the synonyms offset, this attribute is a list of strings that
 * represent alternate codes or names that identify the specific term.
 */
define( "kTAG_SYNONYMS",						'11' );

/**
 * Vertex terms.
 *
 * This tag identifies the offset that will contain the list of identifiers of the terms
 * referenced by the tag path's vertex elements.
 */
define( "kTAG_VERTEX_TERMS",					'24' );

/**
 * Tag path.
 *
 * This tag identifies a list of items constituting the path or sequence of a tag.
 */
define( "kTAG_TAG_PATH",						'23' );

/**
 * Namespace references.
 *
 * This tag identifies namespace references, the attribute contains the count of how many
 * times the term was referenced as a namespace.
 */
define( "kTAG_REFS_NAMESPACE",					'13' );

/**
 * Node references.
 *
 * This tag identifies node references, the attribute contains the list of identifiers of
 * nodes that reference the current object.
 */
define( "kTAG_REFS_NODE",						'14' );

/**
 * Tag references.
 *
 * This tag identifies tag references, the attribute contains the list of identifiers of
 * tags that reference the current term.
 */
define( "kTAG_REFS_TAG",						'15' );

/**
 * Edge references.
 *
 * This tag identifies edge references, the attribute contains the list of identifiers of
 * edges that reference the current node.
 */
define( "kTAG_REFS_EDGE",						'18' );

/*=======================================================================================
 *	STRUCTURED ATTRIBUTES																*
 *======================================================================================*/

/**
 * Label.
 *
 * This tag is used as the offset for the term's label, this attribute represents the term
 * name or short description structure.
 */
define( "kTAG_LABEL",							'4' );

/**
 * Label language code.
 *
 * This tag is used as a sub-offset of {@link kTAG_LABEL} element, it represents the
 * language code of the {@link kTAG_LABEL_DATA} string element.
 */
define( "kTAG_LABEL_LANGUAGE",					'5' );

/**
 * Label data.
 *
 * This tag represents the string item in the {@link kTAG_LABEL} elements.
 */
define( "kTAG_LABEL_DATA",						'6' );

/**
 * Description.
 *
 * This tag is used as the offset for the term's description, this attribute represents the
 * term description or definition structure.
 */
define( "kTAG_DESCRIPTION",						'7' );

/**
 * Description language code.
 *
 * This tag is used as a sub-offset of {@link kTAG_DESCRIPTION} element, it represents the
 * language code of the {@link kTAG_DESCRIPTION_DATA} string element.
 */
define( "kTAG_DESCRIPTION_LANGUAGE",			'8' );

/**
 * Description data.
 *
 * This tag represents the string item in the {@link kTAG_DESCRIPTION} elements.
 */
define( "kTAG_DESCRIPTION_DATA",				'9' );


?>
