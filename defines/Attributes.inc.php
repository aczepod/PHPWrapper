<?php

/*=======================================================================================
 *																						*
 *										Tags.inc.php									*
 *																						*
 *======================================================================================*/
 
/**
 * Default tags.
 *
 * This file contains the tag definitions for all default attributes, these tags represent
 * the attribute keys for all the default object properties.
 *
 * <ul>
 *	<li><i>Identification tags</i>: These definitions tag the identification attributes:
 *	 <ul>
 *		<li><tt>{@link kTAG_NID}</tt>: <i>Native identifier</i>. This attribute contains the
 *			native unique identifier of the object. This identifier is used as the default
 *			unique key for all objects and can have any scalar data type. 
 *		<li><tt>{@link kTERM_LID}</tt>: <i>Local identifier</i>. This attribute contains the
 *			local unique identifier. This value represents the value that uniquely
 *			identifies an object within a specific domain or namespace. It is by definition
 *			a string constituting the suffix of the global identifier, {@link kTERM_GID}. 
 *		<li><tt>{@link kTERM_GID}</tt>: <i>Global identifier</i>. This attribute contains
 *			the global unique identifier. This value represents the value that uniquely
 *			identifies the object across domains and namespaces. This value is by definition
 *			a string and will generally constitute the object's primary key
 *			({@link kTERM_NID}) in full or hashed form. 
 *		<li><tt>{@link kTERM_UID}</tt>: <i>Unique identifier</i>. This attribute contains
 *			the hashed unique identifier of an object in which its {@link kTERM_NID} is not
 *			related to the {@link kTERM_GID}. This is generally used when the
 *			{@link kTERM_NID} is a sequence number.
 *		<li><tt>{@link kTERM_SYNONYMS}</tt>: <i>Synonyms</i>. This attribute contains a list
 *			of strings that represent alternate identifiers for the hosting object.
 *			Synonyms do not have any relation to the namespace.
 *	 </ul>
 *	<li><i>Classification attributes</i>: These attributes are used to classify objects:
 *	 <ul>
 *		<li><tt>{@link kTERM_CATEGORY}</tt>: <i>Category</i>. This attribute is an
 *			enumerated set that contains all the categories to which the hosting object
 *			belongs to. 
 *		<li><tt>{@link kTERM_KIND}</tt>: <i>Kind</i>. This attribute is an enumerated set
 *			that defines the kind of the hosting object. 
 *		<li><tt>{@link kTERM_TYPE}</tt>: <i>Type</i>. This attribute is an enumerated set
 *			that contains a combination of data type and cardinality indicators which,
 *			combined, represet the data type of the hosting object.
 *		<li><tt>{@link kTERM_CLASS}</tt>: <i>Class</i>. This attribute is a string that
 *			represets the referenced object's class. This attribute is used to instantiate
 *			the correct class once an object has been retrieved from its container.
 *		<li><tt>{@link kTERM_NAMESPACE}</tt>: <i>Namespace</i>. This attribute is a
 *			reference to a term which represents the namespace of the current object. The
 *			object local identifiers must be unique within the scope of the namespace.
 *	 </ul>
 *	<li><i>Description attributes</i>: These attributes are used to describe objects:
 *	 <ul>
 *		<li><tt>{@link kTERM_LABEL}</tt>: <i>Label</i>. This attribute represents the label,
 *			name or short description of the referenced object. It is a
 *			{@link kTYPE_LSTRING} structure in which the label can be expressed in several
 *			languages. 
 *		<li><tt>{@link kTERM_DESCRIPTION}</tt>: <i>Description</i>. This attribute
 *			represents the description or definition of the referenced object. It is a
 *			{@link kTYPE_LSTRING} structure in which the description can be expressed in
 *			several languages. 
 *		<li><tt>{@link kTERM_NOTES}</tt>: <i>Notes</i>. This attribute represents the notes
 *			or comments of the referenced object. It is a {@link kTYPE_LSTRING} structure in
 *			which the description can be expressed in several languages. 
 *		<li><tt>{@link kTERM_EXAMPLES}</tt>: <i>Examples</i>. This attribute represents the
 *			examples or templates of the referenced object. It is a list of strings where
 *			each string represents an example or template. 
 *	 </ul>
 *	<li><i>Status attributes</i>: These attributes are used to describe a status:
 *	 <ul>
 *		<li><tt>{@link kTERM_SEVERITY}</tt>: <i>Severity</i>. This attribute represents the
 *			severity or status level, it is an element of the following enumerated set:
 *		 <ul>
 *			<li><tt>{@link kSTATUS_IDLE}</tt>: This code indicates no errors, this state can
 *				be equated to an idle state.
 *			<li><tt>{@link kSTATUS_NOTICE}</tt>: This code indicates a notice. A notice is
 *				an informative message that does not imply an error, nor a situation that
 *				should be handled; it can be considered as statistical data.
 *			<li><tt>{@link kSTATUS_MESSAGE}</tt>: This code indicates a message. A message
 *				is an informative message that is addressed to somebody, although it does
 *				not imply an error or warning, it was issued to a receiving party.
 *			<li><tt>{@link kSTATUS_WARNING}</tt>: This code indicates a warning. Warnings
 *				are informative data that indicate a potential problem, although they do not
 *				imply an error, they indicate a potential problem or an issue that should be
 *				addressed, at least at a later stage.
 *			<li><tt>{@link kSTATUS_ERROR}</tt>: This code indicates an error. Errors
 *				indicate that something prevented an operation from being performed, this
 *				does not necessarily mean that the whole process is halted, but that the
 *				results of an operation will not be as expected.
 *			<li><tt>{@link kSTATUS_FATAL}</tt>: This code indicates a fatal error. Fatal
 *				errors are errors that result in stopping the whole process: in this case
 *				the error will prevent other operations from being performed and the whole
 *				process should be halted.
 *			<li><tt>{@link kSTATUS_BUG}</tt>: This code indicates a bug. Bugs, as opposed to
 *				errors, result from internal causes independant from external factors. A bug
 *				indicates that an operation will never execute as stated, it does not
 *				necessarily mean that it is fatal, but rather that the behaviour of an
 *				operation does not correspond to its declaration.
 *		 </ul>
 *		<li><tt>{@link kTERM_CODE}</tt>: <i>Code</i>. This attribute represents the status
 *			code, it is a string or number that identifies the specific status or state.
 *		<li><tt>{@link kTERM_MESSAGE}</tt>: <i>Message</i>. This attribute represents the
 *			status message, it is a string that describes the status. It is a
 *			{@link kTYPE_LSTRING} structure in which the message can be expressed in several
 *			languages.
 *	 </ul>
 *	<li><i>Authorship attributes</i>: These attributes are used to describe authorship:
 *	 <ul>
 *		<li><tt>{@link kTERM_AUTHORS}</tt>: <i>Authors</i>. This attribute represents a list
 *			of authors, it is an array of author names.
 *		<li><tt>{@link kTERM_ACKNOWLEDGMENTS}</tt>: <i>Acknowledgments</i>. This attribute
 *			represents a list of generic acknowledgments, it is an array of strings.
 *		<li><tt>{@link kTERM_BIBLIOGRAPHY}</tt>: <i>Bibliography</i>. This attribute
 *			represents a list of bibliographic references, it is an array of strings.
 *	 </ul>
 *	<li><i>Reference attributes</i>: These attributes are used to reference other objects
 *		and contain the native identifier of the referenced object:
 *	 <ul>
 *		<li><tt>{@link kTERM_TERM}</tt>: <i>Term</i>. This attribute contains a reference to
 *			an object that represents the term of the attribute host.
 *		<li><tt>{@link kTERM_NODE}</tt>: <i>Node</i>. This attribute contains a reference to
 *			an object that represents the node of the attribute host.
 *		<li><tt>{@link kTERM_SUBJECT}</tt>: <i>Subject</i>. This attribute contains a
 *			reference to an object that represents the start, origin or subject vertex of a
 *			<tt>subject</tt>/<tt>predicate</tt>/<tt>object</tt> relationship.
 *		<li><tt>{@link kTERM_OBJECT}</tt>: <i>Object</i>. This attribute contains a
 *			reference to an object that represents the end, destination or object vertex of
 *			a <tt>subject</tt>/<tt>predicate</tt>/<tt>object</tt> relationship.
 *		<li><tt>{@link kTERM_PREDICATE}</tt>: <i>Predicate</i>. This attribute contains a
 *			reference to an object that represents the predicate term of a
 *			<tt>subject</tt>/<tt>predicate</tt>/<tt>object</tt> relationship.
 *		<li><tt>{@link kTERM_PATH}</tt>: <i>Path</i>. This attribute represents a sequence
 *			of <tt>vertex</tt>, <tt>predicate</tt>, <tt>vertex</tt> elements whose
 *			concatenation represents a path between an origin vertex and a destination
 *			vertex.
 *	 </ul>
 *	<li><i>Reference collections</i>: These attributes are used as collections of references
 *		to other objects and contain a list whose elements are the native identifier of the
 *		referenced object:
 *	 <ul>
 *		<li><tt>{@link kTERM_NAMESPACE_REFS}</tt>: <i>Namespace references count</i>. This
 *			integer attribute counts how many times external objects have referenced the
 *			current one as a namespace.
 *		<li><tt>{@link kTERM_NODES}</tt>: <i>Nodes</i>. This attribute is a collection of
 *			node references, it is an array of node object native identifiers who reference
 *			the current object.
 *		<li><tt>{@link kTERM_EDGES}</tt>: <i>Edges</i>. This attribute is a collection of
 *			edge references, it is an array of edge object native identifiers who reference
 *			the current object.
 *		<li><tt>{@link kTERM_FEATURES}</tt>: <i>Features</i>. This attribute is a collection
 *			of feature references, it is an array of object native identifiers that
 *			reference the current object as a feature or trait.
 *		<li><tt>{@link kTERM_METHODS}</tt>: <i>Methods</i>. This attribute is a collection
 *			of method references, it is an array of object native identifiers that
 *			reference the current object as a method or modifier.
 *		<li><tt>{@link kTERM_SCALES}</tt>: <i>Scales</i>. This attribute is a collection
 *			of scale references, it is an array of object native identifiers that
 *			reference the current object as a scale or unit.
 *	 </ul>
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Definitions
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 25/11/2012
 */

