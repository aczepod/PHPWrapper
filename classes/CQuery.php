<?php

/**
 * <i>CQuery</i> class definition.
 *
 * This file contains the class definition of <b>CQuery</b> which represents a query object.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 19/09/2012
*/

/*=======================================================================================
 *																						*
 *										CQuery.php										*
 *																						*
 *======================================================================================*/

/**
 * Local definitions.
 *
 * This include file contains all local definitions to this class.
 */
require_once( "CQuery.inc.php" );

/**
 * Types.
 *
 * This include file contains all type definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Types.inc.php" );

/**
 * Operators.
 *
 * This include file contains all operator definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Operators.inc.php" );

/**
 * Ancestor.
 *
 * This include file contains the parent class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CStatusDocument.php" );

/**
 * <h3>Query</h3>
 *
 * This class implements a query.
 *
 * The main goal of this class is to provide a common framework and format to exchange data
 * store queries or filters.
 *
 * The query is an array structured as follows:
 *
 * <ul>
 *	<li><i>index</i>: The index of the root element expresses a boolean condition which
 *		qualifies its content:
 *	 <ul>
 *		<li><i>{@link kOPERATOR_AND}</i>: AND.
 *		<li><i>{@link kOPERATOR_NAND}</i>: Not AND.
 *		<li><i>{@link kOPERATOR_OR}</i>: OR.
 *		<li><i>{@link kOPERATOR_NOR}</i>: Not OR.
 *	 </ul>
 *		The value of this root element is an array that can be of two types:
 *	 <ul>
 *		<li><i>Query statement</i>: A query statement defines a filter structured as
 *			follows:
 *		 <ul>
 *			<li><i>{@link kOFFSET_QUERY_SUBJECT}</i>: The subject field. It refers to the
 *				object element that we are filtering.
 *			<li><i>{@link kOFFSET_QUERY_OPERATOR}</i>: The filter operator. This element is
 *				required and can take the following values:
 *			 <ul>
 *				<li><i>{@link kOPERATOR_DISABLED}</i>: Disabled, it means that the filter is
 *					disabled.
 *				<li><i>{@link kOPERATOR_EQUAL}</i>: Equality (<tt>=</tt>).
 *				<li><i>{@link kOPERATOR_EQUAL_NOT}</i>: Inequality (<tt>!=</tt>), negates
 *					the {@link kOPERATOR_EQUAL} operator.
 *				<li><i>{@link kOPERATOR_LIKE}</i>: Like, it is an accent and case
 *					insensitive equality filter.
 *				<li><i>{@link kOPERATOR_LIKE_NOT}</i>: The negation of the
 *					{@link kOPERATOR_LIKE LIKE} operator.
 *				<li><i>{@link kOPERATOR_PREFIX}</i>: Starts with, or prefix match.
 *				<li><i>{@link kOPERATOR_CONTAINS}</i>: Contains, selects all elements that
 *					contain the match string.
 *				<li><i>{@link kOPERATOR_SUFFIX}</i>: Ends with, or suffix match.
 *				<li><i>{@link kOPERATOR_REGEX}</i>: Regular expression.
 *				<li><i>{@link kOPERATOR_LESS}</i>: Smaller than (<tt><</tt>).
 *				<li><i>{@link kOPERATOR_LESS_EQUAL}</i>: Smaller than or equal
 *					(<tt><=</tt>).
 *				<li><i>{@link kOPERATOR_GREAT}</i>: Greater than (<tt>></tt>).
 *				<li><i>{@link kOPERATOR_GREAT_EQUAL}</i>: Greater than or equal
 *					(<tt>>=</tt>).
 *				<li><i>{@link kOPERATOR_IRANGE}</i>: Range inclusive, matches <tt>>= value
 *					<=</tt>.
 *				<li><i>{@link kOPERATOR_ERANGE}</i>: Range exclusive, matches <tt>> value
 *					<</tt>.
 *				<li><i>{@link kOPERATOR_NULL}</i>: Is <tt>NULL</tt> or element is missing.
 *				<li><i>{@link kOPERATOR_NOT_NULL}</i>:Not <tt>NULL</tt> or element exists.
 *				<li><i>{@link kOPERATOR_IN}</i>: In, or belongs to set.
 *				<li><i>{@link kOPERATOR_NI}</i>: Not in, the negation of
 *					{@link kOPERATOR_IN}.
 *				<li><i>{@link kOPERATOR_ALL}</i>: All, or match the full set.
 *				<li><i>{@link kOPERATOR_NALL}</i>: Not all, the negation of the
 *					{@link kOPERATOR_ALL} operator.
 *				<li><i>{@link kOPERATOR_EX}</i>: Expression, indicates a complex expression.
 *			 </ul>
 *			<li><i>{@link kOFFSET_QUERY_TYPE}</i>: The data type of the
 *				{@link kOFFSET_QUERY_DATA} element:
 *			 <ul>
 *				<li><i>{@link kTYPE_STRING}</i>: String, we assume in UTF8 character set.
 *				<li><i>{@link kTYPE_INT32}</i>: 32 bit signed integer.
 *				<li><i>{@link kTYPE_INT64}</i>: 64 bit signed integer.
 *				<li><i>{@link kTYPE_FLOAT}</i>: Floating point number.
 *				<li><i>{@link kTYPE_DATE}</i>: A date.
 *				<li><i>{@link kTYPE_TIME}</i>: A date and time.
 *				<li><i>{@link kTYPE_STAMP}</i>: A native timestamp.
 *				<li><i>{@link kTYPE_BOOLEAN}</i>: An <tt>on</tt>/<tt>off</tt> switch.
 *				<li><i>{@link kTYPE_BINARY}</i>: A binary string.
 *				<li><i>{@link kTYPE_ENUM }</i>: An enumerated value.
 *				<li><i>{@link kTYPE_ENUM_SET}</i>: An enumerated set of values.
 *			 </ul>
 *			<li><i>{@link kOFFSET_QUERY_DATA}</i>: The statement test data.
 *		 </ul>
 *		<li><i>Nested query condition</i>: A nested structure as the current one.
 *	 </ul>
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 */
class CQuery extends CStatusDocument
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
	 * <h4>Instantiate class</h4>
	 *
	 * If you omit the parameter the method will instantiate an empty query, if you provide
	 * an <tt>array</tt> or <tt>{@link ArrayObject}</tt> it will assume the structure to be
	 * a query and will instantiate the object with it; any other data type will raise an
	 * exception.
	 *
	 * @param mixed					$theQuery			Query data.
	 *
	 * @access public
	 *
	 * @throws Exception
	 */
	public function __construct( $theQuery = NULL )
	{
		//
		// Handle empty query.
		//
		if( $theQuery === NULL )
			parent::__construct();
		
		//
		// Handle well formed query.
		//
		elseif( is_array( $theQuery )
			 || ($theQuery instanceof ArrayObject) )
			parent::__construct( (array) $theQuery );
		
		//
		// Empty query.
		//
		elseif( ! strlen( $theQuery ) )
			parent::__construct();
		
		//
		// Invalid query.
		//
		else
			throw new Exception( "Invalid query: expecting an array",
								  kERROR_PARAMETER );							// !@! ==>

	} // Constructor.

		

