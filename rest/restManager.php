<?php 
// header('Content-Type: application/json');
// header('Access-Control-Allow-Origin: http://localhost:4200');
// header('Access-Control-Allow-Headers: Content-Type');
// header('Access-Control-Allow-Methods: POST, GET, PUT, PATCH, DELETE, OPTIONS');


$json = '{
	"data": [{
        "type": "rentals",
        "id": 1,
        "attributes": {
          "title": "Grand Old Mansion",
          "owner": "Veruca Salt",
          "city": "San Francisco",
          "type": "Estate",
          "bedrooms": 15,
          "image": "https://upload.wikimedia.org/wikipedia/commons/c/cb/Crane_estate_(5).jpg"
        }
      }, {
        "type": "rentals",
        "id": 2,
        "attributes": {
          "title": "Urban Living",
          "owner": "Mike Teavee",
          "city": "Seattle",
          "type": "Condo",
          "bedrooms": 1,
          "image": "https://upload.wikimedia.org/wikipedia/commons/0/0e/Alfonso_13_Highrise_Tegucigalpa.jpg"
        }
      }, {
      	"type": "posts",
      	"id": 1,
      	"attributes": {
      		"title": "An Awesome Blog Post",
      		"body": "This is the best blog post ever.",
      		"author": 1
      }
    },{
    	"type": "authors",
    	"id": 1,
    	"attributes": {
    		"first-name": "Andy",
    		"last-name": "Crum",
    		"posts": [ 1 ]
    	}
    }]
    }';

