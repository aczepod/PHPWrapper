<?php

/**
 * Compile ISO codes.
 *
 * This file contains the routine to compile the ISO codes from the iso-codes brew package..
 *
 *	@package	MyWrapper
 *	@subpackage	Data
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 10/10/2012
 */

/*=======================================================================================
 *																						*
 *										ISOCodes.php									*
 *																						*
 *======================================================================================*/

//
// Local includes.
//
require_once( 'ISOCodes.inc.php' );

//
// File functions.
//
require_once( kPATH_MYWRAPPER_LIBRARY_FUNCTION.'/file.php' );

//
// Parser functions.
//
require_once( kPATH_MYWRAPPER_LIBRARY_FUNCTION.'/parsing.php' );

		

/*=======================================================================================
 *																						*
 *										FUNCTIONS										*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	ISODecodePOFiles																*
	 *==================================================================================*/

	/**
	 * <h4>Decode PO files</h4>
	 *
	 * This method will parse all MO files, decode them into PO files and write to the
	 * {@link kISO_FILE_PO_DIR} directory the PHP serialised decode array.
	 */
	function ISODecodePOFiles()
	{
		//
		// Init local storage.
		//
		$_SESSION[ kISO_LANGUAGES ] = Array();
		
		//
		// Init files list.
		// The order is important!!!
		//
		$_SESSION[ kISO_FILES ]
			= array( kISO_FILE_639_3, kISO_FILE_639, kISO_FILE_3166,
					 kISO_FILE_3166_2, kISO_FILE_4217, kISO_FILE_15924 );
		
		//
		// Point to MO files.
		//
		$_SESSION[ kISO_FILE_MO_DIR ] = kISO_CODES_PATH.kISO_CODES_PATH_LOCALE;
		$moditer = new DirectoryIterator( $_SESSION[ kISO_FILE_MO_DIR ] );

		//
		// Create temporary directory.
		//
		echo( "    - Decoding PO files\n" );
		$_SESSION[ kISO_FILE_PO_DIR ] = tempnam( sys_get_temp_dir(), '' );
		if( file_exists( $_SESSION[ kISO_FILE_PO_DIR ] ) )
			unlink( $_SESSION[ kISO_FILE_PO_DIR ] );
		mkdir( $_SESSION[ kISO_FILE_PO_DIR ] );
		if( ! is_dir( $_SESSION[ kISO_FILE_PO_DIR ] ) )
			throw new Exception
				( "Unable to create temporary PO directory",
				  kERROR_STATE );												// !@! ==>
		$_SESSION[ kISO_FILE_PO_DIR ]
			= realpath( $_SESSION[ kISO_FILE_PO_DIR ] );
		
		//
		// Iterate languages.
		//
		foreach( $moditer as $language )
		{
			//
			// Handle valid directories.
			//
			if( $language->isDir()
			 && (! $language->isDot()) )
			{
				//
				// Save language code.
				//
				$code = $language->getBasename();
				$_SESSION[ kISO_LANGUAGES ][] = $code;
				if( kOPTION_VERBOSE )
					echo( "      $code\n" );
				
				//
				// Create language directory.
				//
				$dir = $_SESSION[ kISO_FILE_PO_DIR ]."/$code";
				DeleteFileDir( $dir );
				mkdir( $dir );
				if( ! is_dir( $dir ) )
					throw new Exception
						( "Unable to create temporary language directory",
						  kERROR_STATE );										// !@! ==>
				
				//
				// Iterate files.
				//
				$mofiter = new DirectoryIterator
					( $language->getRealPath().kISO_CODES_PATH_MSG );
				foreach( $mofiter as $file )
				{
					//
					// Skip invisible files.
					//
					$name = $file->getBasename( '.mo' );
					if( ! $file->isDot()
					 && in_array( $name, $_SESSION[ kISO_FILES ] ) )
					{
						//
						// Create filenames.
						//
						$filename_po = realpath( $dir )."/$name.po";
						$filename_key = realpath( $dir )."/$name.serial";
						
						//
						// Convert to PO.
						//
						$source = $file->getRealPath();
						exec( "msgunfmt -o \"$filename_po\" \"$source\"" );
						
						//
						// Convert to key.
						//
						file_put_contents(
							$filename_key,
							serialize( PO2Array( $filename_po ) ) );
					
					} // Workable file.
				
				} // Iterating files.
			
			} // Valid directory.
		
		} // Iterating languages.
		
	} // ISODecodePOFiles.

	 
	/*===================================================================================
	 *	ISOParseXMLFiles																*
	 *==================================================================================*/

	/**
	 * <h4>Parse XML files</h4>
	 *
	 * This method will parse the XML files and store the data in the database.
	 */
	function ISOParseXMLFiles()
	{
		//
		// Iterate known fiels.
		//
		echo( "    - Parsing XML files\n" );
		foreach( $_SESSION[ kISO_FILES ] as $file )
		{
			//
			// Inform.
			//
			if( kOPTION_VERBOSE )
				echo( "      $file\n" );
				
			//
			// Parse by file.
			//
			switch( $file )
			{
				case kISO_FILE_639_3:
					ISOParse6393XML();
					break;
					
				case kISO_FILE_639:
					ISOParse639XML();
					break;
					
				case kISO_FILE_3166:
					ISOParse3166XML();
					break;
					
				case kISO_FILE_3166_2:
					ISOParse31662XML();
					break;
					
				case kISO_FILE_4217:
					ISOParse4217XML();
					break;
					
				case kISO_FILE_15924:
					ISOParse15924XML();
					break;
			}
		
		} // Iterating the files.
		
	} // ISOParseXMLFiles.

	 
	/*===================================================================================
	 *	ISOParse6393XML																	*
	 *==================================================================================*/

	/**
	 * <h4>Parse ISO 639-3 XML files</h4>
	 *
	 * This method will parse the XML ISO 639-3 files.
	 */
	function ISOParse6393XML()
	{
		//
		// Load XML file.
		//
		$xml = kISO_CODES_PATH.kISO_CODES_PATH_XML.'/'.kISO_FILE_639_3.'.xml';
		$xml = simplexml_load_file( $xml  );
		if( $xml instanceof SimpleXMLElement )
		{
			//
			// Init codes.
			//
			$scope_code
				= implode(
					kTOKEN_NAMESPACE_SEPARATOR,
					array( kONTOLOGY_ISO,
						   kONTOLOGY_ISO_639,
						   kONTOLOGY_ISO_639_3_scope ) );
			$type_code
				= implode(
					kTOKEN_NAMESPACE_SEPARATOR,
					array( kONTOLOGY_ISO,
						   kONTOLOGY_ISO_639,
						   kONTOLOGY_ISO_639_3_type ) );
			$status_code
				= implode(
					kTOKEN_NAMESPACE_SEPARATOR,
					array( kONTOLOGY_ISO,
						   kONTOLOGY_ISO_639,
						   kONTOLOGY_ISO_639_3_status ) );
			$inv_name_code
				= implode(
					kTOKEN_NAMESPACE_SEPARATOR,
					array( kONTOLOGY_ISO,
						   kONTOLOGY_ISO_639,
						   kONTOLOGY_ISO_639_3_INVNAME ) );
			$inv_name_lng_code
				= implode(
					kTOKEN_INDEX_SEPARATOR,
					array( $inv_name_code,
						   kPREDICATE_SUBCLASS_OF,
						   kOFFSET_LANGUAGE ) );
			$inv_name_str_code
				= implode(
					kTOKEN_INDEX_SEPARATOR,
					array( $inv_name_code,
						   kPREDICATE_SUBCLASS_OF,
						   kOFFSET_STRING ) );
			
			//
			// Load namespaces.
			//
			$part1_ns
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO,
							   kONTOLOGY_ISO_639,
							   kONTOLOGY_ISO_639_1 ) ),
					NULL,
					TRUE );
			$part2_ns
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO,
							   kONTOLOGY_ISO_639,
							   kONTOLOGY_ISO_639_2 ) ),
					NULL,
					TRUE );
			$part3_ns
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO,
							   kONTOLOGY_ISO_639,
							   kONTOLOGY_ISO_639_3 ) ),
					NULL,
					TRUE );
			
			//
			// Load predicates.
			//
			$pred_xref_exact
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					kPREDICATE_XREF_EXACT,
					NULL,
					TRUE );
			
			//
			// Load parent nodes.
			//
			$part1_parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode( $part1_ns, TRUE )[ 0 ];
			$part2_parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode( $part2_ns, TRUE )[ 0 ];
			$part3_parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode( $part3_ns, TRUE )[ 0 ];
			
			//
			// Load attribute tags.
			//
			$inv_name_tag
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTag(
					$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
						$inv_name_code,
						NULL,
						TRUE ),
					TRUE )[ 0 ];
			$inv_name_lng_tag
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTag(
					$inv_name_lng_code,
					TRUE );
			$inv_name_str_tag
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTag(
					$inv_name_str_code,
					TRUE );
			$status_tag
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTag(
					$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
						$status_code,
						NULL,
						TRUE ),
					TRUE )[ 0 ];
			$scope_tag
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTag(
					$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
						$scope_code,
						NULL,
						TRUE ),
					TRUE )[ 0 ];
			$type_tag
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTag(
					$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
						$type_code,
						NULL,
						TRUE ),
					TRUE )[ 0 ];

			//
			// Iterate XML file.
			//
			foreach( $xml->{'iso_639_3_entry'} as $record )
			{
				//
				// Init loop data.
				//
				$part1_term = $part2_term = $part3_term = NULL;
				
				//
				// Check part 3 term.
				//
				if( ($part3_term = $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm
					( (string) $record[ 'part3_code' ], $part3_ns ))
						=== NULL )
				{
					//
					// Init term.
					//
					$part3_term = new COntologyTerm();
					$part3_term->LID( (string) $record[ 'id' ] );
					$part3_term->NS( $part3_ns );
					if( $record[ 'name' ] !== NULL )
						$part3_term->Label( kDEFAULT_LANGUAGE,
											(string) $record[ 'name' ] );
					if( $record[ 'reference_name' ] !== NULL )
						$part3_term->Description( kDEFAULT_LANGUAGE,
												  (string) $record[ 'reference_name' ] );
					if( $record[ 'status' ] !== NULL )
						$part3_term[ $status_tag[ kOFFSET_NID ] ]
							= (string) $record[ 'status' ];
					if( $record[ 'scope' ] !== NULL )
					{
						if( strlen( $tmp = trim( (string) $record[ 'scope' ] ) ) )
						{
							switch( $tmp )
							{
								default:
									echo( "!!! Unknown scope [".(string) $tmp."] !!!\n" );
								case 'I':
								case 'M':
								case 'C':
								case 'D':
								case 'R':
								case 'S':
									$part3_term[ $scope_tag[ kOFFSET_NID ] ]
										= implode( kTOKEN_NAMESPACE_SEPARATOR,
												   array( $scope_code, $tmp ) );
									break;
								case 'L':
									$part3_term[ $scope_tag[ kOFFSET_NID ] ]
										= implode( kTOKEN_NAMESPACE_SEPARATOR,
												   array( $scope_code, 'R' ) );
									break;
							}
						}
					}
					if( $record[ 'type' ] !== NULL )
					{
						if( strlen( $tmp = trim( (string) $record[ 'type' ] ) ) )
						{
							switch( (string) $tmp )
							{
								default:
									echo( "!!! Unknown type [".(string) $tmp."] !!!\n" );
								case 'L':
								case 'E':
								case 'A':
								case 'H':
								case 'C':
								case 'S':
								case 'Genetic':
								case 'Genetic-like':
								case 'Geographic':
									$part3_term[ $type_tag[ kOFFSET_NID ] ]
										= implode( kTOKEN_NAMESPACE_SEPARATOR,
												   array( $type_code, $tmp ) );
									break;
								case 'Genetic, Ancient':
									$part3_term[ $type_tag[ kOFFSET_NID ] ]
										= array(
											implode( kTOKEN_NAMESPACE_SEPARATOR,
													 array( $type_code, 'Genetic' ) ),
											implode( kTOKEN_NAMESPACE_SEPARATOR,
													 array( $type_code, 'A' ) ) );
									break;
							}
						}
					}
					if( $record[ 'inverted_name' ] !== NULL )
						ManageTypedOffset( $part3_term,
							(string) $inv_name_tag[ kOFFSET_NID ],
							(string) $inv_name_lng_tag[ kOFFSET_NID ],
							(string) $inv_name_str_tag[ kOFFSET_NID ],
							kDEFAULT_LANGUAGE, (string) $record[ 'inverted_name' ] );
					
					//
					// Iterate languages.
					//
					foreach( $_SESSION[ kISO_LANGUAGES ] as $language )
					{
						//
						// Check language key file.
						//
						$file_path = $_SESSION[ kISO_FILE_PO_DIR ]."/$language/"
									.kISO_FILE_639_3.'.serial';
						if( is_file( $file_path ) )
						{
							//
							// Instantiate keys array.
							//
							$keys = unserialize( file_get_contents( $file_path ) );
							
							//
							// Update label.
							//
							if( ($string = $part3_term->Label( kDEFAULT_LANGUAGE ))
								!== NULL )
							{
								if( array_key_exists( $string, $keys ) )
									$part3_term->Label( $language, $keys[ $string ] );
							}
							
							//
							// Update description.
							//
							if( ($string = $part3_term->Description( kDEFAULT_LANGUAGE ))
								!== NULL )
							{
								if( array_key_exists( $string, $keys ) )
									$part3_term->Description( $language, $keys[ $string ] );
							}
							
							//
							// Update inverted name.
							//
							if( $part3_term->offsetExists(
								(string) $inv_name_tag[ kOFFSET_NID ] ) )
							{
								$string = ManageTypedOffset( $part3_term,
									(string) $inv_name_tag[ kOFFSET_NID ],
									(string) $inv_name_lng_tag[ kOFFSET_NID ],
									(string) $inv_name_str_tag[ kOFFSET_NID ],
									kDEFAULT_LANGUAGE );
								if( array_key_exists( $string, $keys ) )
									ManageTypedOffset($part3_term,
										(string) $inv_name_tag[ kOFFSET_NID ],
										(string) $inv_name_lng_tag[ kOFFSET_NID ],
										(string) $inv_name_str_tag[ kOFFSET_NID ],
										$language, $keys[ $string ] );
							}
						
						} // Key file exists.
					
					} // Iterating languages.
					
					//
					// Commit term.
					//
					$part3_term->Insert( $_SESSION[ kSESSION_ONTOLOGY ]->Connection() );
					
					//
					// Create node and relate to parent.
					//
					$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
						$part3_node
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
								$part3_term,
								array( kKIND_NODE_INSTANCE, kKIND_NODE_ENUMERATION ),
								kTYPE_STRING ),
						$part3_parent );
					
					//
					// Handle part 1 code.
					//
					if( $record[ 'part1_code' ] !== NULL )
					{
						//
						// Check term.
						//
						if( ($part1_term = $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm
							( (string) $record[ 'part1_code' ], $part1_ns ))
								=== NULL )
						{
							//
							// Slip deprecated.
							//
							if( (substr( (string) $record[ 'part1_code' ], 3 )
									!= '(deprecated)') )
							{
								//
								// Create term.
								//
								$part1_term = new COntologyTerm();
								$part1_term->LID(
									substr( (string) $record[ 'part1_code' ], 0, 2 ) );
								$part1_term->NS( $part1_ns );
								$part1_term->Term( $part3_term );					
								$part1_term->Insert( $_SESSION[ kSESSION_ONTOLOGY ]
														->Connection() );
								
								//
								// Create node and relate to parent.
								//
								$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
									$part1_node
										= $_SESSION[ kSESSION_ONTOLOGY ]
											->NewEnumerationNode( $part1_term ),
									$part1_parent );
							
							} // Not deprecated.
						
						} // New term.
						
						else
						{
							echo( "!!! part1[".(string) $record[ 'part1_code' ]."] !!!\n" );
						
							$part1_node
								= $_SESSION[ kSESSION_ONTOLOGY ]
									->ResolveNode( $part1_term, TRUE )[ 0 ];
						
						} // Existing term.
					
					} // Has part 1 code.
					
					//
					// Handle part 2 code.
					//
					if( $record[ 'part2_code' ] !== NULL )
					{
						//
						// Check term.
						//
						if( ($part2_term = $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm
							( (string) $record[ 'part2_code' ], $part2_ns ))
								=== NULL )
						{
							//
							// Create term.
							//
							$part2_term = new COntologyTerm();
							$part2_term->LID( (string) $record[ 'part2_code' ] );
							$part2_term->NS( $part2_ns );
							$part2_term->Term( $part3_term );					
							$part2_term->Insert(
								$_SESSION[ kSESSION_ONTOLOGY ]->Connection() );
							
							//
							// Create node and relate to parent.
							//
							$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
								$part2_node
									= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
										$part2_term ),
								$part2_parent );
						
						} // New term.
						
						else
						{
							echo( "!!! part2[".(string) $record[ 'part2_code' ]."] !!!\n" );
						
							$part2_node
								= $_SESSION[ kSESSION_ONTOLOGY ]
									->ResolveNode( $part2_term, TRUE )[ 0 ];
						
						} // Existing term.
					
					} // Has part 2 code.
					
					//
					// Create cross-references.
					//
					if( $part1_term !== NULL )
					{
						//
						// Cross reference part 3 and 1.
						//
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$part1_node, $part3_node, $pred_xref_exact );
					
						//
						// Cross reference part 1 and 3.
						//
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$part3_node, $part1_node, $pred_xref_exact );
						
						//
						// Create cross-references.
						//
						if( $part2_term !== NULL )
						{
							//
							// Cross reference part 2 and 3.
							//
							$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
								$part2_node, $part3_node, $pred_xref_exact );
						
							//
							// Cross reference part 3 and 2.
							//
							$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
								$part3_node, $part2_node, $pred_xref_exact );
						
							//
							// Cross reference part 1 and 2.
							//
							$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
								$part1_node, $part2_node, $pred_xref_exact );
						
							//
							// Cross reference part 2 and 1.
							//
							$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
								$part2_node, $part1_node, $pred_xref_exact );
						
						} // Has part 1 code.
					
					} // Has part 1 code.
					
					//
					// Create cross-references.
					//
					elseif( $part2_term !== NULL )
					{
						//
						// Cross reference part 2 and 3.
						//
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$part2_node, $part3_node, $pred_xref_exact );
					
						//
						// Cross reference part 3 and 2.
						//
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$part3_node, $part2_node, $pred_xref_exact );
					
					} // Has part 2 code only.
				
				} // New part 3 term.
				
				else
					echo( "!!! part3[".(string) $record[ 'id' ]."] !!!\n" );
			
			} // Iterating records.
		
		} // Loaded file.

	} // ISOParse6393XML.

	 
	/*===================================================================================
	 *	ISOParse639XML																	*
	 *==================================================================================*/

	/**
	 * <h4>Parse ISO 639 XML files</h4>
	 *
	 * This method will parse the XML ISO 639 files.
	 */
	function ISOParse639XML()
	{
		//
		// Load XML file.
		//
		$xml = kISO_CODES_PATH.kISO_CODES_PATH_XML.'/'.kISO_FILE_639.'.xml';
		$xml = simplexml_load_file( $xml  );
		if( $xml instanceof SimpleXMLElement )
		{
			//
			// Load namespaces.
			//
			$part1_ns
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO,
							   kONTOLOGY_ISO_639,
							   kONTOLOGY_ISO_639_1 ) ),
					NULL,
					TRUE );
			$part2b_ns
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO,
							   kONTOLOGY_ISO_639,
							   kONTOLOGY_ISO_639_2B ) ),
					NULL,
					TRUE );
			$part2t_ns
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO,
							   kONTOLOGY_ISO_639,
							   kONTOLOGY_ISO_639_2T ) ),
					NULL,
					TRUE );
			
			//
			// Load predicates.
			//
			$pred_xref_exact
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					kPREDICATE_XREF_EXACT,
					NULL,
					TRUE );
			
			//
			// Load parent nodes.
			//
			$part2b_parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode( $part2b_ns, TRUE )[ 0 ];
			$part2t_parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode( $part2t_ns, TRUE )[ 0 ];
			
			//
			// Iterate XML file.
			//
			foreach( $xml->{'iso_639_entry'} as $record )
			{
				//
				// Init loop data.
				//
				$part1_term = $part2b_term = $part2t_term = NULL;
				
				//
				// Handle part 1 term.
				//
				if( $record[ 'iso_639_1_code' ] !== NULL )
					$part1_node
						= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode(
							$part1_term
								= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
									(string) $record[ 'iso_639_1_code' ], $part1_ns,
									NULL,
									TRUE ),
							TRUE )[ 0 ];
				
				//
				// Handle part 2b term.
				//
				if( $record[ 'iso_639_2B_code' ] !== NULL )
				{
					//
					// Resolve term.
					//
					$part2b_term
						= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
							(string) $record[ 'iso_639_2B_code' ], $part2b_ns );
					
					//
					// Create term.
					//
					if( $part2b_term === NULL )
					{
						//
						// Initialise term.
						//
						$part2b_term = new COntologyTerm();
						$part2b_term->LID( (string) $record[ 'iso_639_2B_code' ] );
						$part2b_term->NS( $part2b_ns );
						if( $record[ 'name' ] !== NULL )
							$part2b_term->Label( kDEFAULT_LANGUAGE,
												 (string) $record[ 'name' ] );
						
						//
						// Iterate language files.
						//
						foreach( $_SESSION[ kISO_LANGUAGES ] as $language )
						{
							//
							// Check language key file.
							//
							$file_path = $_SESSION[ kISO_FILE_PO_DIR ]."/$language/"
										.kISO_FILE_639.'.serial';
							if( is_file( $file_path ) )
							{
								//
								// Instantiate keys array.
								//
								$keys = unserialize( file_get_contents( $file_path ) );
								
								//
								// Update label.
								//
								if( ($string = $part2b_term->Label( kDEFAULT_LANGUAGE ))
									!== NULL )
								{
									if( array_key_exists( $string, $keys ) )
										$part2b_term->Label( $language, $keys[ $string ] );
								}
							
							} // Key file exists.
						
						} // Iterating languages.
						
						//
						// Commit term.
						//
						$part2b_term->Insert(
							$_SESSION[ kSESSION_ONTOLOGY ]->Connection() );
						
						//
						// Create and relate term.
						//
						$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
							$part2b_node
								= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
									$part2b_term ),
							$part2b_parent );
					
					} // New term.
					
					else
						$part2b_node
							= $_SESSION[ kSESSION_ONTOLOGY ]
								->ResolveNode( $part2b_term, TRUE )[ 0 ];
				
				} // Provided part 2b code.
				
				//
				// Handle part 2t term.
				//
				if( $record[ 'iso_639_2T_code' ] !== NULL )
				{
					//
					// Resolve term.
					//
					$part2t_term
						= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
							(string) $record[ 'iso_639_2T_code' ], $part2t_ns );
					
					//
					// Create term.
					//
					if( $part2t_term === NULL )
					{
						//
						// Initialise term.
						//
						$part2t_term = new COntologyTerm();
						$part2t_term->LID( (string) $record[ 'iso_639_2T_code' ] );
						$part2t_term->NS( $part2t_ns );
						$part2t_term->Label( kDEFAULT_LANGUAGE,
											 (string) $record[ 'name' ] );
						
						//
						// Iterate language files.
						//
						foreach( $_SESSION[ kISO_LANGUAGES ] as $language )
						{
							//
							// Check language key file.
							//
							$file_path = $_SESSION[ kISO_FILE_PO_DIR ]."/$language/"
										.kISO_FILE_639.'.serial';
							if( is_file( $file_path ) )
							{
								//
								// Instantiate keys array.
								//
								$keys = unserialize( file_get_contents( $file_path ) );
								
								//
								// Update label.
								//
								if( ($string = $part2t_term->Label( kDEFAULT_LANGUAGE ))
									!== NULL )
								{
									if( array_key_exists( $string, $keys ) )
										$part2t_term->Label( $language, $keys[ $string ] );
								}
							
							} // Key file exists.
						
						} // Iterating languages.
						
						//
						// Commit term.
						//
						$part2t_term->Insert(
							$_SESSION[ kSESSION_ONTOLOGY ]->Connection() );
						
						//
						// Create and relate term.
						//
						$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
							$part2t_node
								= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
									$part2t_term ),
							$part2t_parent );
					
					} // New term.
					
					else
						$part2t_node
							= $_SESSION[ kSESSION_ONTOLOGY ]
								->ResolveNode( $part2t_term, TRUE )[ 0 ];
				
				} // Provided part 2t code.
				
				//
				// Relate to part 1.
				//
				if( $part1_term !== NULL )
				{
					//
					// Cross reference part 2b and 1.
					//
					if( $part2b_term !== NULL )
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$part2b_node, $part1_node, $pred_xref_exact );
				
					//
					// Cross reference part 2t and 1.
					//
					if( $part2t_term !== NULL )
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$part2t_node, $part1_node, $pred_xref_exact );
				
				} // Provided part 1 code.
				
				//
				// Relate part 2b.
				//
				if( $part2b_term !== NULL )
				{
					//
					// Cross reference part 2b and 2t.
					//
					if( $part2t_term !== NULL )
					{
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$part2b_node, $part2t_node, $pred_xref_exact );
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$part2t_term, $part2b_node, $pred_xref_exact );
					}
				
				} // Provided part 2b code.
				
				//
				// Relate part 2t.
				//
				if( $part2t_term !== NULL )
				{
					//
					// Cross reference part 2b and 2t.
					//
					if( $part2b_term !== NULL )
					{
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$part2t_term, $part2b_term, $pred_xref_exact );
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$part2b_term, $part2t_term, $pred_xref_exact );
					}
				
				} // Provided part 2t code.
			
			} // Iterating records.
		
		} // Loaded file.
		
	} // ISOParse639XML.

	 
	/*===================================================================================
	 *	ISOParse3166XML																	*
	 *==================================================================================*/

	/**
	 * <h4>Parse ISO 3166-1 and 3166-3 XML file</h4>
	 *
	 * This method will parse the XML ISO 3166-1 and 3166-3 file.
	 */
	function ISOParse3166XML()
	{
		//
		// Load XML file.
		//
		$xml = kISO_CODES_PATH.kISO_CODES_PATH_XML.'/'.kISO_FILE_3166.'.xml';
		$xml = simplexml_load_file( $xml  );
		if( $xml instanceof SimpleXMLElement )
		{
			//
			// Init codes.
			//
			$part1_common_name_code
				= implode(
					kTOKEN_NAMESPACE_SEPARATOR,
					array( kONTOLOGY_ISO,
						   kONTOLOGY_ISO_3166,
						   kONTOLOGY_ISO_3166_1,
						   kONTOLOGY_ISO_3166_1_COMMON_NAME ) );
			$part1_common_name_lng_code
				= implode(
					kTOKEN_INDEX_SEPARATOR,
					array( $part1_common_name_code,
						   kPREDICATE_SUBCLASS_OF,
						   kOFFSET_LANGUAGE ) );
			$part1_common_name_str_code
				= implode(
					kTOKEN_INDEX_SEPARATOR,
					array( $part1_common_name_code,
						   kPREDICATE_SUBCLASS_OF,
						   kOFFSET_STRING ) );
			
			//
			// Load namespaces.
			//
			$part1_2_ns
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO,
							   kONTOLOGY_ISO_3166,
							   kONTOLOGY_ISO_3166_1,
							   kONTOLOGY_ISO_3166_1_ALPHA2 ) ),
					NULL,
					TRUE );
			$part1_3_ns
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO,
							   kONTOLOGY_ISO_3166,
							   kONTOLOGY_ISO_3166_1,
							   kONTOLOGY_ISO_3166_1_ALPHA3 ) ),
					NULL,
					TRUE );
			$part1_n_ns
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO,
							   kONTOLOGY_ISO_3166,
							   kONTOLOGY_ISO_3166_1,
							   kONTOLOGY_ISO_3166_1_NUMERIC ) ),
					NULL,
					TRUE );
			$part3_2_ns
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO,
							   kONTOLOGY_ISO_3166,
							   kONTOLOGY_ISO_3166_3,
							   kONTOLOGY_ISO_3166_3_ALPHA2 ) ),
					NULL,
					TRUE );
			$part3_3_ns
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO,
							   kONTOLOGY_ISO_3166,
							   kONTOLOGY_ISO_3166_3,
							   kONTOLOGY_ISO_3166_3_ALPHA3 ) ),
					NULL,
					TRUE );
			$part3_4_ns
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO,
							   kONTOLOGY_ISO_3166,
							   kONTOLOGY_ISO_3166_3,
							   kONTOLOGY_ISO_3166_3_ALPHA4 ) ),
					NULL,
					TRUE );
			$part3_n_ns
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO,
							   kONTOLOGY_ISO_3166,
							   kONTOLOGY_ISO_3166_3,
							   kONTOLOGY_ISO_3166_3_NUMERIC ) ),
					NULL,
					TRUE );
			
			//
			// Load predicates.
			//
			$pred_xref_exact
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					kPREDICATE_XREF_EXACT,
					NULL,
					TRUE );
			
			//
			// Load parent nodes.
			//
			$part1_2_parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode( $part1_2_ns, TRUE )[ 0 ];
			$part1_3_parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode( $part1_3_ns, TRUE )[ 0 ];
			$part1_n_parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode( $part1_n_ns, TRUE )[ 0 ];
			$part3_2_parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode( $part3_2_ns, TRUE )[ 0 ];
			$part3_3_parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode( $part3_3_ns, TRUE )[ 0 ];
			$part3_4_parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode( $part3_4_ns, TRUE )[ 0 ];
			$part3_n_parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode( $part3_n_ns, TRUE )[ 0 ];
			
			//
			// Load attribute tags.
			//
			$part1_common_name_tag
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTag(
					$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
						$part1_common_name_code,
						NULL,
						TRUE ),
					TRUE )[ 0 ];
			$part1_common_name_lng_tag
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTag(
					$part1_common_name_lng_code,
					TRUE );
			$part1_common_name_str_tag
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTag(
					$part1_common_name_str_code,
					TRUE );
			$part3_date_tag
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTag(
					$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
						implode(
							kTOKEN_NAMESPACE_SEPARATOR,
							array( kONTOLOGY_ISO,
								   kONTOLOGY_ISO_3166,
								   kONTOLOGY_ISO_3166_3,
								   kONTOLOGY_ISO_3166_3_DATE_WITHDRAWN ) ),
						NULL,
						TRUE ),
					TRUE )[ 0 ];

			//
			// Iterate 3166-1 XML elements.
			//
			foreach( $xml->{'iso_3166_entry'} as $record )
			{
				//
				// Init loop data.
				//
				$part1_3_term = $part1_2_term = $part1_n_term = NULL;
				
				//
				// Load alpha-3 term.
				//
				if( ($part1_3_term = $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm
					( (string) $record[ 'alpha_3_code' ], $part1_3_ns ))
						=== NULL )
				{
					//
					// Init term.
					//
					$part1_3_term = new COntologyTerm();
					$part1_3_term->LID( (string) $record[ 'alpha_3_code' ] );
					$part1_3_term->NS( $part1_3_ns );
					if( $record[ 'name' ] !== NULL )
						$part1_3_term->Label( kDEFAULT_LANGUAGE,
											  (string) $record[ 'name' ] );
					if( $record[ 'official_name' ] !== NULL )
						$part1_3_term->Description( kDEFAULT_LANGUAGE,
													(string) $record[ 'official_name' ] );
					if( $record[ 'common_name' ] !== NULL )
						ManageTypedOffset( $part1_3_term,
							(string) $part1_common_name_tag[ kOFFSET_NID ],
							(string) $part1_common_name_lng_tag[ kOFFSET_NID ],
							(string) $part1_common_name_str_tag[ kOFFSET_NID ],
							kDEFAULT_LANGUAGE, (string) $record[ 'common_name' ] );
					
					//
					// Iterate languages.
					//
					foreach( $_SESSION[ kISO_LANGUAGES ] as $language )
					{
						//
						// Check language key file.
						//
						$file_path = $_SESSION[ kISO_FILE_PO_DIR ]."/$language/"
									.kISO_FILE_3166.'.serial';
						if( is_file( $file_path ) )
						{
							//
							// Instantiate keys array.
							//
							$keys = unserialize( file_get_contents( $file_path ) );
							
							//
							// Update label.
							//
							if( ($string = $part1_3_term->Label( kDEFAULT_LANGUAGE ))
								!== NULL )
							{
								if( array_key_exists( $string, $keys ) )
									$part1_3_term->Label(
										$language, $keys[ $string ] );
							}
							
							//
							// Update description.
							//
							if( ($string = $part1_3_term->Description( kDEFAULT_LANGUAGE ))
								!== NULL )
							{
								if( array_key_exists( $string, $keys ) )
									$part1_3_term->Description(
										$language, $keys[ $string ] );
							}
							
							//
							// Update common name.
							//
							if( $part1_3_term->offsetExists(
								(string) $part1_common_name_tag[ kOFFSET_NID ] ) )
							{
								$string = ManageTypedOffset( $part1_3_term,
									(string) $part1_common_name_tag[ kOFFSET_NID ],
									(string) $part1_common_name_lng_tag[ kOFFSET_NID ],
									(string) $part1_common_name_str_tag[ kOFFSET_NID ],
									kDEFAULT_LANGUAGE );
								if( array_key_exists( $string, $keys ) )
									ManageTypedOffset($part1_3_term,
									(string) $part1_common_name_tag[ kOFFSET_NID ],
									(string) $part1_common_name_lng_tag[ kOFFSET_NID ],
									(string) $part1_common_name_str_tag[ kOFFSET_NID ],
										$language, $keys[ $string ] );
							}
						
						} // Key file exists.
					
					} // Iterating languages.
					
					//
					// Commit term.
					//
					$part1_3_term->Insert( $_SESSION[ kSESSION_ONTOLOGY ]->Connection() );
					
					//
					// Create node and relate to parent.
					//
					$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
						$part1_3_node
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
								$part1_3_term,
								array( kKIND_NODE_INSTANCE, kKIND_NODE_ENUMERATION ),
								kTYPE_STRING ),
						$part1_3_parent );
					
					//
					// Handle alpha-2 code.
					//
					if( $record[ 'alpha_2_code' ] !== NULL )
					{
						//
						// Check term.
						//
						if( ($part1_2_term = $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm
							( (string) $record[ 'alpha_2_code' ], $part1_2_ns ))
								=== NULL )
						{
							//
							// Create term.
							//
							$part1_2_term = new COntologyTerm();
							$part1_2_term->LID( (string) $record[ 'alpha_2_code' ] );
							$part1_2_term->NS( $part1_2_ns );
							$part1_2_term->Term( $part1_3_term );					
							$part1_2_term->Insert( $_SESSION[ kSESSION_ONTOLOGY ]
													->Connection() );
							
							//
							// Create node and relate to parent.
							//
							$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
								$part1_2_node
									= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
										$part1_2_term ),
								$part1_2_parent );
						
						} // New term.
						
						else
						{
							echo( "!!! part1_2[".(string) $record[ 'alpha_2_code' ]."] !!!\n" );
						
							$part1_2_node
								= $_SESSION[ kSESSION_ONTOLOGY ]
									->ResolveNode( $part1_2_term, TRUE )[ 0 ];
						
						} // Existing term.
					
					} // Has alpha 2 code.
					
					//
					// Handle numeric code.
					//
					if( $record[ 'numeric_code' ] !== NULL )
					{
						//
						// Check term.
						//
						if( ($part1_n_term = $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm
							( (string) $record[ 'numeric_code' ], $part1_n_ns ))
								=== NULL )
						{
							//
							// Create term.
							//
							$part1_n_term = new COntologyTerm();
							$part1_n_term->LID( (string) $record[ 'numeric_code' ] );
							$part1_n_term->NS( $part1_n_ns );
							$part1_n_term->Term( $part1_3_term );					
							$part1_n_term->Insert( $_SESSION[ kSESSION_ONTOLOGY ]
													->Connection() );
							
							//
							// Create node and relate to parent.
							//
							$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
								$part1_n_node
									= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
										$part1_n_term ),
								$part1_n_parent );
						
						} // New term.
						
						else
						{
							echo( "!!! part1_n[".(string) $record[ 'numeric_code' ]."] !!!\n" );
						
							$part1_n_node
								= $_SESSION[ kSESSION_ONTOLOGY ]
									->ResolveNode( $part1_n_term, TRUE )[ 0 ];
						
						} // Existing term.
					
					} // Has numeric code.
					
					//
					// Create cross-references.
					//
					if( $part1_2_term !== NULL )
					{
						//
						// Cross reference part 3.
						//
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$part1_2_node, $part1_3_node, $pred_xref_exact );
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$part1_3_node, $part1_2_node, $pred_xref_exact );
					
						//
						// Cross reference numeric.
						//
						if( $part1_n_term !== NULL )
							$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
								$part1_2_node, $part1_n_node, $pred_xref_exact );
					
					} // Has alpha 2 code.
					
					//
					// Create cross-references.
					//
					if( $part1_n_term !== NULL )
					{
						//
						// Cross reference part 3.
						//
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$part1_n_node, $part1_3_node, $pred_xref_exact );
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$part1_3_node, $part1_n_node, $pred_xref_exact );
					
						//
						// Cross reference numeric.
						//
						if( $part1_2_term !== NULL )
							$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
								$part1_n_node, $part1_2_node, $pred_xref_exact );
					
					} // Has alpha 2 code.
				
				} // New alpha-3 term.
				
				else
					echo( "!!! alpha3[".(string) $record[ 'alpha_3_code' ]."] !!!\n" );
			
			} // Iterating 3166-1 XML elements.

			//
			// Iterate 3166-3 XML elements.
			//
			foreach( $xml->{'iso_3166_3_entry'} as $record )
			{
				//
				// Init loop data.
				//
				$part3_2_term = $part3_3_term = $part3_4_term = $part3_n_term = NULL;
				
				//
				// Load alpha-3 term.
				//
				if( ($part3_3_term = $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm
					( (string) $record[ 'alpha_3_code' ], $part3_3_ns ))
						=== NULL )
				{
					//
					// Init term.
					//
					$part3_3_term = new COntologyTerm();
					$part3_3_term->LID( (string) $record[ 'alpha_3_code' ] );
					$part3_3_term->NS( $part3_3_ns );
					if( $record[ 'names' ] !== NULL )
						$part3_3_term->Label( kDEFAULT_LANGUAGE,
											  (string) $record[ 'names' ] );
					if( $record[ 'comment' ] !== NULL )
						$part3_3_term->Description( kDEFAULT_LANGUAGE,
													(string) $record[ 'comment' ] );
					if( $record[ 'date_withdrawn' ] !== NULL )
						$part3_3_term[ (string) $part3_date_tag[ kOFFSET_NID ] ]
							= (string) $record[ 'date_withdrawn' ];
					
					//
					// Iterate languages.
					//
					foreach( $_SESSION[ kISO_LANGUAGES ] as $language )
					{
						//
						// Check language key file.
						//
						$file_path = $_SESSION[ kISO_FILE_PO_DIR ]."/$language/"
									.kISO_FILE_3166.'.serial';
						if( is_file( $file_path ) )
						{
							//
							// Instantiate keys array.
							//
							$keys = unserialize( file_get_contents( $file_path ) );
							
							//
							// Update label.
							//
							if( ($string = $part3_3_term->Label( kDEFAULT_LANGUAGE ))
								!== NULL )
							{
								if( array_key_exists( $string, $keys ) )
									$part3_3_term->Label(
										$language, $keys[ $string ] );
							}
							
							//
							// Update description.
							//
							if( ($string = $part3_3_term->Description( kDEFAULT_LANGUAGE ))
								!== NULL )
							{
								if( array_key_exists( $string, $keys ) )
									$part3_3_term->Description(
										$language, $keys[ $string ] );
							}
						
						} // Key file exists.
					
					} // Iterating languages.
					
					//
					// Commit term.
					//
					$part3_3_term->Insert( $_SESSION[ kSESSION_ONTOLOGY ]->Connection() );
					
					//
					// Create node and relate to parent.
					//
					$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
						$part3_3_node
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
								$part3_3_term,
								array( kKIND_NODE_INSTANCE, kKIND_NODE_ENUMERATION ),
								kTYPE_STRING ),
						$part3_3_parent );
					
					//
					// Handle alpha-4 code.
					//
					if( $record[ 'alpha_4_code' ] !== NULL )
					{
						//
						// Check term.
						//
						if( ($part3_4_term = $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm
							( (string) $record[ 'alpha_4_code' ], $part3_4_ns ))
								=== NULL )
						{
							//
							// Create term.
							//
							$part3_4_term = new COntologyTerm();
							$part3_4_term->LID( (string) $record[ 'alpha_4_code' ] );
							$part3_4_term->NS( $part3_4_ns );
							$part3_4_term->Term( $part3_3_term );					
							$part3_4_term->Insert( $_SESSION[ kSESSION_ONTOLOGY ]
													->Connection() );
							
							//
							// Create node and relate to parent.
							//
							$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
								$part3_4_node
									= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
										$part3_4_term ),
								$part3_4_parent );
						
						} // New term.
						
						else
						{
							echo( "!!! part3_4[".(string) $record[ 'alpha_4_code' ]."] !!!\n" );
						
							$part3_4_node
								= $_SESSION[ kSESSION_ONTOLOGY ]
									->ResolveNode( $part3_4_term, TRUE )[ 0 ];
						
						} // Existing term.
					
						//
						// Check alpha 2 term.
						//
						if( ($part3_2_term = $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm
							( substr( (string) $record[ 'alpha_4_code' ], 0, 2 ),
									$part3_2_ns ))
								=== NULL )
						{
							//
							// Create term.
							//
							$part3_2_term = new COntologyTerm();
							$part3_2_term->LID( substr( (string) $record[ 'alpha_4_code' ],
														0, 2 ) );
							$part3_2_term->NS( $part3_2_ns );
							$part3_2_term->Term( $part3_3_term );					
							$part3_2_term->Insert( $_SESSION[ kSESSION_ONTOLOGY ]
													->Connection() );
							
							//
							// Create node and relate to parent.
							//
							$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
								$part3_2_node
									= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
										$part3_2_term ),
								$part3_2_parent );
						
						} // New term.
						
						else
						{
							echo( "!!! part3_2[".substr( (string) $record[ 'alpha_4_code' ], 0, 2 )."] !!!\n" );
						
							$part3_2_node
								= $_SESSION[ kSESSION_ONTOLOGY ]
									->ResolveNode( $part3_2_term, TRUE )[ 0 ];
						
						} // Existing term.
					
					} // Has alpha 4 code.
					
					//
					// Handle numeric code.
					//
					if( $record[ 'numeric_code' ] !== NULL )
					{
						//
						// Check term.
						//
						if( ($part3_n_term = $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm
							( (string) $record[ 'numeric_code' ], $part3_n_ns ))
								=== NULL )
						{
							//
							// Create term.
							//
							$part3_n_term = new COntologyTerm();
							$part3_n_term->LID( (string) $record[ 'numeric_code' ] );
							$part3_n_term->NS( $part3_n_ns );
							$part3_n_term->Term( $part3_3_term );					
							$part3_n_term->Insert( $_SESSION[ kSESSION_ONTOLOGY ]
													->Connection() );
							
							//
							// Create node and relate to parent.
							//
							$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
								$part3_n_node
									= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
										$part3_n_term ),
								$part3_n_parent );
						
						} // New term.
						
						else
						{
							echo( "!!! part3_n[".(string) $record[ 'numeric_code' ]."] !!!\n" );
						
							$part3_n_node
								= $_SESSION[ kSESSION_ONTOLOGY ]
									->ResolveNode( $part3_n_term, TRUE )[ 0 ];
						
						} // Existing term.
					
					} // Has numeric code.
					
					//
					// Create cross-references.
					//
					if( $part3_4_term !== NULL )
					{
						//
						// Cross reference part 3.
						//
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$part3_4_node, $part3_3_node, $pred_xref_exact );
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$part3_3_node, $part3_4_node, $pred_xref_exact );
					
						//
						// Cross reference part 2.
						//
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$part3_2_node, $part3_3_node, $pred_xref_exact );
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$part3_3_node, $part3_2_node, $pred_xref_exact );
					
						//
						// Cross reference numeric.
						//
						if( $part3_n_term !== NULL )
						{
							$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
								$part3_4_node, $part3_n_node, $pred_xref_exact );
							$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
								$part3_2_node, $part3_n_node, $pred_xref_exact );
						}
					
					} // Has alpha 4 code.
					
					//
					// Create cross-references.
					//
					if( $part3_n_term !== NULL )
					{
						//
						// Cross reference part 3.
						//
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$part3_n_node, $part3_3_node, $pred_xref_exact );
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$part3_3_node, $part3_n_node, $pred_xref_exact );
					
						//
						// Cross reference numeric.
						//
						if( $part3_4_term !== NULL )
						{
							$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
								$part3_n_node, $part3_4_node, $pred_xref_exact );
							$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
								$part3_n_node, $part3_2_node, $pred_xref_exact );
						}
					
					} // Has numeric code.
				
				} // New alpha-3 term.
				
				else
					echo( "!!! part3_3[".(string) $record[ 'alpha_3_code' ]."] !!!\n" );
			
			} // Iterating 3166-3 XML elements.
		
		} // Loaded file.

	} // ISOParse3166XML.

	 
	/*===================================================================================
	 *	ISOParse31662XML																*
	 *==================================================================================*/

	/**
	 * <h4>Parse ISO 3166-2 XML file</h4>
	 *
	 * This method will parse the XML ISO 3166-2 file.
	 */
	function ISOParse31662XML()
	{
		//
		// Load XML file.
		//
		$xml = kISO_CODES_PATH.kISO_CODES_PATH_XML.'/'.kISO_FILE_3166_2.'.xml';
		$xml = simplexml_load_file( $xml  );
		if( $xml instanceof SimpleXMLElement )
		{
			//
			// Init codes.
			//
			$part2_type_code
				= implode(
					kTOKEN_NAMESPACE_SEPARATOR,
					array( kONTOLOGY_ISO,
						   kONTOLOGY_ISO_3166,
						   kONTOLOGY_ISO_3166_2,
						   kONTOLOGY_ISO_3166_2_TYPE ) );
			
			//
			// Load namespaces.
			//
			$part1_2_ns
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO,
							   kONTOLOGY_ISO_3166,
							   kONTOLOGY_ISO_3166_1,
							   kONTOLOGY_ISO_3166_1_ALPHA2 ) ),
					NULL,
					TRUE );
			$part2_ns
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO,
							   kONTOLOGY_ISO_3166,
							   kONTOLOGY_ISO_3166_2 ) ),
					NULL,
					TRUE );
			
			//
			// Load predicates.
			//
			$subset_pred
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					kPREDICATE_SUBSET_OF,
					NULL,
					TRUE );
			$pred_xref_exact
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					kPREDICATE_XREF_EXACT,
					NULL,
					TRUE );
			
			//
			// Load parent nodes.
			//
			$par2_parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode( $part2_ns, TRUE )[ 0 ];
			
			//
			// Load tags.
			//
			$part2_type_tag
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTag(
					$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
						implode(
							kTOKEN_NAMESPACE_SEPARATOR,
							array( kONTOLOGY_ISO,
								   kONTOLOGY_ISO_3166,
								   kONTOLOGY_ISO_3166_2,
								   kONTOLOGY_ISO_3166_2_TYPE ) ),
						NULL,
						TRUE ),
					TRUE )[ 0 ];

			//
			// Iterate countries.
			//
			foreach( $xml->{'iso_3166_country'} as $rec_country )
			{
				//
				// Init local storage.
				//
				$subsets = $children = Array();
				
				//
				// Load country.
				//
				if( $rec_country[ 'code' ] !== NULL )
				{
					//
					// Load country term.
					//
					$term
						= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
							(string) $rec_country[ 'code' ],
							$part1_2_ns,
							TRUE );
					
					//
					// Refer to main term.
					//
					if( $term->offsetExists( kTAG_TERM ) )
						$term = $term->offsetGet( kTAG_TERM );
					
					//
					// Load main node.
					//
					$country
						= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode(
							$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
								$term,
								NULL,
								TRUE ),
							TRUE )[ 0 ];
					
					//
					// Iterate subset types.
					//
					foreach( $rec_country->{'iso_3166_subset'} as $rec_type )
					{
						//
						// Save current subset type.
						//
						$type = (string) $rec_type[ 'type' ];
						
						//
						// Iterate subsets.
						//
						foreach( $rec_type->{'iso_3166_2_entry'} as $rec_element )
						{
							//
							// Init term.
							//
							$term = new COntologyTerm();
							$term->LID( (string) $rec_element[ 'code' ] );
							$term->NS( $part2_ns );
							if( $rec_element[ 'name' ] !== NULL )
								$term->Label( NULL, (string) $rec_element[ 'name' ] );
							$term[ $part2_type_tag[ kOFFSET_NID ] ] = $type;
							
							//
							// Iterate languages.
							//
							foreach( $_SESSION[ kISO_LANGUAGES ] as $language )
							{
								//
								// Check language key file.
								//
								$file_path = $_SESSION[ kISO_FILE_PO_DIR ]."/$language/"
											.kISO_FILE_3166_2.'.serial';
								if( is_file( $file_path ) )
								{
									//
									// Instantiate keys array.
									//
									$keys = unserialize( file_get_contents( $file_path ) );
									
									//
									// Update label.
									//
									if( ($string = $term->Label()) !== NULL )
									{
										if( array_key_exists( $string, $keys ) )
											$term->Label(
												$language, $keys[ $string ] );
									}
								
								} // Key file exists.
							
							} // Iterating languages.
							
							//
							// Commit term.
							//
							$term->Insert( $_SESSION[ kSESSION_ONTOLOGY ]->Connection() );
							
							//
							// Create node.
							//
							$node = $_SESSION[ kSESSION_ONTOLOGY ]
										->NewEnumerationNode( $term );
							if( is_array( $node ) )
								$node = $node[ 0 ];
							
							//
							// Store in cache.
							//
							$subsets[ substr( $term->LID(), 3 ) ] = $node;
							
							//
							// Handle parented subset.
							//
							if( $rec_element[ 'parent' ] !== NULL )
								$children[ substr( $term->LID(), 3 ) ]
									= (string) $rec_element[ 'parent' ];
							
							//
							// Handle first level subset.
							//
							else
							{
								//
								// Relate to parent.
								//
								$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
									$node,
									$par2_parent );
							
								//
								// Subset of country.
								//
								$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
									$node,
									$country,
									$subset_pred );
							
							} // Has no parent.
						
						} // Iterating subsets.
					
					} // Iterating subset types.
					
					//
					// Handle parented nodes.
					//
					foreach( $children as $child_code => $parent_code )
					{
						//
						// Get parent and child.
						//
						$child = $subsets[ $child_code ];
						$parent = $subsets[ $parent_code ];

						//
						// Relate to parent.
						//
						$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf( $child, $parent );
					
					} // Iterating children.
				
				} // Refers to country.
				
				else
					echo( "!!! MISSING COUNTRY CODE !!!\n" );
			
			} // Iterating countries.
		
		} // Loaded file.

	} // ISOParse31662XML.

	 
	/*===================================================================================
	 *	ISOParse4217XML																	*
	 *==================================================================================*/

	/**
	 * <h4>Parse ISO 4217 XML file</h4>
	 *
	 * This method will parse the XML ISO 4217 file.
	 */
	function ISOParse4217XML()
	{
		//
		// Load XML file.
		//
		$xml = kISO_CODES_PATH.kISO_CODES_PATH_XML.'/'.kISO_FILE_4217.'.xml';
		$xml = simplexml_load_file( $xml  );
		if( $xml instanceof SimpleXMLElement )
		{
			//
			// Load namespaces.
			//
			$a_ns
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO,
							   kONTOLOGY_ISO_4217,
							   kONTOLOGY_ISO_4217_A ) ),
					NULL,
					TRUE );
			$h_ns
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO,
							   kONTOLOGY_ISO_4217,
							   kONTOLOGY_ISO_4217_H ) ),
					NULL,
					TRUE );
			
			//
			// Load parent nodes.
			//
			$a_parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode( $a_ns, TRUE )[ 0 ];
			$h_parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode( $h_ns, TRUE )[ 0 ];
			
			//
			// Load attribute tags.
			//
			$h_date_tag
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTag(
					$_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
						implode(
							kTOKEN_NAMESPACE_SEPARATOR,
							array( kONTOLOGY_ISO,
								   kONTOLOGY_ISO_4217,
								   kONTOLOGY_ISO_4217_H,
								   kONTOLOGY_ISO_4217_H_DATE_WITHDRAWN ) ),
						NULL,
						TRUE ),
					TRUE )[ 0 ];
			
			//
			// Load predicates.
			//
			$pred_xref_exact
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					kPREDICATE_XREF_EXACT,
					NULL,
					TRUE );

			//
			// Iterate 4217-A XML elements.
			//
			foreach( $xml->{'iso_4217_entry'} as $record )
			{
				//
				// Init loop data.
				//
				$letter_term = $numeric_term = NULL;
				
				//
				// Load letter term.
				//
				if( ($letter_term = $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm
					( (string) $record[ 'letter_code' ], $a_ns ))
						=== NULL )
				{
					//
					// Init term.
					//
					$letter_term = new COntologyTerm();
					$letter_term->LID( (string) $record[ 'letter_code' ] );
					$letter_term->NS( $a_ns );
					if( $record[ 'currency_name' ] !== NULL )
						$letter_term->Label( kDEFAULT_LANGUAGE,
											 (string) $record[ 'currency_name' ] );
					
					//
					// Iterate languages.
					//
					foreach( $_SESSION[ kISO_LANGUAGES ] as $language )
					{
						//
						// Check language key file.
						//
						$file_path = $_SESSION[ kISO_FILE_PO_DIR ]."/$language/"
									.kISO_FILE_4217.'.serial';
						if( is_file( $file_path ) )
						{
							//
							// Instantiate keys array.
							//
							$keys = unserialize( file_get_contents( $file_path ) );
							
							//
							// Update label.
							//
							if( ($string = $letter_term->Label( kDEFAULT_LANGUAGE ))
								!== NULL )
							{
								if( array_key_exists( $string, $keys ) )
									$letter_term->Label(
										$language, $keys[ $string ] );
							}
						
						} // Key file exists.
					
					} // Iterating languages.
					
					//
					// Commit term.
					//
					$letter_term->Insert( $_SESSION[ kSESSION_ONTOLOGY ]->Connection() );
					
					//
					// Create node and relate to parent.
					//
					$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
						$letter_node
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewNode(
								$letter_term,
								array( kKIND_NODE_INSTANCE, kKIND_NODE_ENUMERATION ),
								kTYPE_STRING ),
						$a_parent );
					
					//
					// Handle numeric code.
					//
					if( $record[ 'numeric_code' ] !== NULL )
					{
						//
						// Check term.
						//
						if( ($numeric_term = $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm
							( (string) $record[ 'numeric_code' ], $a_ns ))
								=== NULL )
						{
							//
							// Create term.
							//
							$numeric_term = new COntologyTerm();
							$numeric_term->LID( (string) $record[ 'numeric_code' ] );
							$numeric_term->NS( $a_ns );
							$numeric_term->Term( $letter_term );					
							$numeric_term->Insert( $_SESSION[ kSESSION_ONTOLOGY ]
													->Connection() );
							
							//
							// Create node and relate to parent.
							//
							$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
								$numeric_node
									= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
										$numeric_term ),
								$a_parent );
						
						} // New term.
						
						else
						{
							echo( "!!! A-numeric[".(string) $record[ 'numeric_code' ]."] !!!\n" );
						
							$numeric_node
								= $_SESSION[ kSESSION_ONTOLOGY ]
									->ResolveNode( $numeric_term, TRUE )[ 0 ];
						
						} // Existing term.
					
						//
						// Cross reference letter code.
						//
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$numeric_node, $letter_node, $pred_xref_exact );
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$letter_node, $numeric_node, $pred_xref_exact );
					
					} // Has numeric code.
				
				} // New letter code term.
				
				else
					echo( "!!! A-letter[".(string) $record[ 'letter_code' ]."] !!!\n" );
			
			} // Iterating 4217-A XML elements.

			//
			// Iterate 4217-H XML elements.
			//
			foreach( $xml->{'historic_iso_4217_entry'} as $record )
			{
				//
				// Init loop data.
				//
				$letter_term = $numeric_term = NULL;
				
				//
				// Load letter term.
				//
				if( ($letter_term = $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm
					( (string) $record[ 'letter_code' ], $h_ns ))
						=== NULL )
				{
					//
					// Init term.
					//
					$letter_term = new COntologyTerm();
					$letter_term->LID( (string) $record[ 'letter_code' ] );
					$letter_term->NS( $h_ns );
					if( $record[ 'currency_name' ] !== NULL )
						$letter_term->Label( kDEFAULT_LANGUAGE,
											 (string) $record[ 'currency_name' ] );
					if( $record[ 'date_withdrawn' ] !== NULL )
						$letter_term[ (string) $h_date_tag[ kOFFSET_NID ] ]
							= (string) $record[ 'date_withdrawn' ];
					
					//
					// Iterate languages.
					//
					foreach( $_SESSION[ kISO_LANGUAGES ] as $language )
					{
						//
						// Check language key file.
						//
						$file_path = $_SESSION[ kISO_FILE_PO_DIR ]."/$language/"
									.kISO_FILE_4217.'.serial';
						if( is_file( $file_path ) )
						{
							//
							// Instantiate keys array.
							//
							$keys = unserialize( file_get_contents( $file_path ) );
							
							//
							// Update label.
							//
							if( ($string = $letter_term->Label( kDEFAULT_LANGUAGE ))
								!== NULL )
							{
								if( array_key_exists( $string, $keys ) )
									$letter_term->Label(
										$language, $keys[ $string ] );
							}
						
						} // Key file exists.
					
					} // Iterating languages.
					
					//
					// Commit term.
					//
					$letter_term->Insert( $_SESSION[ kSESSION_ONTOLOGY ]->Connection() );
					
					//
					// Create node and relate to parent.
					//
					$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
						$letter_node
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
								$letter_term ),
						$h_parent );
					
					//
					// Handle numeric code.
					//
					if( $record[ 'numeric_code' ] !== NULL )
					{
						//
						// Check term.
						//
						if( ($numeric_term = $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm
							( (string) $record[ 'numeric_code' ], $h_ns ))
								=== NULL )
						{
							//
							// Create term.
							//
							$numeric_term = new COntologyTerm();
							$numeric_term->LID( (string) $record[ 'numeric_code' ] );
							$numeric_term->NS( $h_ns );
							$numeric_term->Term( $letter_term );					
							$numeric_term->Insert( $_SESSION[ kSESSION_ONTOLOGY ]
													->Connection() );
							
							//
							// Create node and relate to parent.
							//
							$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
								$numeric_node
									= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
										$numeric_term ),
								$h_parent );
						
						} // New term.
						
						else
						{
							echo( "!!! H-numeric[".(string) $record[ 'numeric_code' ]."] !!!\n" );
						
							$numeric_node
								= $_SESSION[ kSESSION_ONTOLOGY ]
									->ResolveNode( $numeric_term, TRUE )[ 0 ];
						
						} // Existing term.
					
						//
						// Cross reference letter code.
						//
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$numeric_node, $letter_node, $pred_xref_exact );
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$letter_node, $numeric_node, $pred_xref_exact );
					
					} // Has numeric code.
				
				} // New letter code term.
				
				else
					echo( "!!! H-letter[".(string) $record[ 'letter_code' ]."] !!!\n" );
			
			} // Iterating 4217-H XML elements.
		
		} // Loaded file.

	} // ISOParse4217XML.

	 
	/*===================================================================================
	 *	ISOParse15924XML																	*
	 *==================================================================================*/

	/**
	 * <h4>Parse ISO 15924 XML file</h4>
	 *
	 * This method will parse the XML ISO 15924 file.
	 */
	function ISOParse15924XML()
	{
		//
		// Load XML file.
		//
		$xml = kISO_CODES_PATH.kISO_CODES_PATH_XML.'/'.kISO_FILE_15924.'.xml';
		$xml = simplexml_load_file( $xml  );
		if( $xml instanceof SimpleXMLElement )
		{
			//
			// Load namespaces.
			//
			$namespace
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					implode(
						kTOKEN_NAMESPACE_SEPARATOR,
						array( kONTOLOGY_ISO,
							   kONTOLOGY_ISO_15924 ) ),
					NULL,
					TRUE );
			
			//
			// Load parent nodes.
			//
			$parent
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveNode( $namespace, TRUE )[ 0 ];
			
			//
			// Load predicates.
			//
			$pred_xref_exact
				= $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm(
					kPREDICATE_XREF_EXACT,
					NULL,
					TRUE );

			//
			// Iterate 15924 XML elements.
			//
			foreach( $xml->{'iso_15924_entry'} as $record )
			{
				//
				// Init loop data.
				//
				$alpha_term = $numeric_term = NULL;
				
				//
				// Load alpha term.
				//
				if( ($alpha_term = $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm
					( (string) $record[ 'alpha_4_code' ], $namespace ))
						=== NULL )
				{
					//
					// Init term.
					//
					$alpha_term = new COntologyTerm();
					$alpha_term->LID( (string) $record[ 'alpha_4_code' ] );
					$alpha_term->NS( $namespace );
					if( $record[ 'name' ] !== NULL )
						$alpha_term->Label( kDEFAULT_LANGUAGE,
											(string) $record[ 'name' ] );
					
					//
					// Iterate languages.
					//
					foreach( $_SESSION[ kISO_LANGUAGES ] as $language )
					{
						//
						// Check language key file.
						//
						$file_path = $_SESSION[ kISO_FILE_PO_DIR ]."/$language/"
									.kISO_FILE_15924.'.serial';
						if( is_file( $file_path ) )
						{
							//
							// Instantiate keys array.
							//
							$keys = unserialize( file_get_contents( $file_path ) );
							
							//
							// Update label.
							//
							if( ($string = $alpha_term->Label( kDEFAULT_LANGUAGE ))
								!== NULL )
							{
								if( array_key_exists( $string, $keys ) )
									$alpha_term->Label(
										$language, $keys[ $string ] );
							}
						
						} // Key file exists.
					
					} // Iterating languages.
					
					//
					// Commit term.
					//
					$alpha_term->Insert( $_SESSION[ kSESSION_ONTOLOGY ]->Connection() );
					
					//
					// Create node and relate to parent.
					//
					$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
						$alpha_node
							= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
								$alpha_term ),
						$parent );
					
					//
					// Handle numeric code.
					//
					if( $record[ 'numeric_code' ] !== NULL )
					{
						//
						// Check term.
						//
						if( ($numeric_term = $_SESSION[ kSESSION_ONTOLOGY ]->ResolveTerm
							( (string) $record[ 'numeric_code' ], $namespace ))
								=== NULL )
						{
							//
							// Create term.
							//
							$numeric_term = new COntologyTerm();
							$numeric_term->LID( (string) $record[ 'numeric_code' ] );
							$numeric_term->NS( $namespace );
							$numeric_term->Term( $alpha_term );					
							$numeric_term->Insert( $_SESSION[ kSESSION_ONTOLOGY ]
													->Connection() );
							
							//
							// Create node and relate to parent.
							//
							$_SESSION[ kSESSION_ONTOLOGY ]->EnumOf(
								$numeric_node
									= $_SESSION[ kSESSION_ONTOLOGY ]->NewEnumerationNode(
										$numeric_term ),
								$parent );
						
						} // New term.
						
						else
						{
							echo( "!!! numeric[".(string) $record[ 'numeric_code' ]."] !!!\n" );
						
							$numeric_node
								= $_SESSION[ kSESSION_ONTOLOGY ]
									->ResolveNode( $numeric_term, TRUE )[ 0 ];
						
						} // Existing term.
					
						//
						// Cross reference alpha code.
						//
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$numeric_node, $alpha_node, $pred_xref_exact );
						$_SESSION[ kSESSION_ONTOLOGY ]->RelateTo(
							$alpha_node, $numeric_node, $pred_xref_exact );
					
					} // Has numeric code.
				
				} // New letter code term.
				
				else
					echo( "!!! alpha[".(string) $record[ 'alpha_4_code' ]."] !!!\n" );
			
			} // Iterating 15924 XML elements.
		
		} // Loaded file.

	} // ISOParse15924XML.

?>