/*=======================================================================================
 *																						*
 *								PUBLIC OPERATION INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	AppendStatement																	*
	 *==================================================================================*/

	/**
	 * <h4>Append statement</h4>
	 *
	 * This method will append the provided statement to the query, the second parameter
	 * represents the condition.
	 *
	 * Appended statements are merged at the condition level: if the condition exists at any
	 * level, the statement is appended to that condition; if the condition does not exist,
	 * it is created. Obviously, {@link kOPERATOR_AND} and {@link kOPERATOR_NAND} are
	 * treated as equivalent, as well as {@link kOPERATOR_OR} and {@link kOPERATOR_NOR}.
	 *
	 * If you provide an object derived from {@link CQuery} as the statement, the method
	 * will ignore the condition parameter and append the provided query to the current
	 * object.
	 *
	 * @param array					$theStatement		Statement.
	 * @param string				$theCondition		Statement condition.
	 *
	 * @access public
	 */
	public function AppendStatement( $theStatement, $theCondition = kOPERATOR_AND )
	{
		//
		// Get statement key.
		//
		$key = key( $theStatement );
		
		//
		// Parse by key.
		//
		switch( $key )
		{
			//
			// Handle nested conditions.
			//
			case kOPERATOR_OR:
			case kOPERATOR_NOR:
			case kOPERATOR_AND:
			case kOPERATOR_NAND:
				//
				// Iterate query conditions.
				//
				foreach( $theStatement as $condition => $statements )
				{
					//
					// Iterate query statements.
					//
					foreach( $statements as $statement )
						$this->AppendStatement( $statement, $condition );
				
				} // Iterating query conditions.
				
				break;
			
			//
			// Handle statements.
			//
			default:
		
				//
				// Point to provided statement.
				// Here we assume it is a statement, not a nested condition.
				//
				if( is_int( key( $theStatement ) ) )
				{
					$element = current( $theStatement );
					$statement = $theStatement;
				}
				else
				{
					$element = $theStatement;
					$statement = array( $theStatement );
				}
				
				//
				// Validate statement.
				//
				$this->_ValidateCondition( $theCondition, $statement, 0 );
				
				//
				// Handle empty query.
				//
				if( ! $this->count() )
					$this->offsetSet( $theCondition, $statement );
				
				//
				// Append to existing query.
				//
				else
				{
					//
					// Get array copy.
					//
					$query = $this->getArrayCopy();
					
					//
					// Append statement.
					//
					$this->_AppendStatement( $query, $theCondition, $element );
					
					//
					// Update object.
					//
					$this->exchangeArray( $query );
				
				} // Append to current query.
				
				break;
			
		} // Parsed by statement key.
	
	} // AppendStatement.

		