// echo $json;
    $user = "root";
    $pass = "root";
    $db = "ember";
    $dbh = new PDO('mysql:host=localhost;dbname='.$db, $user, $pass);
    $path_parts = explode('/', $_SERVER['REQUEST_URI']);
    // print_r($path);
    $path = $path_parts['2'];
    $id = null;
    if($path_parts['3'])
    	$id = $path_parts['3'];
    $table = substr($path, 0, -1);
    $json_empty = '{"data":[]}';
    // echo $table;
    switch ($_SERVER['REQUEST_METHOD']) {
      // read record
    	case 'GET':
    		select($dbh,$table,$id);

    		break;
      // delete record
      case 'DELETE':
        delete($dbh,$table,$id);
        break;
      //update record
      case 'PATCH':
        $json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);
        $records = $obj['data']['attributes'];
        $id = $obj['data']['id'];

        update($dbh,$table,$records,$id);
        break;
      // create record
    	case 'POST':
    		$json = file_get_contents('php://input');
    		$obj = json_decode($json, TRUE);
        $records = $obj['data']['attributes'];

    		add($dbh,$table,$records);
    		break;	
    	default:
    		echo("Invalid method ".$_SERVER['REQUEST_METHOD']);
    		break;
    }

    function update($dbh,$table,$records,$id){

        $prep = '';
        $json_row = '';
        $j = 0;
        $len = count($records);
        foreach($records as $key => $val)
        {
         if($j < $len-1)
         {
           $prep .= $key." = :".$key.", ";
           }
         else
         {
           $prep .= $key." = :".$key;
           }
         $j++;
        }
        $updateSQL = 'UPDATE '.$table.' SET '.$prep.' WHERE id = '.$id;
        // $stmt = $dbh->prepare('INSERT INTO '.$table.' ('.$fields.') VALUES ('.$prep.')');
      try{
        $stmt = $dbh->prepare($updateSQL);
        // bindParam needs &$variable
        $i = 0;
        foreach($records as $key => &$val)
        {
          $stmt->bindParam(':'.$key, $val, PDO::PARAM_STR);
          if($i < $len-1)
            $json_row .= '"'.$key.'": "'.$val.'",
            ';
          else
            $json_row .= '"'.$key.'": "'.$val.'"';
          $i++;
        }
        $stmt->execute();
        $stmt->closeCursor();

        $json .= '{
              "id": "'.$id.'",
              "type": "'.$table.'",
              "attributes": {
                '.$json_row.'
              }
            }';
        // print_r($updateSQL);
        // echo $json = '{"data":['.$json.']}';
        // return updated record will cause error somehow...
        echo http_response_code(204);

      }catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        echo("Add error.");
        die();
    }
    }

    function delete($dbh,$table,$id){
      try{
          $count = $dbh->exec("DELETE FROM ".$table." WHERE id = '".$id."'");
          //For delete action, ember expect 200 with {} response or 204 with empty response
          echo http_response_code(204);
        }catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        echo("delete error.");
        die();
      }
      
    }


    
    function add($dbh,$table,$records){
      
        $fields = '';
        $prep = '';
        $json_row = '';
        $i = 0;
        $len = count($records);
        foreach($records as $key => $val)
        {
          //serialize 
          if($key=="first-name")
            $key="firstName";

          if($key=="last-name")
            $key="lastName";

         if($i < $len-1)
         {
           $fields .= $key.",";
           $prep .= ":".$key.",";
           // $values .= $val.",";
           }
         else
         {
           $fields .= $key;
           $prep .= ":".$key;
           // $values .= $val;
           }
         $i++;
        }
        $insertSQL = 'INSERT INTO '.$table.' ('.$fields.') VALUES ('.$prep.')';
        // $stmt = $dbh->prepare('INSERT INTO '.$table.' ('.$fields.') VALUES ('.$prep.')');
      try{
        $stmt = $dbh->prepare($insertSQL);
        // bindParam needs &$variable
        $i = 0;
        foreach($records as $key => &$val)
        {
          //serialize
          if($key=="first-name")
            $key="firstName";

          if($key=="last-name")
            $key="lastName";

          $stmt->bindParam(':'.$key, $val, PDO::PARAM_STR);
          if($i < $len-1)
            $json_row .= '"'.$key.'": "'.$val.'",
            ';
          else
            $json_row .= '"'.$key.'": "'.$val.'"';
          $i++;
        }
        $stmt->execute();
        $stmt->closeCursor();

        $id = $dbh->lastInsertId();
        $json .= '{
              "id": "'.$id.'",
              "type": "'.$table.'",
              "attributes": {
                '.$json_row.'
              }
            }';
        // echo $records;
        // echo $json = '{"data":['.$json.']}';
        echo http_response_code(204);

      }catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        echo("Add error.");
        die();
    }
    }

    function select($dbh,$table,$id){
    	$json = '';
    	$json_row = '';
    try {
	    if(!$id)
	    $selectSQL = 'SELECT * from '.$table;
		else
			$selectSQL = 'SELECT * from '.$table.' WHERE id='.$id;
	    $j = 0;
      $stmt = $dbh->prepare($selectSQL);
      $stmt->execute();
      // Get Unique results
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		  $row_count = $stmt->rowCount();
		  // print_r($row_count);
	    foreach($results as $row => $value) {
	    	$i = 0;
	    	$len = count($value);
	    	// print_r($row);
	    	// print_r($len);
	        foreach($value as $key => $val)
	        {
	        	// print_r($key.": ".$val);
	        	if($key!="id")
	        	{
	        		if($key=="firstName")
	        			$key="first-name";
	        		if($key=="lastName")
	        			$key="last-name";

	        		if($i < $len-1)
	        			$json_row .= '"'.$key.'": "'.$val.'",
	        			';
	        		else
	        			$json_row .= '"'.$key.'": "'.$val.'"';
	        	}
	        	 
	        $i++;
	        }

	        if($j < $row_count-1)
	        {
	        	$json .= '{
	        		"id": "'.$value['id'].'",
	        		"type": "'.$table.'",
	        		"attributes": {
	        			'.$json_row.'
	        		}
	        	},';
	        }
	        else
	        {
	        	$json .= '{
	        		"id": "'.$value['id'].'",
	        		"type": "'.$table.'",
	        		"attributes": {
	        			'.$json_row.'
	        		}
	        	}';
	        }
	        
	        $json_row = '';
	        $j++;
	    }

      $stmt->closeCursor();
	    $dbh = null;
	    $json = '{"data":['.$json.']}';
	    echo $json;
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    die();
		}
	}

	

?>