/*=======================================================================================
 *	IDENTIFICATION ATTRIBUTES															*
 *======================================================================================*/

/**
 * LID.
 *
 * Local identifier.
 *
 * This attribute contains the local unique identifier. This value represents the value that
 * uniquely identifies an object within a specific domain or namespace. It is by definition
 * a string constituting the suffix of the global identifier, {@link kTERM_GID}.
 *
 * Version 1: (kTAG_LID)[1]
 */
define( "kTERM_LID",							':LID' );

/**
 * GID.
 *
 * Global identifier.
 *
 * This attribute contains the global unique identifier. This value represents the value
 * that uniquely identifies the object across domains and namespaces. This value is by
 * definition a string and will generally constitute the object's primary key
 * ({@link kTERM_NID}) in full or hashed form.
 *
 * Version 1: (kOFFSET_GID)[:GID]
 */
define( "kTERM_GID",							':GID' );

/**
 * UID.
 *
 * Unique identifier.
 *
 * This attribute contains the hashed unique identifier of an object in which its
 * {@link kTERM_NID} is not related to the {@link kTERM_GID}. This is generally used when
 * the {@link kTERM_NID} is a sequence number.
 *
 * Version 1: (kOFFSET_UID)[:UID]
 */
define( "kTERM_UID",							':UID' );

