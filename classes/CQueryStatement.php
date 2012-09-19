<?php

/**
 * <i>CQueryStatement</i> class definition.
 *
 * This file contains the class definition of <b>CQueryStatement</b> which represents a
 * {@link CQuery query} statement object.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 19/09/2012
*/

/*=======================================================================================
 *																						*
 *									CQueryStatement.php									*
 *																						*
 *======================================================================================*/

/**
 * Accessors.
 *
 * This include file contains all accessor function definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_FUNCTION."/accessors.php" );

/**
 * Query object.
 *
 * This include file contains the query object class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CQuery.php" );

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CDocument.php" );

/**
 * <h3>Query statement</h3>
 *
 * This class implements a query statement, such as those that populate the
 * {@link CQuery query} class. This class concentrates on building and managing these
 * statements, which are structured as follows:
 *
 * <ul>
 *	<li><i>{@link kOFFSET_QUERY_SUBJECT}</i>: The query subject. It refers to the object
 *		element that we are considering in the query.
 *	<li><i>{@link kOFFSET_QUERY_OPERATOR}</i>: The query predicate. This element represents
 *		the predicate or comparaison operator, it can take the following values:
 *	 <ul>
 *		<li><i>{@link kOPERATOR_DISABLED}</i>: Disabled, it means that the current statement
 *			is disabled.
 *		<li><i>{@link kOPERATOR_EQUAL}</i>: Equality (<tt>=</tt>), this operator implies
 *			that the statement has also an {@link kOFFSET_QUERY_DATA} object.
 *		<li><i>{@link kOPERATOR_EQUAL_NOT}</i>: Inequality (<tt>!=</tt>), negates the
 *			{@link kOPERATOR_EQUAL} operator; this operator implies that the statement has
 *			also a {@link kOFFSET_QUERY_DATA} object.
 *		<li><i>{@link kOPERATOR_LIKE}</i>: Like, it is an accent and case insensitive
 *			equality filter, this operator implies that the statement has also a
 *			{@link kOFFSET_QUERY_DATA} object.
 *		<li><i>{@link kOPERATOR_LIKE_NOT}</i>: The negation of the {@link kOPERATOR_LIKE}
 *			operator, this operator implies that the statement has also a
 *			{@link kOFFSET_QUERY_DATA} object.
 *		<li><i>{@link kOPERATOR_PREFIX}</i>: Starts with, or prefix match, this operator
 *			implies that the statement has also a {@link kOFFSET_QUERY_DATA} object.
 *		<li><i>{@link kOPERATOR_CONTAINS}</i>: Contains, selects all elements that contain
 *			the match value, this operator implies that the statement has also a
 *			{@link kOFFSET_QUERY_DATA} object.
 *		<li><i>{@link kOPERATOR_SUFFIX}</i>: Ends with, or suffix match, this operator
 *			implies that the statement has also a {@link kOFFSET_QUERY_DATA} object.
 *		<li><i>{@link kOPERATOR_REGEX}</i>: Regular expression, this operator implies that
 *			the statement has also a {@link kOFFSET_QUERY_DATA} object.
 *		<li><i>{@link kOPERATOR_LESS}</i>: Smaller than (<tt><</tt>), this operator implies
 *			that the statement has also a {@link kOFFSET_QUERY_DATA} object.
 *		<li><i>{@link kOPERATOR_LESS_EQUAL}</i>: Smaller than or equal (<tt><=</tt>), this
 *			operator implies that the statement has also a {@link kOFFSET_QUERY_DATA} object.
 *		<li><i>{@link kOPERATOR_GREAT}</i>: Greater than (<tt>></tt>), this operator
 *			implies that the statement has also a {@link kOFFSET_QUERY_DATA} object.
 *		<li><i>{@link kOPERATOR_GREAT_EQUAL}</i>: Greater than or equal (<tt>>=</tt>), this
 *			operator implies that the statement has also a {@link kOFFSET_QUERY_DATA} object.
 *		<li><i>{@link kOPERATOR_IRANGE}</i>: Range inclusive, matches <tt>>= value <=</tt>;
 *			this operator implies that the statement has also a {@link kOFFSET_QUERY_DATA}
 *			object which should contain the two range values.
 *		<li><i>{@link kOPERATOR_ERANGE}</i>: Range exclusive, matches <tt>> value <</tt>,
 *			this operator implies that the statement has also a {@link kOFFSET_QUERY_DATA}
 *			object which should contain the two range values.
 *		<li><i>{@link kOPERATOR_NULL}</i>: Is <tt>NULL</tt> or element is missing.
 *		<li><i>{@link kOPERATOR_NOT_NULL}</i>:Not <tt>NULL</tt> or element exists.
 *		<li><i>{@link kOPERATOR_IN}</i>: In, or belongs to set, this operator implies that
 *			the statement has also a {@link kOFFSET_QUERY_DATA} object that will contain the
 *			list of choices.
 *		<li><i>{@link kOPERATOR_NI}</i>: Not in, the negation of {@link kOPERATOR_IN}, this
 *			operator implies that the statement has also a {@link kOFFSET_QUERY_DATA} object
 *			which contains the list of choices.
 *		<li><i>{@link kOPERATOR_ALL}</i>: All, or match the full set, this operator implies
 *			that the statement has also a {@link kOFFSET_QUERY_DATA} object which will
 *			contain the set.
 *		<li><i>{@link kOPERATOR_NALL}</i>: Not all, the negation of the
 *			{@link kOPERATOR_ALL} operator, this operator implies that the statement has
 *			also a {@link kOFFSET_QUERY_DATA} object which contains the set.
 *		<li><i>{@link kOPERATOR_EX}</i>: Expression, indicates a complex expression, this
 *			operator implies that the statement has also a {@link kOFFSET_QUERY_DATA} object
 *			which will contain the expression.
 *	 </ul>
 *	<li><i>{@link kOFFSET_QUERY_TYPE }</i>: The statement object type, or data type of the
 *		{@link kOFFSET_QUERY_DATA} element, if the latter is required:
 *	 <ul>
 *		<li><i>{@link kTYPE_STRING}</i>: String, we assume in UTF8 character set.
 *		<li><i>{@link kTYPE_INT32}</i>: 32 bit signed integer.
 *		<li><i>{@link kTYPE_INT64}</i>: 64 bit signed integer.
 *		<li><i>{@link kTYPE_FLOAT}</i>: Floating point number.
 *		<li><i>{@link kTYPE_DATE}</i>: A date.
 *		<li><i>{@link kTYPE_TIME}</i>: A date and time.
 *		<li><i>{@link kTYPE_STAMP}</i>: A native timestamp.
 *		<li><i>{@link kTYPE_BOOLEAN}</i>: An <tt>on</tt>/<tt>off</tt> switch.
 *		<li><i>{@link kTYPE_BINARY}</i>: A binary string.
 *		<li><i>{@link kTYPE_ENUM }</i>: An enumerated value.
 *		<li><i>{@link kTYPE_ENUM_SET}</i>: An enumerated set of values.
 *	 </ul>
 *	<li><i>{@link kOFFSET_QUERY_DATA}</i>: The statement object or test data.
 * </ul>
 *
 * The main goal of this class is to provide an interface that may ease the construction of
 * complex {@link CQuery} queries by providing specialised methods for building statements
 * that can then safely be appended, {@link CQuery::AppendStatement()}, to {@link CQuery}
 * objects.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 */
