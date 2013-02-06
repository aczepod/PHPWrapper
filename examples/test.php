<?php
	
	//
	// Test namespaces.
	//
	require_once( 'includes.inc.php' );
	
/*
	//
	// Revive namespace.
	//
	use MyWrapper\Framework\CDocument;
	
	//
	// Instantiate class.
	//
	$x = new CDocument();
	
	echo( '<pre>' );
	print_r( $x );
	echo( '</pre>' );
	
	//
	// Encode something.
	//
	$json = CDocument::JsonEncode( array( 'A', 'B', 'C' ) );
	
	//
	// Decode it.
	//
	$php = CDocument::JsonDecode( $json );
	
	//
	// Exception.
	//
	$test = $json.',,,,';
	$php = CDocument::JsonDecode( $test );

	//
	// Open a Mongo connection.
	//
	$mongo = New Mongo();
	$db = $mongo->selectDB( "TEST" );
	$db->drop();
	$collection = $db->selectCollection( 'test' );
	$options = array( 'safe' => TRUE );
	
	//
	// Try committing an array.
	//
	$data = array( 'A' => 'a', 'B' => 2, 'C' => array( 1, 2, 3 ), 4 => 5 );
	$status = $collection->save( $data, $options );
	echo( '<h4>Status:</h4>' );
	echo( '<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<h4>Data:</h4>' );
	echo( '<pre>' ); print_r( $data ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Try committing an object.
	//
	$data = new ArrayObject( array( 'A' => 'a', 'B' => 2, 'C' => array( 1, 2, 3 ), 4 => 5 ) );
	$status = $collection->save( $data, $options );
	echo( '<h4>Status:</h4>' );
	echo( '<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<h4>Data:</h4>' );
	echo( '<pre>' ); print_r( $data ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Open a Mongo connection.
	//
	$mongo = New Mongo();
	$db = $mongo->selectDB( "TEST" );
	$db->drop();
	$collection = $db->selectCollection( 'test' );
	$options = array( 'safe' => TRUE );
	
	//
	// Create three objects.
	//
	$a = new ArrayObject( array( 'name' => 'A' ) );
	$b = new ArrayObject( array( 'name' => 'B' ) );
	$c = new ArrayObject( array( 'name' => 'C' ) );
	
	//
	// Add three objects.
	//
	$collection->save( $a, $options );
	$collection->save( $b, $options );
	$collection->save( $c, $options );
	
	//
	// Create array.
	//
	$x = array( $a[ '_id' ], $b[ '_id' ], $c[ '_id' ] );
	echo( '<pre>' ); print_r( $x ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Test array.
	//
	echo( '<i>$ok = in_array( $b[ "_id" ], $x );</i><br />' );
	$ok = in_array( $b[ "_id" ], $x );
	echo( '<pre>' ); print_r( ($ok) ? 'Y' : 'N' ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = in_array( ((string) $b[ "_id" ]), $x );</i><br />' );
	$ok = in_array( ((string) $b[ "_id" ]), $x );
	echo( '<pre>' ); print_r( ($ok) ? 'Y' : 'N' ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = in_array( "pippo", $x );</i><br />' );
	$ok = in_array( "pippo", $x );
	echo( '<pre>' ); print_r( ($ok) ? 'Y' : 'N' ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Test objects.
	//
	echo( '<i>$ok = ( $b[ "_id" ] == $b[ "_id" ] );</i><br />' );
	$ok = ( $b[ "_id" ] == $b[ "_id" ] );
	echo( '<pre>' ); print_r( ($ok) ? 'Y' : 'N' ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = ( $b[ "_id" ] == (string) $b[ "_id" ] );</i><br />' );
	$ok = ( $b[ "_id" ] == (string) $b[ "_id" ] );
	echo( '<pre>' ); print_r( ($ok) ? 'Y' : 'N' ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = ( $b[ "_id" ] == (string) $a[ "_id" ] );</i><br />' );
	$ok = ( $b[ "_id" ] == (string) $a[ "_id" ] );
	echo( '<pre>' ); print_r( ($ok) ? 'Y' : 'N' ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Test hashes.
	//
	echo( '<i>$ok = ( md5( $b[ "_id" ] ) == md5( $b[ "_id" ] ) );</i><br />' );
	$ok = ( md5( $b[ "_id" ] ) == md5( $b[ "_id" ] ) );
	echo( '<pre>' ); print_r( ($ok) ? 'Y' : 'N' ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = ( md5( $b[ "_id" ] ) == (string) $b[ "_id" ] );</i><br />' );
	$ok = ( md5( $b[ "_id" ] ) == (string) $b[ "_id" ] );
	echo( '<pre>' ); print_r( ($ok) ? 'Y' : 'N' ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = ( md5( $b[ "_id" ] ) == md5( $a[ "_id" ] ) );</i><br />' );
	$ok = ( $b[ "_id" ] == (string) $a[ "_id" ] );
	echo( '<pre>' ); print_r( ($ok) ? 'Y' : 'N' ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	require_once( kPATH_MYWRAPPER_LIBRARY_FUNCTION."/accessors.php" );
	
	//
	// Test accessors.
	//
	$object = array( 'ID' => 'PIPPO' );
	echo( '<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Add to terms.
	//
	echo( '<i>$ok = ManageObjectSetOffset( $object, "terms", 1, TRUE, TRUE );</i><br />' );
	$ok = ManageObjectSetOffset( $object, "terms", 1, TRUE, TRUE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = ManageObjectSetOffset( $object, "terms", "due", TRUE, TRUE );</i><br />' );
	$ok = ManageObjectSetOffset( $object, "terms", "due", TRUE, TRUE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = ManageObjectSetOffset( $object, "terms", "3", TRUE, TRUE );</i><br />' );
	$ok = ManageObjectSetOffset( $object, "terms", "3", TRUE, TRUE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Add duplicate.
	//
	echo( '<i>$ok = ManageObjectSetOffset( $object, "terms", 1, TRUE, TRUE );</i><br />' );
	$ok = ManageObjectSetOffset( $object, "terms", 1, TRUE, TRUE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = ManageObjectSetOffset( $object, "terms", "1", TRUE, TRUE );</i><br />' );
	$ok = ManageObjectSetOffset( $object, "terms", "1", TRUE, TRUE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Delete.
	//
	echo( '<i>$ok = ManageObjectSetOffset( $object, "terms", 1, FALSE, TRUE );</i><br />' );
	$ok = ManageObjectSetOffset( $object, "terms", 1, FALSE, TRUE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = ManageObjectSetOffset( $object, "terms", "due", FALSE, TRUE );</i><br />' );
	$ok = ManageObjectSetOffset( $object, "terms", "due", FALSE, TRUE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = ManageObjectSetOffset( $object, "terms", 3, FALSE, TRUE );</i><br />' );
	$ok = ManageObjectSetOffset( $object, "terms", 3, FALSE, TRUE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Test late static binding.
	//
	
	//
	// Define classes.
	//
	class A
	{
		static function Def()	{	echo( 'A' );	}
		public function CallSelf()	{	self::Def();	}
		public function CallStatic()	{	static::Def();	}
	}
	class B extends A
	{
		static function Def()	{	echo( 'B' );	}
	}
	class C extends B
	{
		public function CallSelf()	{	self::Def();	}
		public function CallStatic()	{	static::Def();	}
	}
	
	//
	// Test.
	//
	$x = new A();
	$x->CallSelf();
	echo( '<hr />' );
	$x->CallStatic();
	echo( '<hr /><hr />' );
	
	$x = new B();
	$x->CallSelf();
	echo( '<hr />' );
	$x->CallStatic();
	echo( '<hr /><hr />' );
	
	$x = new C();
	$x->CallSelf();
	echo( '<hr />' );
	$x->CallStatic();
	echo( '<hr /><hr />' );

	//
	// Simplexml parsing tests.
	//
	
	//
	// Init local storage.
	//
	$iso = Array();
	$iso[ '3166' ] = Array();
	
	//
	// Open file.
	//
	$iso = Array();
	$file = '/usr/local/Cellar/iso-codes/3.37/share/xml/iso-codes/iso_3166.xml';
	$xml = simplexml_load_file( $file );
	if( $xml instanceof SimpleXMLElement )
	{
		//
		// Collect ISO 3166 offsets.
		//
		$offsets = Array();
		foreach( $xml->{'iso_3166_entry'} as $iso_3166 )
		{
			foreach( $iso_3166->attributes() as $key => $value )
			{
				if( ! in_array( $key, $offsets ) )
					$offsets[] = $key;
			}
		}
		
		echo( '<pre>' );
		print_r( $offsets );
		echo( '</pre>' );
		
		//
		// Load ISO 3166 codes.
		//
		foreach( $xml->{'iso_3166_entry'} as $element )
		{
			$record = Array();
			foreach( $element->attributes() as $key => $value )
			{
				$record[ $key ] = (string) $value;
			}
			
			$iso[ '3166' ][] = $record;
		}
	
		//
		// Collect ISO 3166 3 offsets.
		//
		$offsets = Array();
		foreach( $xml->{'iso_3166_3_entry'} as $element )
		{
			foreach( $element->attributes() as $key => $value )
			{
				if( ! in_array( $key, $offsets ) )
					$offsets[] = $key;
			}
		}
		
		echo( '<pre>' );
		print_r( $offsets );
		echo( '</pre>' );

		$iso[ '3166_3' ] = Array();
		
		//
		// Load ISO 3166 3 codes.
		//
		foreach( $xml->{'iso_3166_3_entry'} as $element )
		{
			$record = Array();
			foreach( $element->attributes() as $key => $value )
			{
				$record[ $key ] = (string) $value;
			}
			
			$iso[ '3166_3' ][] = $record;
		}
		
		echo( '<hr />' );
	}
	else
		exit( "unable to load XML file [$file]." );
	
	echo( count( $iso[ '3166' ] ) );
	echo( '<pre>' );
	print_r( $iso );
	echo( '</pre>' );

	//
	// Test the Mongo distinct PHP command.
	//

	$m = new MongoClient();
	$db = $m->selectDB("test");
	$db->dropCollection("distinct");
	$c = $db->distinct;
	
	$c->insert(array("stuff" => "bar", "zip-code" => 10010));
	$c->insert(array("stuff" => "foo", "zip-code" => 10010));
	$c->insert(array("stuff" => "bar", "zip-code" => 99701), array("safe" => true));
	
	$retval = $c->distinct("zip-code");
	var_dump($retval);
	
	$retval = $c->distinct("zip-code", array("stuff" => "foo"));
	var_dump($retval);
	
	$retval = $c->distinct("zip-code", array("stuff" => "bar"));
	var_dump($retval);
	
	//
	// Test parsing term XML files.
	//
	$xml = simplexml_load_file( '/Library/WebServer/Library/PHPWrapper/defines/terms.xml' );
	foreach( $xml->term as $term )
	{
		echo( '<hr>' );
		echo( '<code>['.(string) $term[ 'kTAG_LID' ].'] </code>' );
		echo( (string) $term->{'kTAG_DEFINITION'}[ 0 ] );
	}
	
	//
	// Test iterator_to_array() Mongo cursor conversion.
	//

	$m = new MongoClient();
	$db = $m->selectDB("test");
	$db->dropCollection("iterator");
	$c = $db->selectCollection( "iterator" );
	
	$c->insert(array("A" => 1, "B" => 2));
	$c->insert(array("A" => 3, "B" => 4));
	$c->insert(array("A" => 5, "B" => 6));
	
	$rs = $c->find( Array(), array( '_id' => TRUE ) );
	
	echo( '<pre>' );
	print_r( array_keys( iterator_to_array( $rs ) ) );
	echo( '</pre>' );
	
	//
	// Test integers.
	//
	class pippo{	const baba = '1'; }
	
	$x = (int) '1';
	echo( gettype( $x ).'<br>' );
	print_r( $x );
	echo( '<hr>' );
	
	$x = (int) pippo::baba;
	echo( gettype( $x ).'<br>' );
	print_r( $x );
	echo( '<hr>' );
	
	echo( $x - 1 );
	
	//
	// Test array_slice.
	//
	
	$array = array( 1, 2, 3, 4, 5 );
	
	echo( '<pre>' );
	echo( 'array_slice( $array, 0, 4 )' );
	print_r( array_slice( $array, 0, 4 ) );
	echo( '</pre>' );
	
	echo( '<pre>' );
	echo( 'array_slice( $array, 1, 4 )' );
	print_r( array_slice( $array, 1, 4 ) );
	echo( '</pre>' );
	
	echo( '<pre>' );
	echo( 'array_slice( $array, 2, 4 )' );
	print_r( array_slice( $array, 2, 4 ) );
	echo( '</pre>' );
	
	echo( '<pre>' );
	echo( 'array_slice( $array, 8, 2 )' );
	print_r( array_slice( $array, 8, 2 ) );
	echo( '</pre>' );
	
	echo( '<pre>' );
	echo( 'array_slice( $array, 2, NULL )' );
	print_r( array_slice( $array, 2, NULL ) );
	echo( '</pre>' );
	
	echo( '<pre>' );
	echo( 'array_slice( $array, NULL, 2 )' );
	print_r( array_slice( $array, NULL, 2 ) );
	echo( '</pre>' );
	
	echo( '<pre>' );
	echo( 'array_slice( $array, NULL, NULL )' );
	print_r( array_slice( $array, NULL, NULL ) );
	echo( '</pre>' );
*/
	//
	// Test defines.
	//
	define( "pippo", 'pappa' );
	
	$x = pippo;
	$y = ${$x};
	echo( "[$x] [$y]<br>" );
	
?>