/**
 * SYNONYMS.
 *
 * Synonyms.
 *
 * This attribute contains a list of strings that represent alternate identifiers for the
 * hosting object. Synonyms do not have any relation to the namespace.
 *
 * Version 1: (kOFFSET_SYNONYMS)[:SYN]
 */
define( "kTERM_SYNONYMS",						':SYNONYMS' );

/*=======================================================================================
 *	CLASSIFICATION ATTRIBUTES															*
 *======================================================================================*/

/**
 * CATEGORY.
 *
 * Category.
 *
 * This attribute is an enumerated set that contains all the categories to which the hosting
 * object belongs to.
 *
 * Version 1: (kOFFSET_CATEGORY)[:CATEGORY]
 */
define( "kTERM_CATEGORY",						':CATEGORY' );

/**
 * KIND.
 *
 * Kind.
 *
 * This attribute is an enumerated set that defines the kind of the hosting object.
 *
 * Version 1: (kOFFSET_KIND)[:KIND]
 */
define( "kTERM_KIND",							':KIND' );

/**
 * TYPE.
 *
 * Type.
 *
 * This attribute is an enumerated set that contains a combination of data type and
 * cardinality indicators which, combined, represet the data type of the hosting object.
 *
 * Version 1: (kOFFSET_TYPE)[:TYPE]
 */
