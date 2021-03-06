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
 * <h4>Query</h4>
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
 *				<li><i>{@link kTYPE_DATE_STRING}</i>: A date.
 *				<li><i>{@link kTYPE_TIME_STRING}</i>: A date and time.
 *				<li><i>{@link kTYPE_STAMP}</i>: A native timestamp.
 *				<li><i>{@link kTYPE_BOOLEAN}</i>: An <tt>on</tt>/<tt>off</tt> switch.
 *				<li><i>{@link kTYPE_BINARY_STRING}</i>: A binary string.
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
	 * This method will append the provided statement or query to the current query.
	 *
	 * The first parameter is expected to be either a single statement or a query which is
	 * represented by a collection of statements chained by a condition.
	 *
	 * The method expects the first parameter to be either an object derived from
	 * {@link CQueryStatement}, an object derived from this class or an array.
	 *
	 * If the current key of the provided statement matches one of the standard conditions
	 * ({@link kOPERATOR_AND}, {@link kOPERATOR_NAND}, {@link kOPERATOR_OR} or
	 * {@link kOPERATOR_NOR}), it is assumed that the provided statement is a <i>query</i>;
	 * if that is not the case, it is assumed that the provided statement is a single or
	 * collection of <i>statements</i>.
	 *
	 * <ul>
	 *	<li><i>Statement</i>: The provided statement will be appended to the current query;
	 *		see the {@link _HandleStatement()} method for more details.
	 *	 <ul>
	 *		<li><i>Condition provided</i>:
	 *		 <ul>
	 *			<li><i>Current query is empty</i>: The statement and the condition will
	 *				become the current query.
	 *			<li><i>Current query is not empty</i>: The statement will be appended to the
	 *				current query using the provided condition.
	 *		 </ul>
	 *		<li><i>Condition not provided</i>: The condition will be determined:
	 *		 <ul>
	 *			<li><i>Current query is empty</i>: The condition will default to
	 *				{@link kOPERATOR_AND}.
	 *			<li><i>Current query is not empty</i>: The current query condition will be
	 *				used.
	 *		 </ul>
	 *	 </ul>
	 *	<li><i>Query</i>: The provided query will be chained to the current query; see the
	 *		{@link _HandleCondition()} method for more details.
	 *	 <ul>
	 *		<li><i>Condition provided</i>:
	 *		 <ul>
	 *			<li><i>Current query is empty</i>: The provided query will become the
	 *				current query and the provided condition will be ignored.
	 *			<li><i>Current query is not empty</i>: The provided query will be chained to
	 *				the current query using the provided condition.
	 *		 </ul>
	 *		<li><i>Condition not provided</i>:
	 *		 <ul>
	 *			<li><i>Current query is empty</i>: The provided query will become the
	 *				current query.
	 *			<li><i>Current query is not empty</i>: The current query condition will be
	 *				used.
	 *		 </ul>
	 *	 </ul>
	 * </ul>
	 *
	 * This method makes use of two protected method for doing the dirty job:
	 * {@link _HandleCondition()} for queries and {@link _HandleStatement()} for statements.
	 *
	 * <i>Note: Try not to mix {@link kOPERATOR_OR} with {@link kOPERATOR_NOR} or
	 * {@link kOPERATOR_AND} and {@link kOPERATOR_NAND} when adding queries, the methods
	 * that join queries do not yet handle these combinations well: only mix them when
	 * adding statements.</i>
	 *
	 * @param array					$theStatement		Statement.
	 * @param string				$theCondition		Statement condition.
	 *
	 * @access public
	 */
	public function AppendStatement( $theStatement, $theCondition = NULL )
	{
		//
		// Normalise statement.
		//
		if( $theStatement instanceof ArrayObject )
			$theStatement = $theStatement->getArrayCopy();
		
		//
		// Validate statement type.
		//
		if( ! is_array( $theStatement ) )
			throw new Exception
				( "Unsupported statement data type",
				  kERROR_PARAMETER );											// !@! ==>
		
		//
		// Parse by statement key.
		//
		reset( $theStatement );
		switch( (string) key( $theStatement ) )
		{
			//
			// Handle query.
			//
			case kOPERATOR_OR:
			case kOPERATOR_NOR:
			case kOPERATOR_AND:
			case kOPERATOR_NAND:
				
				//
				// Handle empty query.
				//
				if( ! $this->_Ready() )
					$this->exchangeArray( $theStatement );
				
				//
				// Chain query.
				//
				else
				{
					//
					// Normalise condition.
					//
					if( $theCondition === NULL )
						$theCondition = key( $this->getArrayCopy() );
					
					//
					// Handle query.
					//
					$this->_HandleCondition( $theStatement, $theCondition );
				
				} // Current query not empty.
				
				break;
			
			//
			// Handle statement.
			//
			default:
			
				//
				// Normalise condition.
				//
				if( $theCondition === NULL )
					$theCondition = ( $this->_Ready() )
								  ? key( $this->getArrayCopy() )
								  : kOPERATOR_AND;
				
				//
				// Handle statement.
				//
				$this->_HandleStatement( $theStatement, $theCondition );
				
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
	 *	_HandleCondition																*
	 *==================================================================================*/

	/**
	 * <h4>Handle condition</h4>
	 *
	 * This method will chain the provided query to the current query, it expects the first
	 * parameter to be a query array and the second parameter to be the condition that will
	 * be used to chain the provided query to the current query.
	 *
	 * The process of combining queries is governed by a set of three conditions: the
	 * <i>current</i> query condition, the <i>provided</i> condition and the
	 * <i>statement</i> condition. These conditions are compared as follows: 
	 *
	 * <ul>
	 *	<li><tt>{@link kOPERATOR_OR}</tt> is equivalent to <tt>{@link kOPERATOR_NOR}</tt>.
	 *	<li><tt>{@link kOPERATOR_AND}</tt> is equivalent to <tt>{@link kOPERATOR_NAND}</tt>.
	 * </ul>
	 *
	 * Depending on the combination of these three conditions:
	 *
	 * <ul>
	 *	<li><i>current</i> = <i>provided</i> = <i>statement</i>: The provided query
	 *		statements are recursively sent to the {@link AppendStatement()} method using
	 *		the condition of the provided <i>statement</i>.
	 *	<li><i>current</i> = <i>provided</i>: The provided query is appended to the current
	 *		query.
	 *	<li><i>current</i> = <i>statement</i>: A new empty query is created by appending
	 *		the old current query and the provided query using the provided condition.
	 *	<li><i>provided</i> = <i>statement</i>: The current query is appended to the
	 *		provided query.
	 * </ul>
	 *
	 * @param array					$theQuery			Query.
	 * @param string				$theCondition		Query condition.
	 *
	 * @access protected
	 */
	protected function _HandleCondition( $theQuery, $theCondition )
	{
		//
		// Init local storage.
		//
		$provided = (string) key( $theQuery );				// Provided query condition.
		$current = (string) key( $this->getArrayCopy() );	// Current query condition.
		switch( $theCondition )
		{
			case kOPERATOR_OR:
			case kOPERATOR_NOR:
			case kOPERATOR_AND:
			case kOPERATOR_NAND:
				break;
			
			default:
				throw new Exception
					( "Invalid condition",
					  kERROR_PARAMETER );										// !@! ==>
		}
		
		//
		// Serialise.
		//
		if( ( ( ($current == kOPERATOR_OR)
			 || ($current == kOPERATOR_NOR) )
		   && ( ($theCondition == kOPERATOR_OR)
		   	 || ($theCondition == kOPERATOR_NOR) )
		   && ( ($provided == kOPERATOR_OR)
		   	 || ($provided == kOPERATOR_NOR) ) )
		 || ( ( ($current == kOPERATOR_AND)
			 || ($current == kOPERATOR_NAND) )
		   && ( ($theCondition == kOPERATOR_AND)
		   	 || ($theCondition == kOPERATOR_NAND) )
		   && ( ($provided == kOPERATOR_AND)
		   	 || ($provided == kOPERATOR_NAND) ) ) )
		{
			//
			// Use provided query.
			//
			foreach( $theQuery as $condition => $statements )
			{
				//
				// Iterate query statements.
				//
				foreach( $statements as $statement )
					$this->AppendStatement( $statement, $condition );
		
			} // Used provided query.
		
		} // Serialise statements.
		
		//
		// Append provided query to current query.
		//
		elseif( ( ( ($current == kOPERATOR_OR)
				 || ($current == kOPERATOR_NOR) )
			   && ( ($theCondition == kOPERATOR_OR)
				 || ($theCondition == kOPERATOR_NOR) ) )
			 || ( ( ($current == kOPERATOR_AND)
				 || ($current == kOPERATOR_NAND) )
			   && ( ($theCondition == kOPERATOR_AND)
				 || ($theCondition == kOPERATOR_NAND) ) ) )
		{
			//
			// Get current query.
			//
			$tmp = $this->getArrayCopy();
			
			//
			// Append query.
			//
			$tmp[ $current ][] = $theQuery;
			
			//
			// Update current object.
			//
			$this->exchangeArray( $tmp );
		
		} // Append provided query.
		
		//
		// Join current and provided queries with provided condition.
		//
		elseif( ( ( ($current == kOPERATOR_OR)
				 || ($current == kOPERATOR_NOR) )
			   && ( ($provided == kOPERATOR_OR)
				 || ($provided == kOPERATOR_NOR) ) )
			 || ( ( ($current == kOPERATOR_AND)
				 || ($current == kOPERATOR_NAND) )
			   && ( ($provided == kOPERATOR_AND)
				 || ($provided == kOPERATOR_NAND) ) ) )
		{
			//
			// Get current query.
			//
			$tmp = $this->getArrayCopy();
			
			//
			// Create new query.
			//
			$tmp = array( $theCondition => array( $tmp, $theQuery ) );
			
			//
			// Update current object.
			//
			$this->exchangeArray( $tmp );
		
		} // Append provided to current with condition.
		
		//
		// Append current query to provided query.
		//
		else
		{
			//
			// Get current query.
			//
			$tmp = $this->getArrayCopy();
			
			//
			// Append query.
			//
			$theQuery[ $provided ][] = $tmp;
			
			//
			// Update current object.
			//
			$this->exchangeArray( $theQuery );
		
		} // Append current query.
	
	} // _HandleCondition.

	 
	/*===================================================================================
	 *	_HandleStatement																*
	 *==================================================================================*/

	/**
	 * <h4>Handle statement</h4>
	 *
	 * This method will append the provided statement to the current query, it will handle
	 * the provided statement as a single scalar statement.
	 *
	 * @param array					$theStatement		Statement.
	 * @param string				$theCondition		Statement condition.
	 *
	 * @access protected
	 */
	protected function _HandleStatement( $theStatement, $theCondition )
	{
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
	
	} // _HandleStatement.

	 
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
			$top_condition = (string) key( $theQuery );
			
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
					( "Invalid query: unsupported condition [$theCondition]",
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
		switch( $condition = (string) key( $theStatement ) )
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
					$this->_ValidateStatementOperator( $theStatement );
				
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

	 
	/*===================================================================================
	 *	_ValidateStatementOperator														*
	 *==================================================================================*/

	/**
	 * <h4>Validate statement operator</h4>
	 *
	 * This method expects the statement reference, it will raise an exception if the operator
	 * is not supported and if the statement is missing required properties according to
	 * the operator.
	 *
	 * @param reference			   &$theStatement			Statement.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 */
	protected function _ValidateStatementOperator( &$theStatement )
	{
		//
		// Check for operator.
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
							  kERROR_MISSING );									// !@! ==>
				case kOPERATOR_EX:
					if( ! array_key_exists( kOFFSET_QUERY_DATA, $theStatement ) )
						throw new Exception
							( "Invalid query: missing filter data",
							  kERROR_MISSING );									// !@! ==>
			
				case kOPERATOR_NULL:
				case kOPERATOR_NOT_NULL:
					if( ! array_key_exists( kOFFSET_QUERY_SUBJECT, $theStatement ) )
						throw new Exception
							( "Invalid query: missing subject in statement",
							  kERROR_MISSING );									// !@! ==>
					break;
			
				default:
					throw new Exception
						( "Invalid query: unsupported operator",
						  kERROR_UNSUPPORTED )					;				// !@! ==>
		
			} // Parsing by operator.
		
		} // Has operator.
		
	} // _ValidateStatementOperator.
		


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