class CQueryStatement extends CDocument
{
		

/*=======================================================================================
 *																						*
 *										MAGIC											*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	__construct																		*
	 *==================================================================================*/

	/**
	 * Instantiate class.
	 *
	 * The constructor can be used to instantiate a statement either by providing an
	 * existing statement structure, or by providing the statement elements:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: The statement subject:
	 *	 <ul>
	 *		<li><tt>array</tt> or <tt>{@link ArrayObject}</tt>: Structures are interpreted
	 *			as built statements, so the method will scan the structure and load the
	 *			corresponding elements.
	 *		<li><tt>string</tt>: Any other type will be converted to a string and
	 *			interpreted as the statement subject, or data element key.
	 *	 </ul>
	 *	<li><tt>$thePredicate</tt>: The statement operator or predicate:
	 *	 <ul>
	 *		<li><i>{@link kOPERATOR_DISABLED}</i>: Disabled, it means that the current
	 *			statement is disabled; the remaining parameters are ignored.
	 *		<li><i>{@link kOPERATOR_EQUAL}</i>: Equality (<tt>=</tt>), this operator implies
	 *			that the method expects the next two parameters.
	 *		<li><i>{@link kOPERATOR_EQUAL_NOT}</i>: Inequality (<tt>!=</tt>), negates the
	 *			{@link kOPERATOR_EQUAL} operator; this operator implies that the method
	 *			expects the next two parameters.
	 *		<li><i>{@link kOPERATOR_LIKE}</i>: Like, it is an accent and case insensitive
	 *			equality filter, this operator implies that the method expects the next two
	 *			parameters.
	 *		<li><i>{@link kOPERATOR_LIKE_NOT}</i>: The negation of the
	 *			{@link kOPERATOR_LIKE} operator, this operator implies that the method
	 *			expects the next two parameters.
	 *		<li><i>{@link kOPERATOR_PREFIX}</i>: Starts with, or prefix match, this operator
	 *			implies that the method expects the next two parameters.
	 *		<li><i>{@link kOPERATOR_CONTAINS}</i>: Contains, selects all elements that
	 *			contain the match string, this operator implies that the method expects the
	 *			next two parameters.
	 *		<li><i>{@link kOPERATOR_SUFFIX}</i>: Ends with, or suffix match, this operator
	 *			implies that the method expects the next two parameters.
	 *		<li><i>{@link kOPERATOR_REGEX}</i>: Regular expression, this operator implies
	 *			that the method expects the next two parameters.
	 *		<li><i>{@link kOPERATOR_LESS}</i>: Smaller than (<tt><</tt>), this operator
	 *			implies that the method expects the next two parameters.
	 *		<li><i>{@link kOPERATOR_LESS_EQUAL}</i>: Smaller than or equal (<tt><=</tt>),
	 *			this operator implies that the method expects the next two parameters.
	 *		<li><i>{@link kOPERATOR_GREAT}</i>: Greater than (<tt>></tt>), this operator
	 *			implies that the method expects the next two parameters.
	 *		<li><i>{@link kOPERATOR_GREAT_EQUAL}</i>: Greater than or equal (<tt>>=</tt>),
	 *			this operator implies that the method expects the next two parameters.
	 *		<li><i>{@link kOPERATOR_IRANGE}</i>: Range inclusive, matches <tt>>= value
	 *			<=</tt>; this operator implies that the method expects the next three
	 *			parameters.
	 *		<li><i>{@link kOPERATOR_ERANGE}</i>: Range exclusive, matches <tt>> value
	 *			<</tt>, this operator implies that the method expects the next three
	 *			parameters.
	 *		<li><i>{@link kOPERATOR_NULL}</i>: Is <i>NULL</i> or element is missing.
	 *		<li><i>{@link kOPERATOR_NOT_NULL}</i>:Not <i>NULL</i> or element exists.
	 *		<li><i>{@link kOPERATOR_IN}</i>: In, or belongs to set, this operator implies
	 *			that the method expects the next two parameters.
	 *		<li><i>{@link kOPERATOR_NI}</i>: Not in, the negation of {@link kOPERATOR_IN},
	 *			this operator implies that the method expects the next two parameters.
	 *		<li><i>{@link kOPERATOR_ALL}</i>: All, or match the full set, this operator
	 *			implies that the method expects the next two parameters.
	 *		<li><i>{@link kOPERATOR_NALL}</i>: Not all, the negation of the
	 *			{@link kOPERATOR_ALL} operator, this operator implies that the method
	 *			expects the next two parameters.
	 *		<li><i>{@link kOPERATOR_EX}</i>: Expression, indicates a complex expression,
	 *			this operator implies that the method expects the next two parameters.
	 *	 </ul>
	 *	<li><tt>$theType</tt>: The statement object data type, this qualifies all remaining
	 *		parameters. The allowed values are:
	 *	 <ul>
	 *		<li><i>{@link kTYPE_STRING}</i>: String, we assume in UTF8 character set, the
	 *			string is expected in the next parameter.
	 *		<li><i>{@link kTYPE_INT32}</i>: 32 bit signed integer, the number is expected in
	 *			the next parameter, either as an integer, float or string; once received, it
	 *			will be converted to an <tt>int</tt>.
	 *		<li><i>{@link kTYPE_INT64}</i>: 64 bit signed integer, the number is expected in
	 *			the next parameter, either as an integer, float or string; once received, it
	 *			will be converted to an <tt>int</tt>.
	 *		<li><i>{@link kTYPE_FLOAT}</i>: Floating point number, the number is expected in
	 *			the next parameter, either as an integer, float or string; once received, it
	 *			will be converted to a <tt>float</tt>.
	 *		<li><i>{@link kTYPE_DATE}</i>: A string date, it is treated as a string date
	 *			with a YYYYMMDD format in which month and day may be omitted.
	 *		<li><i>{@link kTYPE_TIME}</i>: A string time, it is treated as a string time
	 *			with a YYYY-MM-DD HH:MM:SS format in which all elements are required; this
	 *			element will be converted to a {@link kTYPE_STAMP} data type.
	 *		<li><i>{@link kTYPE_STAMP}</i>: A timestamp, optionally including microseconds.
	 *		<li><i>{@link kTYPE_BOOLEAN}</i>: An <tt>on</tt>/<tt>off</tt> switch, it will be
	 *			converted to a <tt>1</tt>/<tt>0</tt> pair.
	 *		<li><i>{@link kTYPE_BINARY}</i>: A binary string.
	 *	 </ul>
	 *	<li><tt>$theObject</tt>: The statement object data, it should reflect the data type
	 *		provided in the previous parameter.
	 *	<li><tt>$theRange</tt>: The statement range end or second element. This value must
	 *		also reflect the data type provided in the previous parameter and will be
	 *		automatically set if you provided a range and forgot to set it.
	 * </ul>
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param string				$thePredicate		Statement predicate.
	 * @param string				$theType			Statement object data type.
	 * @param mixed					$theObject			Statement object or first range.
	 * @param mixed					$theRange			Statement second range.
	 *
	 * @access public
	 *
	 * @uses Subject()
	 * @uses Predicate()
	 * @uses Type()
	 * @uses Range()
	 * @uses Object()
	 */
	public function __construct( $theSubject = NULL,
								 $thePredicate = NULL,
								 $theType = NULL,
								 $theObject = NULL,
								 $theRange = NULL )
	{
		//
		// Empty statement.
		//
		if( $theSubject === NULL )
			parent::__construct();
		
		//
		// Handle provided statement.
		//
		elseif( is_array( $theSubject )
			 || ($theSubject instanceof ArrayObject) )
				parent::__construct( (array) $theSubject );
		
		//
		// Build with elements.
		//
		else
		{
			//
			// Set subject.
			//
			if( $theSubject !== NULL )
				$this->Subject( $theSubject );
			
			//
			// Set predicate.
			//
			if( $thePredicate !== NULL )
				$this->Predicate( $thePredicate );
			
			//
			// Set type.
			//
			if( $theType !== NULL )
				$this->Type( $theType );
			
			//
			// Set range.
			//
			if( $theRange !== NULL )
				$this->Range( $theObject, $theRange );
			
			//
			// Set object.
			//
			elseif( $theObject !== NULL )
				$this->Object( $theObject );
		
		} // Provided statement elements.

	} // Constructor.

		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Subject																			*
	 *==================================================================================*/