define( "kTERM_TYPE",							':TYPE' );

/**
 * CLASS.
 *
 * Class.
 *
 * This attribute is a string that represets the referenced object's class. This attribute
 * is used to instantiate the correct class once an object has been retrieved from its
 * container.
 *
 * Version 1: (kOFFSET_CLASS)[:CLS]
 */
define( "kTERM_CLASS",							':CLASS' );

/**
 * NAMESPACE.
 *
 * Namespace.
 *
 * This attribute is a reference to a term which represents the namespace of the current
 * object. The object local identifiers must be unique within the scope of the namespace.
 *
 * Version 1: (kOFFSET_NAMESPACE)[:NS]
 */
define( "kTERM_NAMESPACE",						':NAMESPACE' );

/*=======================================================================================
 *	DESCRIPTION ATTRIBUTES																*
 *======================================================================================*/

/**
 * LABEL.
 *
 * Label.
 *
 * This attribute represents the label, name or short description of the referenced object.
 * It is a {@link kTYPE_LSTRING} structure in which the label can be expressed in several
 * languages.
 *
 * Version 1: (kOFFSET_LABEL)[:LABEL]
 */
define( "kTERM_LABEL",							':LABEL' );

/**
 * DESCRIPTION.
 *
 * Description.
 *
 * This attribute represents the description or definition of the referenced object.
 * It is a {@link kTYPE_LSTRING} structure in which the description can be expressed in
 * several languages.
 *
 * Version 1: (kOFFSET_DESCRIPTION)[:DESCR]
 */
define( "kTERM_DESCRIPTION",					':DESCRIPTION' );

/**
 * NOTES.
 *
 * Notes.
 *
 * This attribute represents the notes or comments of the referenced object.
 * It is a {@link kTYPE_LSTRING} structure in which the description can be expressed in
 * several languages.
 *
 * Version 1: (kOFFSET_NOTES)[:NOTES]
 */
define( "kTERM_NOTES",							':NOTES' );

/**
 * EXAMPLES.
 *
 * Examples.
 *
 * This attribute represents the examples or templates of the referenced object.
 * It is a list of strings where each string represents an example or template.
 *
 * Version 1: (kOFFSET_EXAMPLES)[:EXAMPLES]
 */
define( "kTERM_EXAMPLES",						':EXAMPLES' );

/*=======================================================================================
 *	STATUS ATTRIBUTES																	*
 *======================================================================================*/

