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
var kTAG_LID							= '1';

/**
 * Global unique identifier.
 *
 * This tag identifies the attribute that contains the global or full unique identifier.
 * This value will constitute the object's native key ({@link kTAG_NID}) in full or
 * hashed format.
 */
var kTAG_GID							= '2';

/**
 * Unique identifier.
 *
 * This tag represents the hashed unique identifier of an object in which its
 * {@link kTAG_NID} is not related to the {@link kTAG_GID}. This is generally used
 * when the {@link kTAG_NID} is a sequence number.
 */
var kTAG_UID							= '21';

/*=======================================================================================
 *	QUALIFICATION ATTRIBUTES															*
 *======================================================================================*/

/**
 * Class name.
 *
 * This tag identifies the class name of the object, it can be used to instantiate a class
 * rather than return an array when querying containers.
 */
var kTAG_CLASS							= '4';

/**
 * Object category.
 *
 * This tag identifies the object category or classification, the offset is a set of
 * enumerations that define the category or classification to which the object belongs to.
 */
var kTAG_CATEGORY						= '12';

/**
 * Object kind.
 *
 * This tag identifies the object kind or type, the offset is a set of enumerations that
 * define the kind or specific type of an object, these enumerations will be in the form of
 * native unique identifiers, {@link kTAG_NID}, of the terms that define the enumeration.
 */
var kTAG_KIND							= '13';

/**
 * Object data type.
 *
 * This tag identifies the object data type, the offset is an enumerated scalar that defines
 * the specific data type of an object, this value will be in the form of the native unique
 * identifier, {@link kTAG_NID}, of the term that defines the enumeration.
 */
var kTAG_TYPE							= '14';

/*=======================================================================================
 *	ONTOLOGY ATTRIBUTES																	*
 *======================================================================================*/

/**
 * Namespace.
 *
 * This tag is used as the offset for a namespace. By default this attribute contains the
 * native unique identifier, {@link kTAG_NID}, of the namespace object; if you want to
 * refer to the namespace code, this is not the offset to use.
 */
var kTAG_NAMESPACE						= '3';

/**
 * Term.
 *
 * This tag identifies a reference to a term object, its value will be the native unique
 * identifier, {@link kTAG_NID}, of the referenced term.
 */
var kTAG_TERM							= '8';

/**
 * Subject reference.
 *
 * This tag identifies the reference to the subject vertex of a subject/predicate/object
 * triplet in a graph.
 */
var kTAG_SUBJECT					= '18';

/**
 * Object reference.
 *
 * This tag identifies the reference to the object vertex of a subject/predicate/object
 * triplet in a graph.
 */
var kTAG_OBJECT					= '20';

/**
 * Predicate reference.
 *
 * This tag identifies the reference to the predicate object of a subject/predicate/object
 * triplet in a graph.
 */
var kTAG_PREDICATE						= '19';

/**
 * Synonyms.
 *
 * This tag identifies the synonyms offset, this attribute is a list of strings that
 * represent alternate codes or names that identify the specific term.
 */
var kTAG_SYNONYMS						= '7';

/*=======================================================================================
 *	REFERENCE ATTRIBUTES																*
 *======================================================================================*/

/**
 * Tag path.
 *
 * This tag identifies a list of items constituting the path or sequence of a tag.
 */
var kTAG_PATH						= '22';

/**
 * Namespace references.
 *
 * This tag identifies namespace references, the attribute contains the count of how many
 * times the term was referenced as a namespace.
 */
var kTAG_NAMESPACE_REFS					= '9';

/**
 * Node references.
 *
 * This tag identifies node references, the attribute contains the list of identifiers of
 * nodes that reference the current object.
 */
var kTAG_NODES						= '10';

/**
 * Tag references.
 *
 * This tag identifies tag references, the attribute contains the list of identifiers of
 * tags that reference the current term.
 */
var kTAG_REFS_TAG						= '11';

/**
 * Feature tag references.
 *
 * This tag identifies feature tag references, the attribute contains the list of
 * identifiers of tags that reference the current node as a feature.
 */
var kTAG_FEATURES				= '15';

/**
 * Scale tag references.
 *
 * This tag identifies scale tag references, the attribute contains the list of identifiers
 * of tags that reference the current node as a scale.
 */
var kTAG_SCALES					= '16';

/**
 * Edge references.
 *
 * This tag identifies edge references, the attribute contains the list of identifiers of
 * edges that reference the current node.
 */
var kTAG_EDGES						= '17';

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
var kTAG_LABEL							= '5';

/**
 * Description.
 *
 * This tag is used as the offset for the term's description, this attribute represents the
 * term description or definition structure that is an array of elements in which the index
 * represents the language code of the string that is stored as the element value.
 */
var kTAG_DESCRIPTION					= '6';

/**
 * Authors.
 *
 * This tag is used as the offset for a list of authors.
 */
var kTAG_AUTHORS						= '24';

/**
 * Notes.
 *
 * This tag is used as the offset for generic notes.
 */
var kTAG_NOTES							= '25';

/**
 * Acknowledgments.
 *
 * This tag is used as the offset for generic acknowledgments.
 */
var kTAG_ACKNOWLEDGMENTS				= '26';

/**
 * Bibliography.
 *
 * This tag represents the offset for a bibliography list.
 */
var kTAG_BIBLIOGRAPHY					= '27';

/**
 * Examples.
 *
 * This tag represents the offset for a list of examples or templates.
 */
var kTAG_EXAMPLES						= '28';