	/**
	 * Manage subject.
	 *
	 * This method can be used to manage the query {@link kOFFSET_QUERY_SUBJECT} subject, it
	 * accepts a parameter which represents either the statement subject or the requested
	 * operation, depending on its value:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: Return the current value.
	 *	<li><tt>FALSE</tt>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter.
	 * </ul>
	 *
	 * The second parameter is a boolean which if <tt>TRUE</tt> will return the <i>old</i>
	 * value when replacing values; if <tt>FALSE</tt>, it will return the currently set
	 * value.
	 *
	 * @param string				$theValue			Value or operation.
	 * @param boolean				$getOld				<tt>TRUE<tt> get old value.
	 *
	 * @access public
	 * @return mixed
	 *
	 * @uses ManageOffset()
	 *
	 * @see kOFFSET_QUERY_SUBJECT
	 */
	public function Subject( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kOFFSET_QUERY_SUBJECT, $theValue, $getOld );	// ==>

	} // Subject.

	 
	/*===================================================================================
	 *	Object																			*
	 *==================================================================================*/

	/**
	 * Manage object.
	 *
	 * This method can be used to manage the query {@link kOFFSET_QUERY_DATA} object or
	 * match data, it accepts a parameter which represents either the statement object or
	 * the requested operation, depending on its value:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: Return the current value.
	 *	<li><tt>FALSE</tt>: Delete the current value.
	 *	<li><tt>other</tt>: Set the value with the provided parameter.
	 * </ul>
	 *
	 * The second parameter is a boolean which if <tt>TRUE</tt> will return the <i>old</i>
	 * value when replacing values; if <tt>FALSE</tt>, it will return the currently set
	 * value.
	 *
	 * @param string				$theValue			Value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed
	 *
	 * @uses ManageOffset()
	 *
	 * @see kOFFSET_QUERY_DATA
	 */
	public function Object( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kOFFSET_QUERY_DATA, $theValue, $getOld );		// ==>

	} // Object.

	 
	/*===================================================================================
	 *	Predicate																		*
	 *==================================================================================*/

	/**
	 * Manage predicate.
	 *
	 * This method can be used to manage the query {@link kOFFSET_QUERY_OPERATOR} operator
	 * or predicate, it accepts a parameter which represents either the statement predicate
	 * or the requested operation, depending on its value:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: Return the current value.
	 *	<li><tt>FALSE</tt>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter:
	 *	 <ul>
	 *		<li><i>{@link kOPERATOR_DISABLED}</i>: Disabled, it means that the current
	 *			statement is disabled.
	 *		<li><i>{@link kOPERATOR_EQUAL}</i>: Equality (<tt>=</tt>).
	 *		<li><i>{@link kOPERATOR_EQUAL_NOT}</i>: Inequality (<tt>!=</tt>), negates the
	 *			{@link kOPERATOR_EQUAL} operator.
	 *		<li><i>{@link kOPERATOR_LIKE}</i>: Like, it is an accent and case insensitive
	 *			equality filter.
	 *		<li><i>{@link kOPERATOR_LIKE_NOT}</i>: The negation of the
	 *			{@link kOPERATOR_LIKE} operator.
	 *		<li><i>{@link kOPERATOR_PREFIX}</i>: Starts with, or prefix match.
	 *		<li><i>{@link kOPERATOR_CONTAINS}</i>: Contains, selects all elements that
	 *			contain the match string.
	 *		<li><i>{@link kOPERATOR_SUFFIX}</i>: Ends with, or suffix match.
	 *		<li><i>{@link kOPERATOR_REGEX}</i>: Regular expression.
	 *		<li><i>{@link kOPERATOR_LESS}</i>: Smaller than (<tt><</tt>).
	 *		<li><i>{@link kOPERATOR_LESS_EQUAL}</i>: Smaller than or equal (<tt><=</tt>).
	 *		<li><i>{@link kOPERATOR_GREAT}</i>: Greater than (<tt>></tt>).
	 *		<li><i>{@link kOPERATOR_GREAT_EQUAL}</i>: Greater than or equal (<tt>>=</tt>).
	 *		<li><i>{@link kOPERATOR_IRANGE}</i>: Range inclusive, matches <tt>>= value 
	 *			<=<</tt>.
	 *		<li><i>{@link kOPERATOR_ERANGE}</i>: Range exclusive, matches <tt>> value
	 *			<</tt>.
	 *		<li><i>{@link kOPERATOR_NULL}</i>: Is <tt>NULL</tt> or element is missing.
	 *		<li><i>{@link kOPERATOR_NOT_NULL}</i>:Not <tt>NULL</tt> or element exists.
	 *		<li><i>{@link kOPERATOR_IN}</i>: In, or belongs to set.
	 *		<li><i>{@link kOPERATOR_NI}</i>: Not in, the negation of {@link kOPERATOR_IN}.
	 *		<li><i>{@link kOPERATOR_ALL}</i>: All, or match the full set.
	 *		<li><i>{@link kOPERATOR_NALL}</i>: Not all, the negation of the
	 *			{@link kOPERATOR_ALL} operator.
	 *		<li><i>{@link kOPERATOR_EX}</i>: Expression, indicates a complex expression.
	 *	 </ul>
	 *		If the provided value does not match any of the above, the method will raise an
	 *		exception.
	 * </ul>
	 *
	 * The second parameter is a boolean which if <tt>TRUE</tt> will return the <i>old</i>
	 * value when replacing values; if <tt>FALSE</tt>, it will return the currently set
	 * value.
	 *
	 * @param string				$theValue			Value or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed
	 *
	 * @throws Exception
	 *
	 * @uses ManageOffset()
	 *
	 * @see kOFFSET_QUERY_OPERATOR
	 */
	public function Predicate( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Check predicate.
		//
		if( ($theValue !== NULL)
		 && ($theValue !== FALSE) )
		{
			switch( (string) $theValue )
			{
				case kOPERATOR_DISABLED:
				case kOPERATOR_EQUAL:
				case kOPERATOR_EQUAL_NOT:
				case kOPERATOR_LIKE:
				case kOPERATOR_LIKE_NOT:
				case kOPERATOR_PREFIX:
				case kOPERATOR_PREFIX_NOCASE:
				case kOPERATOR_CONTAINS:
				case kOPERATOR_CONTAINS_NOCASE:
				case kOPERATOR_SUFFIX:
				case kOPERATOR_SUFFIX_NOCASE:
				case kOPERATOR_REGEX:
				case kOPERATOR_LESS:
				case kOPERATOR_LESS_EQUAL:
				case kOPERATOR_GREAT:
				case kOPERATOR_GREAT_EQUAL:
				case kOPERATOR_IRANGE:
				case kOPERATOR_ERANGE:
				case kOPERATOR_NULL:
				case kOPERATOR_NOT_NULL:
				case kOPERATOR_IN:
				case kOPERATOR_NI:
				case kOPERATOR_ALL:
				case kOPERATOR_NALL:
				case kOPERATOR_EX:
					break;
				
				default:
					throw new Exception
						( "Unsupported operator",
						  kERROR_PARAMETER );									// !@! ==>
			}
		}
		
		return ManageOffset( $this, kOFFSET_QUERY_OPERATOR, $theValue, $getOld );	// ==>

	} // Predicate.

	 
	/*===================================================================================
	 *	Type																			*
	 *==================================================================================*/

	/**
	 * Manage data type.
	 *
	 * This method can be used to manage the query data type or object data type, it accepts
	 * a parameter which represents either the data type in which the object is expressed,
	 * or the requested operation, depending on its value:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: Return the current value.
	 *	<li><tt>FALSE</tt>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter:
	 *	 <ul>
	 *		<li><i>{@link kTYPE_STRING}</i>: String, we assume in UTF8 character set.
	 *		<li><i>{@link kTYPE_INT32}</i>: 32 bit signed integer.
	 *		<li><i>{@link kTYPE_INT64}</i>: 64 bit signed integer.
	 *		<li><i>{@link kTYPE_FLOAT}</i>: Floating point number.
	 *		<li><i>{@link kTYPE_DATE}</i>: A string date, it means a string date with a
	 *			YYYYMMDD format in which month and day may be omitted.
	 *		<li><i>{@link kTYPE_TIME}</i>: A string time, it is treated as a string time
	 *			with a YYYY-MM-DD HH:MM:SS format in which all elements are required.
	 *		<li><i>{@link kTYPE_STAMP}</i>: A timestamp, optionally including microseconds.
	 *		<li><i>{@link kTYPE_BOOLEAN}</i>: An <tt>on</tt>/<tt>off</tt> switch.
	 *		<li><i>{@link kTYPE_BINARY}</i>: A binary string.
	 *	 </ul>
	 *		If the provided value does not match any of the above, the method will raise an
	 *		exception.
	 * </ul>
	 *
	 * The second parameter is a boolean which if <tt>TRUE</tt> will return the <i>old</i>
	 * value when replacing values; if <tt>FALSE</tt>, it will return the currently set
	 * value.
	 *
	 * @param string				$theValue			Value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed
	 *
	 * @uses ManageOffset()
	 *
	 * @see kOFFSET_QUERY_TYPE
	 */
	public function Type( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Check predicate.
		//
		if( ($theValue !== NULL)
		 && ($theValue !== FALSE) )
		{
			switch( (string) $theValue )
			{
				case kTYPE_STRING:
				case kTYPE_INT32:
				case kTYPE_INT64:
				case kTYPE_FLOAT:
				case kTYPE_DATE:
				case kTYPE_TIME:
				case kTYPE_STAMP:
				case kTYPE_BOOLEAN:
				case kTYPE_BINARY:
					break;
				
				default:
					throw new Exception
						( "Unsupported data type",
						  kERROR_PARAMETER );									// !@! ==>
			}
		}
		
		return ManageOffset( $this, kOFFSET_QUERY_TYPE, $theValue, $getOld );		// ==>

	} // Type.

	 
	/*===================================================================================
	 *	Range																			*
	 *==================================================================================*/

	/**
	 * Manage range.
	 *
	 * This method can be used to manage the query object if it is in the form of a range.
	 * This method will only allow you to set the range, to retrieve or delete the range you
	 * must use the {@link Object()} method.
	 *
	 * The method accepts the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theBound1</tt>: First range bound.
	 *	<li><tt>$theBound2</tt>: Second range bound.
	 *	<li><tt>$getOld</tt>: If <tt>TRUE</tt> will return the <i>old</i> value when
	 *		replacing values; if <tt>FALSE</tt>, it will return the currently set value.
	 * </ul>
	 *
	 * @param mixed					$theBound1			First bound.
	 * @param mixed					$theBound2			Second bound.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed
	 *
	 * @uses Object()
	 *
	 * @see kOFFSET_QUERY_DATA
	 */
	public function Range( $theBound1, $theBound2, $getOld = FALSE )
	{
		return $this->Object( array( $theBound1, $theBound2 ), $getOld );			// ==>

	} // Range.

		