/**
 * SEVERITY.
 *
 * Severity.
 *
 * This attribute represents the severity or status level, it is an element of the following
 * enumerated set:
 *
 * <ul>
 *	<li><tt>{@link kSTATUS_IDLE}</tt>: This code indicates no errors, this state can be
 *		equated to an idle state.
 *	<li><tt>{@link kSTATUS_NOTICE}</tt>: This code indicates a notice. A notice is an
 *		informative message that does not imply an error, nor a situation that should be
 *		handled; it can be considered as statistical data.
 *	<li><tt>{@link kSTATUS_MESSAGE}</tt>: This code indicates a message. A message is an
 *		informative message that is addressed to somebody, although it does not imply an
 *		error or warning, it was issued to a receiving party.
 *	<li><tt>{@link kSTATUS_WARNING}</tt>: This code indicates a warning. Warnings are
 *		informative data that indicate a potential problem, although they do not imply an
 *		error, they indicate a potential problem or an issue that should be addressed at
 *		least at a later stage.
 *	<li><tt>{@link kSTATUS_ERROR}</tt>: This code indicates an error. Errors indicate that
 *		something prevented an operation from being performed, this does not necessarily
 *		mean that the whole process is halted, but that the results of an operation will not
 *		be as expected.
 *	<li><tt>{@link kSTATUS_FATAL}</tt>: This code indicates a fatal error. Fatal errors are
 *		errors that result in stopping the whole process: in this case the error will
 *		prevent other operations from being performed and the whole process should be
 *		halted.
 *	<li><tt>{@link kSTATUS_BUG}</tt>: This code indicates a bug. Bugs, as opposed to errors,
 *		result from internal causes independant from external factors. A bug indicates that
 *		an operation will never execute as stated, it does not necessarily mean that it is
 *		fatal, but rather that the behaviour of an operation does not correspond to its
 *		declaration.
 * </ul>
 *
 * Version 1: (kOFFSET_SEVERITY)[:SEVERITY]
 */
define( "kTERM_SEVERITY",						':SEVERITY' );

/**
 * CODE.
 *
 * Code.
 *
 * This attribute represents the status code, it is a string or number that identifies the
 * specific status or state.
 *
 * Version 1: (kOFFSET_CODE)[:CODE]
 */
define( "kTERM_CODE",							':CODE' );

/**
 * MESSAGE.
 *
 * Message.
 *
 * This attribute represents the status message, it is a string that describes the status.
 * It is a {@link kTYPE_LSTRING} structure in which the message can be expressed in
 * several languages.
 *
 * Version 1: (kOFFSET_MESSAGE)[:MESSAGE]
 */
define( "kTERM_MESSAGE",						':MESSAGE' );

/*=======================================================================================
 *	AUTHORSHIP ATTRIBUTES																*
 *======================================================================================*/

/**
 * AUTHORS.
 *
 * Authors.
 *
 * This attribute represents a list of authors, it is an array of author names.
 *
 * Version 1: (kOFFSET_AUTHORS)[:AUTHORS]
 */
define( "kTERM_AUTHORS",						':AUTHORS' );

/**
 * ACKNOWLEDGMENTS.
 *
 * Acknowledgments.
 *
 * This attribute represents a list of generic acknowledgments, it is an array of strings.
 *
 * Version 1: (kOFFSET_ACKNOWLEDGMENTS)[:ACKNOWLEDGMENTS]
 */
define( "kTERM_ACKNOWLEDGMENTS",				':ACKNOWLEDGMENTS' );

/**
 * BIBLIOGRAPHY.
 *
 * Bibliography.
 *
 * This attribute represents a list of bibliographic references, it is an array of strings.
 *
 * Version 1: (kOFFSET_BIBLIOGRAPHY)[:BIBLIOGRAPHY]
 */
define( "kTERM_BIBLIOGRAPHY",					':BIBLIOGRAPHY' );

/*=======================================================================================
 *	REFERENCE ATTRIBUTES																*
 *======================================================================================*/

/**
 * TERM.
 *
 * Term.
 *
 * This attribute contains a reference to an object that represents the term of the
 * attribute host.
 *
 * Version 1: (kOFFSET_TERM)[:TERM]
 */
define( "kTERM_TERM",							':TERM' );