/*=======================================================================================
 *																						*
 *								PUBLIC VALIDATION INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Validate																		*
	 *==================================================================================*/

	/**
	 * <h4>Validate query</h4>
	 *
	 * This method will check whether the query structure is valid.
	 *
	 * @access public
	 *
	 * @uses _ValidateCondition()
	 */
	public function Validate()
	{
		//
		// Traverse object.
		//
		foreach( $this as $condition => $statements )
			$this->_ValidateCondition( $condition, $statements, 0 );
	
	} // Validate.

	 

/*=======================================================================================
 *																						*
 *									PUBLIC EXPORT INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Export																			*
	 *==================================================================================*/

	/**
	 * <h4>Export query</h4>
	 *
	 * The method will return an array suitable to be provided as a native query, the
	 * method requires a container that will take care of converting query arguments to
	 * native data types.
	 *
	 * In this class we simply return the query as it is.
	 *
	 * @param CConnection			$theContainer		Query container.
	 *
	 * @access public
	 * @return array
	 *
	 * @throws Exception
	 */
	public function Export( CConnection $theContainer )	{	return $this->getArrayCopy();	}

	 

/*=======================================================================================
 *																						*
 *									PROTECTED QUERY UTILITIES							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_AppendStatement																*
	 *==================================================================================*/

	/**
	 * <h4>Append statement</h4>
	 *
	 * This method will append the provided statement to the current query.
	 *
	 * Statements of the same type, {@link kOPERATOR_AND} and {@link kOPERATOR_NAND},  or
	 * {@link kOPERATOR_OR} and {@link kOPERATOR_NOR}, will be added at the same level. If
	 * the top level is an {@link kOPERATOR_OR} or {@link kOPERATOR_NOR} and the provided
	 * statement is an {@link kOPERATOR_AND} or {@link kOPERATOR_NAND}, the latter will be
	 * promoted to the top level.
	 *
	 * The parameters to this method are:
	 *
	 * <ul>
	 *	<li><tt>&$theQuery</tt>: Query receiving statement.
	 *	<li><tt>$theCondition</tt>: Statement condition.
	 *	<li><tt>$theCondition</tt>: Boolean statement condition code.
	 * </ul>
	 *
	 * @param reference		   &$theQuery				Query.
	 * @param array				$theCondition			Statement condition.
	 * @param string			$theStatement			Statement.
	 *
	 * @access protected
	 */
	protected function _AppendStatement( &$theQuery, $theCondition, $theStatement )
	{
		//
		// Handle same condition.
		//
		if( array_key_exists( $theCondition, $theQuery ) )
			$theQuery[ $theCondition ][] = $theStatement;
		
		//
		// Handle different condition.
		//
		else
		{
			//
			// Get current query top condition.
			//
			$top_condition = key( $theQuery );
			
			//
			// Promote condition.
			//
			if( ( ($top_condition == kOPERATOR_OR)
			   || ($top_condition == kOPERATOR_NOR) )
			 && ( ($theCondition == kOPERATOR_AND)
			   || ($theCondition == kOPERATOR_NAND) ) )
			{
				//
				// Provided condition is AND.
				//
				if( $theCondition == kOPERATOR_AND )
				{
					//
					// Create condition statement.
					//
					$condition = array( $theCondition => array( $theStatement ) );
		
					//
					// Append to provided condition the existing condition.
					//
					$condition[ $theCondition ][] = $theQuery;
				
				} // Provided condition is AND.
				
				//
				// Provided condition is NAND.
				//
				else
				{
					//
					// Append existing OR statement to new AND condition.
					//
					$condition = array( kOPERATOR_AND => array( $theQuery ) );
					
					//
					// Append NAND condition to query.
					//
					$condition[ $theCondition ] = array( $theStatement );
				
				} // Provided condition is NAND.
				
				//
				// Update query.
				//
				$theQuery = $condition;
			
			} // Promoted statement.
			
			//
			// Traverse conditions.
			//
			else
			{
				//
				// Handle same top level condition type.
				//
				if( ( ( ($top_condition == kOPERATOR_AND)
					 || ($top_condition == kOPERATOR_NAND) )
				   && ( ($theCondition == kOPERATOR_AND)
					 || ($theCondition == kOPERATOR_NAND) ) )
				 || ( ( ($top_condition == kOPERATOR_OR)
					 || ($top_condition == kOPERATOR_NOR) )
				   && ( ($theCondition == kOPERATOR_OR)
					 || ($theCondition == kOPERATOR_NOR) ) ) )
					$theQuery[ $theCondition ] = array( $theStatement );
				
				//
				// Append statement in new level.
				// Note: At this point we know that the top condition is
				// an AND or NAND and that the condition to be added is
				// an OR or NOR.
				//
				else
				{
					//
					// Check if we have a top AND condition.
					//
					if( array_key_exists( kOPERATOR_AND, $theQuery ) )
					{
						//
						// Iterate AND statements.
						//
						foreach( $theQuery[ kOPERATOR_AND ] as & $tmp )
						{
							//
							// Match nested condition.
							//
							if( array_key_exists( $theCondition, $tmp ) )
							{
								//
								// Append to nested condition.
								//
								$tmp[ $theCondition ][] = $theStatement;
								
								return;												// ==>
							
							} // Matched nested condition.
						
						} // Iterating AND statements.
					
					} // Query has an AND condition.
					
					//
					// Create top AND condition and append statement to it.
					//
					$theQuery[ kOPERATOR_AND ][]
						= array( $theCondition => array( $theStatement ) );
				
				} // Create new level.
			
			} // Condition not promoted.
		
		} // Different condition.
	
	} // _AppendStatement.

	 