/*=======================================================================================
 *																						*
 *									STATIC INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Disabled																		*
	 *==================================================================================*/

	/**
	 * Create a disabled statement.
	 *
	 * This method can be used to instantiate a disabled query statement. A disabled
	 * statement is one that should not execute, it can be used as a placeholder, or
	 * external methods may disable statements.
	 *
	 * The statement uses the {@link kOPERATOR_DISABLED} operator and this method accepts
	 * the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object or first range bound.
	 *	<li><tt>$theType</tt>: Statement object data type.
	 *	<li><tt>$theRange</tt>: Statement second range bound.
	 * </ul>
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object or range bound.
	 * @param string				$theType			Statement object data type.
	 * @param mixed					$theRange			Statement range bound.
	 *
	 * @static
	 *
	 * @see kOPERATOR_DISABLED
	 */
	static function Disabled( $theSubject, $theObject = NULL,
										   $theType = NULL,
										   $theRange = NULL )
	{
		return new self( (string) $theSubject, kOPERATOR_DISABLED,
						 $theType, $theObject, $theRange );							// ==>

	} // Disabled.

	 
	/*===================================================================================
	 *	Equals																			*
	 *==================================================================================*/

	/**
	 * Create an equals statement.
	 *
	 * This method can be used to instantiate an equality query
	 * statement.
	 *
	 * The statement uses the {@link kOPERATOR_EQUAL} operator and this method accepts the
	 * following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object.
	 *	<li><tt>$theType</tt>: Statement object data type.
	 * </ul>
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object.
	 * @param string				$theType			Statement object data type.
	 *
	 * @static
	 *
	 * @see kOPERATOR_EQUAL
	 */
	static function Equals( $theSubject, $theObject, $theType = NULL )
	{
		//
		// Try to infer type.
		//
		if( $theType === NULL )
			$theType = static::InferDataType( $theObject );
			
		return new self
			( (string) $theSubject, kOPERATOR_EQUAL, $theType, $theObject );		// ==>

	} // Equals.

	 
	/*===================================================================================
	 *	NotEquals																		*
	 *==================================================================================*/

	/**
	 * Create a not equals statement.
	 *
	 * This method can be used to instantiate a not {@link kOPERATOR_EQUAL_NOT} query
	 * statement, which is the negation of the {@link Equals()} statement.
	 *
	 * The statement uses the {@link kOPERATOR_EQUAL_NOT} operator and this method accepts
	 * the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object.
	 *	<li><tt>$theType</tt>: Statement object data type.
	 * </ul>
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object.
	 * @param string				$theType			Statement object data type.
	 *
	 * @static
	 *
	 * @see kOPERATOR_EQUAL_NOT
	 */
	static function NotEquals( $theSubject, $theObject, $theType = NULL )
	{
		//
		// Try to infer type.
		//
		if( $theType === NULL )
			$theType = static::InferDataType( $theObject );
			
		return new self
			( (string) $theSubject, kOPERATOR_EQUAL_NOT, $theType, $theObject );	// ==>

	} // NotEquals.

	 
	/*===================================================================================
	 *	Like																			*
	 *==================================================================================*/

	/**
	 * Create a case and accent insensitive equality statement.
	 *
	 * This method can be used to instantiate a {@link kOPERATOR_LIKE} query statement,
	 * which is equivalent to the SQL <tt>LIKE</tt> clause, an accent and case insensitive
	 * comparaison.
	 *
	 * The statement uses the {@link kOPERATOR_LIKE} operator and this method accepts the
	 * following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object match string.
	 * </ul>
	 *
	 * Note that the data type is implicitly a {@link kTYPE_STRING} string
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object.
	 *
	 * @static
	 *
	 * @see kOPERATOR_LIKE kTYPE_STRING
	 */
	static function Like( $theSubject, $theObject )
	{
		return new self( (string) $theSubject,
						  kOPERATOR_LIKE,
						  kTYPE_STRING,
						  (string) $theObject );									// ==>

	} // Like.

	 
	/*===================================================================================
	 *	NotLike																			*
	 *==================================================================================*/

	/**
	 * Create a not like statement.
	 *
	 * This method can be used to instantiate a {@link kOPERATOR_LIKE_NOT} query statement,
	 * which is the negation of the {@link Like()} statement.
	 *
	 * The statement uses the {@link kOPERATOR_LIKE_NOT} operator and this method accepts
	 * the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object match string.
	 * </ul>
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object.
	 *
	 * @static
	 *
	 * @see kOPERATOR_LIKE_NOT kTYPE_STRING
	 */
	static function NotLike( $theSubject, $theObject )
	{
		return new self( (string) $theSubject,
						  kOPERATOR_LIKE_NOT,
						  kTYPE_STRING,
						  (string) $theObject );									// ==>

	} // NotLike.

	 
	/*===================================================================================
	 *	Prefix																			*
	 *==================================================================================*/

	/**
	 * Create a prefix statement.
	 *
	 * This method can be used to instantiate a query statement that will select all
	 * elements whose contents beginning matches the test data.
	 *
	 * The statement uses the {@link kOPERATOR_PREFIX} operator and this method accepts the
	 * following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object prefix string.
	 * </ul>
	 *
	 * Note that the data type is implicitly a {@link kTYPE_STRING} string.
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object.
	 *
	 * @static
	 *
	 * @see kOPERATOR_PREFIX kTYPE_STRING
	 */
	static function Prefix( $theSubject, $theObject )
	{
		return new self( (string) $theSubject,
						  kOPERATOR_PREFIX,
						  kTYPE_STRING,
						  (string) $theObject );									// ==>

	} // Prefix.

	 
	/*===================================================================================
	 *	PrefixNoCase																	*
	 *==================================================================================*/

	/**
	 * Create a case-insensitive prefix statement.
	 *
	 * This method can be used to instantiate a query statement that will select all
	 * elements whose contents beginning matches the test data in a case and accent
	 * insensitive way.
	 *
	 * The statement uses the {@link kOPERATOR_PREFIX_NOCASE} operator and this method
	 * accepts the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object prefix string.
	 * </ul>
	 *
	 * Note that the data type is implicitly a {@link kTYPE_STRING} string.
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object.
	 *
	 * @static
	 *
	 * @see kOPERATOR_PREFIX_NOCASE kTYPE_STRING
	 */
	static function PrefixNoCase( $theSubject, $theObject )
	{
		return new self( (string) $theSubject,
						  kOPERATOR_PREFIX_NOCASE,
						  kTYPE_STRING,
						  (string) $theObject );									// ==>

	} // PrefixNoCase.

	 
	/*===================================================================================
	 *	Contains																		*
	 *==================================================================================*/

	/**
	 * Create a contains statement.
	 *
	 * This method can be used to instantiate a query statement that will select all
	 * elements whose contents matches the test data in any position.
	 *
	 * The statement uses the {@link kOPERATOR_CONTAINS} operator and this method accepts
	 * the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object match sub-string.
	 * </ul>
	 *
	 * Note that the data type is implicitly a {@link kTYPE_STRING} string.
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object.
	 *
	 * @static
	 *
	 * @see kOPERATOR_CONTAINS kTYPE_STRING
	 */
	static function Contains( $theSubject, $theObject )
	{
		return new self( (string) $theSubject,
						  kOPERATOR_CONTAINS,
						  kTYPE_STRING,
						  (string) $theObject );									// ==>

	} // Contains.

	 
	/*===================================================================================
	 *	ContainsNoCase																	*
	 *==================================================================================*/

	/**
	 * Create a case-insensitive contains statement.
	 *
	 * This method can be used to instantiate a query statement that will select all
	 * elements whose contents matches the test data in any position in a case and accent
	 * insensitive way.
	 *
	 * The statement uses the {@link kOPERATOR_CONTAINS_NOCASE} operator and this method
	 * accepts the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object match sub-string.
	 * </ul>
	 *
	 * Note that the data type is implicitly a {@link kTYPE_STRING} string.
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object.
	 *
	 * @static
	 *
	 * @see kOPERATOR_CONTAINS_NOCASE kTYPE_STRING
	 */
	static function ContainsNoCase( $theSubject, $theObject )
	{
		return new self( (string) $theSubject,
						  kOPERATOR_CONTAINS_NOCASE,
						  kTYPE_STRING,
						  (string) $theObject );									// ==>

	} // ContainsNoCase.

	 
	/*===================================================================================
	 *	Suffix																			*
	 *==================================================================================*/

	/**
	 * Create a suffix statement.
	 *
	 * This method can be used to instantiate a query statement that will select all
	 * elements whose contents end matches the test data.
	 *
	 * The statement uses the {@link kOPERATOR_SUFFIX} operator and this method accepts the
	 * following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object suffix string.
	 * </ul>
	 *
	 * Note that the data type is implicitly a {@link kTYPE_STRING} string.
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object.
	 *
	 * @static
	 *
	 * @see kOPERATOR_SUFFIX kTYPE_STRING
	 */
	static function Suffix( $theSubject, $theObject )
	{
		return new self( (string) $theSubject,
						  kOPERATOR_SUFFIX,
						  kTYPE_STRING,
						  (string) $theObject );									// ==>

	} // Suffix.

	 
	/*===================================================================================
	 *	SuffixNoCase																	*
	 *==================================================================================*/

	/**
	 * Create a case-insensitive suffix statement.
	 *
	 * This method can be used to instantiate a query statement that will select all
	 * elements whose contents end matches the test data in a case and accent insensitive
	 * way.
	 *
	 * The statement uses the {@link kOPERATOR_SUFFIX_NOCASE} operator and this method
	 * accepts the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object suffix string.
	 * </ul>
	 *
	 * Note that the data type is implicitly a {@link kTYPE_STRING} string.
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object.
	 *
	 * @static
	 *
	 * @see kOPERATOR_SUFFIX_NOCASE kTYPE_STRING
	 */
	static function SuffixNoCase( $theSubject, $theObject )
	{
		return new self( (string) $theSubject,
						  kOPERATOR_SUFFIX_NOCASE,
						  kTYPE_STRING,
						  (string) $theObject );									// ==>

	} // SuffixNoCase.

	 
	/*===================================================================================
	 *	Regex																			*
	 *==================================================================================*/

	/**
	 * Create a regular expression statement.
	 *
	 * This method can be used to instantiate a query statement that will select all
	 * elements that match the provided regular expression pattern.
	 *
	 * The statement uses the {@link kOPERATOR_REGEX} operator and this method accepts the
	 * following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object regular expression pattern.
	 * </ul>
	 *
	 * Note that the data type is implicitly a {@link kTYPE_STRING} string.
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object.
	 *
	 * @static
	 *
	 * @see kOPERATOR_REGEX kTYPE_STRING
	 */
	static function Regex( $theSubject, $theObject )
	{
		return new self( (string) $theSubject,
						  kOPERATOR_REGEX,
						  kTYPE_STRING,
						  (string) $theObject );									// ==>

	} // Regex.

	 
	/*===================================================================================
	 *	Less																			*
	 *==================================================================================*/

	/**
	 * Create a less than statement.
	 *
	 * This method can be used to instantiate a <tt><</tt> query statement.
	 *
	 * The statement uses the {@link kOPERATOR_LESS} operator and this method accepts the
	 * following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object, or comparaison value.
	 *	<li><tt>$theType</tt>: Statement object data type.
	 * </ul>
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object.
	 * @param string				$theType			Statement object data type.
	 *
	 * @static
	 *
	 * @see kOPERATOR_LESS
	 */
	static function Less( $theSubject, $theObject, $theType = NULL )
	{
		//
		// Try to infer type.
		//
		if( $theType === NULL )
			$theType = static::InferDataType( $theObject );
			
		return new self
			( (string) $theSubject, kOPERATOR_LESS, $theType, $theObject );			// ==>

	} // Less.

	 
	/*===================================================================================
	 *	LessEqual																		*
	 *==================================================================================*/

	/**
	 * Create a less than or equal statement.
	 *
	 * This method can be used to instantiate a <tt><=</tt> query statement.
	 *
	 * The statement uses the {@link kOPERATOR_LESS_EQUAL} operator and this method accepts
	 * the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object, or comparaison value.
	 *	<li><tt>$theType</tt>: Statement object data type.
	 * </ul>
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object.
	 * @param string				$theType			Statement object data type.
	 *
	 * @static
	 *
	 * @see kOPERATOR_LESS_EQUAL
	 */
	static function LessEqual( $theSubject, $theObject, $theType = NULL )
	{
		//
		// Try to infer type.
		//
		if( $theType === NULL )
			$theType = static::InferDataType( $theObject );
			
		return new self
			( (string) $theSubject, kOPERATOR_LESS_EQUAL, $theType, $theObject );	// ==>

	} // LessEqual.

	 
	/*===================================================================================
	 *	Great																			*
	 *==================================================================================*/

	/**
	 * Create a greater than statement.
	 *
	 * This method can be used to instantiate a <tt>></tt> query statement.
	 *
	 * The statement uses the {@link kOPERATOR_GREAT} operator and this method accepts the
	 * following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object, or comparaison value.
	 *	<li><tt>$theType</tt>: Statement object data type.
	 * </ul>
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object.
	 * @param string				$theType			Statement object data type.
	 *
	 * @static
	 *
	 * @see kOPERATOR_GREAT
	 */
	static function Great( $theSubject, $theObject, $theType = NULL )
	{
		//
		// Try to infer type.
		//
		if( $theType === NULL )
			$theType = static::InferDataType( $theObject );
			
		return new self
			( (string) $theSubject, kOPERATOR_GREAT, $theType, $theObject );		// ==>

	} // Great.

	 
	/*===================================================================================
	 *	GreatEqual																		*
	 *==================================================================================*/

	/**
	 * Create a greater than or equal statement.
	 *
	 * This method can be used to instantiate a <tt>>=</tt> query statement.
	 *
	 * The statement uses the {@link kOPERATOR_GREAT_EQUAL} operator and this method accepts
	 * the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object, or comparaison value.
	 *	<li><tt>$theType</tt>: Statement object data type.
	 * </ul>
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object.
	 * @param string				$theType			Statement object data type.
	 *
	 * @static
	 *
	 * @see kOPERATOR_GREAT_EQUAL
	 */
	static function GreatEqual( $theSubject, $theObject, $theType = NULL )
	{
		//
		// Try to infer type.
		//
		if( $theType === NULL )
			$theType = static::InferDataType( $theObject );
			
		return new self
			( (string) $theSubject, kOPERATOR_GREAT_EQUAL, $theType, $theObject );	// ==>

	} // GreatEqual.

	 
	/*===================================================================================
	 *	RangeInclusive																	*
	 *==================================================================================*/

	/**
	 * Create a range inclusive statement.
	 *
	 * This method can be used to instantiate a range inclusive query statement, the
	 * statement will check if the subject value lies between the two range bounds including
	 * the bound values.
	 *
	 * The statement uses the {@link kOPERATOR_IRANGE} operator and this method accepts the
	 * following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theBound1</tt>: Statement range lower bound.
	 *	<li><tt>$theBound2</tt>: Statement range upper bound.
	 *	<li><tt>$theType</tt>: Statement range data type.
	 * </ul>
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theBound1			Range lower bound.
	 * @param mixed					$theBound2			Range upper bound.
	 * @param string				$theType			Statement object data type.
	 *
	 * @static
	 *
	 * @see kOPERATOR_IRANGE
	 */
	static function RangeInclusive( $theSubject, $theBound1, $theBound2, $theType = NULL )
	{
		//
		// Try to infer type.
		//
		if( $theType === NULL )
			$theType = static::InferDataType( $theBound1 );
			
		return new self
			( (string) $theSubject, kOPERATOR_IRANGE, $theType, $theBound1,
																$theBound2 );		// ==>

	} // RangeInclusive.

	 
	/*===================================================================================
	 *	RangeExclusive																	*
	 *==================================================================================*/

	/**
	 * Create a range exclusive statement.
	 *
	 * This method can be used to instantiate a range exclusive query statement, the
	 * statement will check if the subject value lies between the two range bounds excluding
	 * the bound values.
	 *
	 * The statement uses the {@link kOPERATOR_ERANGE} operator and this method accepts the
	 * following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theBound1</tt>: Statement range lower bound.
	 *	<li><tt>$theBound2</tt>: Statement range upper bound.
	 *	<li><tt>$theType</tt>: Statement range data type.
	 * </ul>
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theBound1			Range lower bound.
	 * @param mixed					$theBound2			Range upper bound.
	 * @param string				$theType			Statement object data type.
	 *
	 * @static
	 *
	 * @see kOPERATOR_ERANGE
	 */
	static function RangeExclusive( $theSubject, $theBound1, $theBound2, $theType = NULL )
	{
		//
		// Try to infer type.
		//
		if( $theType === NULL )
			$theType = static::InferDataType( $theBound1 );
			
		return new self
			( (string) $theSubject, kOPERATOR_ERANGE, $theType, $theBound1,
																$theBound2 );		// ==>

	} // RangeExclusive.

	 
	/*===================================================================================
	 *	Missing																			*
	 *==================================================================================*/

	/**
	 * Create a missing statement.
	 *
	 * This method can be used to instantiate a missing query statement, the statement will
	 * check if the subject is missing or is <tt>NULL</tt>.
	 *
	 * The statement uses the {@link kOPERATOR_NULL} operator and this method accepts the
	 * following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 * </ul>
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 *
	 * @static
	 *
	 * @see kOPERATOR_NULL
	 */
	static function Missing( $theSubject)
	{
		return new self( (string) $theSubject, kOPERATOR_NULL );					// ==>

	} // Missing.

	 
	/*===================================================================================
	 *	Exists																			*
	 *==================================================================================*/

	/**
	 * Create an exists statement.
	 *
	 * This method can be used to instantiate an exists query statement, the statement will
	 * check if the subject exists or is not <i>NULL</i>.
	 *
	 * The statement uses the {@link kOPERATOR_NOT_NULL} operator and this method accepts
	 * the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 * </ul>
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 *
	 * @static
	 *
	 * @see kOPERATOR_NOT_NULL
	 */
	static function Exists( $theSubject)
	{
		return new self( (string) $theSubject, kOPERATOR_NOT_NULL );				// ==>

	} // Exists.

	 
	/*===================================================================================
	 *	Member																			*
	 *==================================================================================*/

	/**
	 * Create a membership statement.
	 *
	 * This method can be used to instantiate a membership query statement which will test
	 * whether the subject value can be found in the provided object, which will be
	 * interpreted as a list of values.
	 *
	 * If the provided object is not an <tt>array</tt> or an <tt>{@link ArrayObject}</tt>,
	 * the method will add it to a newly created array.
	 *
	 * The statement uses the {@link kOPERATOR_IN} operator and this method accepts the
	 * following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object, or members list.
	 *	<li><tt>$theType</tt>: Statement object data type.
	 * </ul>
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object.
	 * @param string				$theType			Statement object data type.
	 *
	 * @static
	 *
	 * @see kOPERATOR_IN
	 */
	static function Member( $theSubject, $theObject, $theType = NULL )
	{
		//
		// Handle scalars.
		//
		if( (! is_array( $theObject ))
		 && (! $theObject instanceof ArrayObject) )
			$theObject = array( $theObject );
		
		//
		// Serialise objects.
		//
		$list = Array();
		foreach( $theObject as $object )
			$list[] = $object;
		
		return new self( (string) $theSubject, kOPERATOR_IN, $theType, $list );		// ==>

	} // Member.

	 
	/*===================================================================================
	 *	NotMember																		*
	 *==================================================================================*/

	/**
	 * Create a non membership statement.
	 *
	 * This method can be used to instantiate a non membership query statement which will
	 * test whether the subject value cannot be found in the provided object, which will be
	 * interpreted as a list of values.
	 *
	 * If the provided object is not an <tt>array</tt> or an <tt>{@link ArrayObject}</tt>,
	 * the method will add it to a newly created array.
	 *
	 * The statement uses the {@link kOPERATOR_NI} operator and this method accepts the
	 * following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object, or members list.
	 *	<li><tt>$theType</tt>: Statement object data type.
	 * </ul>
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object.
	 * @param string				$theType			Statement object data type.
	 *
	 * @static
	 *
	 * @see kOPERATOR_NI
	 */
	static function NotMember( $theSubject, $theObject, $theType = NULL )
	{
		//
		// Handle scalars.
		//
		if( (! is_array( $theObject ))
		 && (! $theObject instanceof ArrayObject) )
			$theObject = array( $theObject );
		
		//
		// Serialise objects.
		//
		$list = Array();
		foreach( $theObject as $object )
			$list[] = $object;
		
		return new self( (string) $theSubject, kOPERATOR_NI, $theType, $list );		// ==>

	} // NotMember.

	 
	/*===================================================================================
	 *	All																				*
	 *==================================================================================*/

	/**
	 * Create an all statement.
	 *
	 * This method can be used to instantiate an all query statement which will test whether
	 * all the subject values can be found in the provided object, which will be interpreted
	 * as a list of values.
	 *
	 * If the provided object is not an <tt>array</tt> or an <tt>{@link ArrayObject}</tt>,
	 * the method will add it to a newly created array.
	 *
	 * The statement uses the {@link kOPERATOR_ALL} operator and this method accepts the
	 * following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object, or members list.
	 *	<li><tt>$theType</tt>: Statement object data type.
	 * </ul>
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object.
	 * @param string				$theType			Statement object data type.
	 *
	 * @static
	 *
	 * @see kOPERATOR_ALL
	 */
	static function All( $theSubject, $theObject, $theType = NULL )
	{
		//
		// Handle scalars.
		//
		if( (! is_array( $theObject ))
		 && (! $theObject instanceof ArrayObject) )
			$theObject = array( $theObject );
		
		//
		// Serialise objects.
		//
		$list = Array();
		foreach( $theObject as $object )
			$list[] = $object;
		
		return new self( (string) $theSubject, kOPERATOR_ALL, $theType, $list );	// ==>

	} // All.

	 
	/*===================================================================================
	 *	NotAll																			*
	 *==================================================================================*/

	/**
	 * Create a not all statement.
	 *
	 * This method can be used to instantiate a not all query statement which will test
	 * whether any of the subject values cannot be found in the provided object, which will
	 * be interpreted as a list of values. This statement is the negation of the
	 * {@link All()} statement.
	 *
	 * If the provided object is not an <tt>array</tt> or an <tt>{@link ArrayObject}</tt>,
	 * the method will add it to a newly created array.
	 *
	 * The statement uses the {@link kOPERATOR_NALL} operator and this method accepts the
	 * following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object, or members list.
	 *	<li><tt>$theType</tt>: Statement object data type.
	 * </ul>
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object.
	 * @param string				$theType			Statement object data type.
	 *
	 * @static
	 *
	 * @see kOPERATOR_NALL
	 */
	static function NotAll( $theSubject, $theObject, $theType = NULL )
	{
		//
		// Handle scalars.
		//
		if( (! is_array( $theObject ))
		 && (! $theObject instanceof ArrayObject) )
			$theObject = array( $theObject );
		
		//
		// Serialise objects.
		//
		$list = Array();
		foreach( $theObject as $object )
			$list[] = $object;
		
		return new self( (string) $theSubject, kOPERATOR_NALL, $theType, $list );	// ==>

	} // NotAll.

	 
	/*===================================================================================
	 *	Expression																		*
	 *==================================================================================*/

	/**
	 * Create an expression statement.
	 *
	 * This method can be used to instantiate an expression query statement in which the
	 * object of the statement represents an expression.
	 *
	 * Note that in this case the type is not relevant and it is set by default as a
	 * {@link kTYPE_STRING} string.
	 *
	 * The statement uses the {@link kOPERATOR_EX} operator and this method accepts the
	 * following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theSubject</tt>: Statement subject.
	 *	<li><tt>$theObject</tt>: Statement object, or comparaison value.
	 *	<li><tt>$theType</tt>: Statement object data type.
	 * </ul>
	 *
	 * The method will return an instance of this class or raise an exception on errors.
	 *
	 * @param mixed					$theSubject			Statement subject.
	 * @param mixed					$theObject			Statement object or expression.
	 *
	 * @static
	 *
	 * @see kOPERATOR_EX kTYPE_STRING
	 */
	static function Expression( $theSubject, $theObject )
	{
		return new self
			( (string) $theSubject, kOPERATOR_EX, kTYPE_STRING, $theObject );	// ==>

	} // Expression.

	 