/**
 * NODE.
 *
 * Node.
 *
 * This attribute contains a reference to an object that represents the master node of the
 * attribute host.
 *
 * Version 1: (kOFFSET_NODE)[:NODE]
 */
define( "kTERM_NODE",							':NODE' );

/**
 * SUBJECT.
 *
 * Subject.
 *
 * This attribute contains a reference to an object that represents the start, origin or
 * subject vertex of a <tt>subject</tt>/<tt>predicate</tt>/<tt>object</tt> relationship.
 *
 * Version 1: (kOFFSET_VERTEX_SUBJECT)[:SUBJECT]
 */
define( "kTERM_SUBJECT",						':SUBJECT' );

/**
 * OBJECT.
 *
 * Object.
 *
 * This attribute contains a reference to an object that represents the end, destination or
 * object vertex of a <tt>subject</tt>/<tt>predicate</tt>/<tt>object</tt> relationship.
 *
 * Version 1: (kOFFSET_VERTEX_OBJECT)[:OBJECT]
 */
define( "kTERM_OBJECT",							':OBJECT' );

/**
 * PREDICATE.
 *
 * Predicate.
 *
 * This attribute contains a reference to an object that represents the predicate term of a
 * <tt>subject</tt>/<tt>predicate</tt>/<tt>object</tt> relationship.
 *
 * Version 1: (kOFFSET_PREDICATE)[:PREDICATE]
 */
define( "kTERM_PREDICATE",						':PREDICATE' );

/**
 * PATH.
 *
 * Path.
 *
 * This attribute represents a sequence of <tt>vertex</tt>, <tt>predicate</tt>,
 * <tt>vertex</tt> elements whose concatenation represents a path between an origin vertex
 * and a destination vertex.
 *
 * Version 1: (kOFFSET_TAG_PATH)[:TAG-PATH]
 */
define( "kTERM_PATH",							':PATH' );

/*=======================================================================================
 *	REFERENCE COLLECTIONS																*
 *======================================================================================*/

/**
 * NAMESPACE-REFS.
 *
 * Namespace references count.
 *
 * This integer attribute counts how many times external objects have referenced the current
 * one as a namespace.
 *
 * Version 1: (kOFFSET_REFS_NAMESPACE)[:REF-NS]
 */
define( "kTERM_NAMESPACE_REFS",					':NAMESPACE-REFS' );

/**
 * NODES.
 *
 * Nodes.
 *
 * This attribute is a collection of node references, it is an array of node object native
 * identifiers who reference the current object.
 *
 * Version 1: (kOFFSET_REFS_NODE)[:REF-NODE]
 */
define( "kTERM_NODES",							':NODES' );

/**
 * EDGES.
 *
 * Edges.
 *
 * This attribute is a collection of edge references, it is an array of edge object native
 * identifiers who reference the current object.
 *
 * Version 1: (kOFFSET_REFS_EDGE)[:REF-EDGE]
 */
define( "kTERM_EDGES",							':EDGES' );

/**
 * FEATURES.
 *
 * Features.
 *
 * This attribute is a collection of feature references, it is an array of object native
 * identifiers that reference the current object as a feature or trait.
 *
 * Version 1: (kOFFSET_REFS_TAG_FEATURE)[:REF-TAG-FEATURE]
 */
define( "kTERM_FEATURES",						':FEATURES' );

/**
 * METHODS.
 *
 * Methods.
 *
 * This attribute is a collection of method references, it is an array of object native
 * identifiers that reference the current object as a method or modifier.
 *
 * Version 1: (kOFFSET_REFS_TAG_METHOD)[:REF-TAG-METHOD]
 */
define( "kTERM_METHODS",						':METHODS' );

/**
 * SCALES.
 *
 * Scales.
 *
 * This attribute is a collection of scale references, it is an array of object native
 * identifiers that reference the current object as a scale or unit.
 *
 * Version 1: (kOFFSET_REFS_TAG_SCALE)[:REF-TAG-SCALE]
 */
define( "kTERM_SCALES",							':SCALES' );


?>