/*=======================================================================================
 *																						*
 *								PROTECTED VALIDATION INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_ValidateCondition																*
	 *==================================================================================*/

	/**
	 * <h4>Validate condition</h4>
	 *
	 * This method expects a condition as its argument, it will check if it is a valid
	 * condition, then it will validate all condition statements.
	 *
	 * @param string				$theCondition			Boolean condition.
	 * @param array					$theStatements			Statements list.
	 * @param integer				$theLevel				[PRIVATE] condition level.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses _ValidateStatement()
	 */
	protected function _ValidateCondition( $theCondition, $theStatements, $theLevel )
	{
		//
		// Check condition.
		//
		switch( $theCondition )
		{
			case kOPERATOR_AND:
			case kOPERATOR_NAND:
			case kOPERATOR_OR:
			case kOPERATOR_NOR:
				
				//
				// Check statements list type.
				//
				if( ! is_array( $theStatements ) )
					throw new Exception
						( "Invalid query: condition has no statements",
						  kERROR_MISSING );										// !@! ==>
				
				//
				// Validate statements.
				//
				foreach( $theStatements as $key => $statement )
					$this->_ValidateStatement( $statement, $theLevel );
				
				
				break;
			
			default:
				
				//
				// Unsupported condition.
				//
				throw new Exception
					( "Invalid query: unsupported condition",
					  kERROR_UNSUPPORTED );										// !@! ==>
		
		} // Checking condition.
	
	} // _ValidateCondition.

	 
	/*===================================================================================
	 *	_ValidateStatement																*
	 *==================================================================================*/

	/**
	 * <h4>Validate statement</h4>
	 *
	 * This method expects a statement as its argument, it will check if it is a valid
	 * statement and check if all required elements are there.
	 *
	 * @param array					$theStatement			Statement.
	 * @param integer				$theLevel				[PRIVATE] condition level.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses _ValidateCondition()
	 */
	protected function _ValidateStatement( $theStatement, $theLevel )
	{
		//
		// Check statement data type.
		//
		if( (! is_array( $theStatement ))
		 && (! $theStatement instanceof CQueryStatement) )
			throw new Exception
				( "Invalid query statement",
				  kERROR_STATE );												// !@! ==>

		//
		// Parse by statement index.
		//
		switch( $condition = key( $theStatement ) )
		{
			case kOPERATOR_AND:
			case kOPERATOR_NAND:
			case kOPERATOR_OR:
			case kOPERATOR_NOR:
				$this->_ValidateCondition( $condition, $theStatement, $theLevel + 1 );
				break;
			
			default:
			
				//
				// Check statement operator.
				//
				if( array_key_exists( kOFFSET_QUERY_OPERATOR, $theStatement ) )
				{
					//
					// Parse by operator.
					//
					switch( $theStatement[ kOFFSET_QUERY_OPERATOR ] )
					{
						case kOPERATOR_DISABLED:
							break;
					
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
						case kOPERATOR_IN:
						case kOPERATOR_NI:
						case kOPERATOR_ALL:
						case kOPERATOR_NALL:
							if( ! array_key_exists( kOFFSET_QUERY_TYPE, $theStatement ) )
								throw new Exception
									( "Invalid query: missing filter match data type",
									  kERROR_MISSING );							// !@! ==>
						case kOPERATOR_EX:
							if( ! array_key_exists( kOFFSET_QUERY_DATA, $theStatement ) )
								throw new Exception
									( "Invalid query: missing filter data",
									  kERROR_MISSING );							// !@! ==>
						
						case kOPERATOR_NULL:
						case kOPERATOR_NOT_NULL:
							if( ! array_key_exists( kOFFSET_QUERY_SUBJECT, $theStatement ) )
								throw new Exception
									( "Invalid query: missing subject in statement",
									  kERROR_MISSING );							// !@! ==>
							break;
						
						default:
							throw new Exception
								( "Invalid query: unsupported operator",
								  kERROR_UNSUPPORTED )					;		// !@! ==>
					
					} // Parsing by operator.
				
				} // Has operator.
				
				//
				// Handle missing statement.
				//
				else
					throw new Exception
						( "Invalid query: missing operator in statement",
						  kERROR_MISSING );										// !@! ==>
				
				break;
		
		} // Parsing statement index.
		
	} // _ValidateStatement.
		


/*=======================================================================================
 *																						*
 *								PROTECTED STATUS INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_Ready																			*
	 *==================================================================================*/

	/**
	 * <h4>Determine if the object is ready</h4>
	 *
	 * In this class the method will return <tt>TRUE</tt> if the current object has at least
	 * one offset set, an indication that it holds a query.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> means {@link _IsInited( <tt>TRUE</tt> ).
	 */
	protected function _Ready()						{	return (boolean) $this->count();	}

	 

} // class CQuery.


?>