/*=======================================================================================
 *																						*
 *								STATIC UTILITIES INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	InferDataType																	*
	 *==================================================================================*/

	/**
	 * Infer data type.
	 *
	 * This method will try to infer the data type of the provided object according to its
	 * PHP data type:
	 *
	 * <ul>
	 *	<li><tt>boolean</tt>: Will return the {@link kTYPE_BOOLEAN} value.
	 *	<li><tt>integer</tt>: Will return the {@link kTYPE_INT32} value.
	 *	<li><tt>double</tt>: Will return the {@link kTYPE_FLOAT} value.
	 *	<li><tt>string</tt>: Will return the {@link kTYPE_STRING} value.
	 *	<li><i>other</i>: Any other type will return <tt>NULL</tt>.
	 * </ul>
	 *
	 * @param mixed					$theValue				Value to test.
	 *
	 * @static
	 *
	 * @throws Exception
	 * @return mixed				The data type or <tt>NULL</tt>.
	 */
	static function InferDataType( $theValue )
	{
		//
		// Check value.
		//
		switch( gettype( $theValue ) )
		{
			case 'boolean':		return kTYPE_BOOLEAN;								// ==>
			case 'integer':		return kTYPE_INT32;									// ==>
			case 'double':		return kTYPE_FLOAT;									// ==>
			case 'string':		return kTYPE_STRING;								// ==>
		
		} // Checking value.
		
		return NULL;																// ==>
	
	} // InferDataType.

	 

} // class CQueryStatement.


?>
