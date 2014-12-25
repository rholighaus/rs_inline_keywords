<?php
//function tweak_preview_images($ref,$rotateangle,$gamma,$extension="jpg")

include_once "../../../include/db.php";
include_once "../../../include/authenticate.php";if (!checkperm(checkperm($inline_keywords_usertype))) {exit("Permission denied");}
include_once "../../../include/general.php";
include_once "../../../include/resource_functions.php";

$refs  = explode(' ',str_replace('+',' ',$_POST['refs']));
unset($_POST['refs']);

//$fields = sql_query("select ref from resource_type_field where title = 'Keywords'");
//$type = ($fields[0]['ref']);

foreach($_POST as $request => $values)
{
	$formdata = explode('_', $request);
	
	if($formdata[0] == 'ref')
	{
		$type = $formdata[1];
		if($values != "")
		{
			$keywords = explode(',',$values);

			foreach($refs as $ref)
			{
			    foreach($keywords as $keyword)
			    {
				//remove_keyword_mappings($ref, $keyword, $type);
			        add_keyword_mappings($ref, $keyword,$type);
			    }

			    $inline_keyword_data = sql_query("SELECT * FROM resource_data WHERE resource_type_field = '$type'  AND resource = '$ref'");
				//sql_query("delete from resource_data where resource='$ref' and resource_type_field='" . $type . "'");

			    $oldvalues = "";
			    if($inline_keyword_data)
			    {
					$oldvalues = implode(', ',explode(', ',ltrim( $inline_keyword_data[0]['value'], ',')));
			    }
			    //1if($inline_keyword_data)
			    //1{
				  	//als add to..
  			       	
				  	//als replace..	   				  	
					//sql_query("UPDATE resource_data  SET value = '$keywordstring' WHERE resource_type_field = '$type'  AND resource = '$ref'");
					//beter deze dan eigen update..
					//$keywordstring = implode(',',$keywords);
					
	  				//resource_log(
	  				//	$resource["resource"],	"p",	0,				  "",			"",			"",		0,	$resource["purchase_size"],	$resource["purchase_price"]);
	  				//resource_log(
	  				//	$resource, $type, $field,$notes="",$fromvalue="",$tovalue="",$usage=0)
				    	

					if (isset($_POST['append']))
					{	   
						if ($type == '1') 				    	
							$values = implode(', ',array_unique(array_merge(explode(', ',ltrim( $inline_keyword_data[0]['value'], ',')), $keywords)));
						else 
							$values = $inline_keyword_data[0]['value'].' '.$values;
					}
 					
 					update_field($ref, $type, $values);
			    		resource_log($ref, 'e', $type, "", $oldvalues, $values);			    		
			    	

	  				//sql_query("INSERT INTO resource_data(resource, resource_type_field, value) VALUES($ref, $type, '$values')");
				//1}				
				
				/*else
			    {
			        $keywordstring = implode(' ',$keywords);
			        //sql_query("INSERT INTO resource_data(resource, resource_type_field, value) VALUES($ref, $type, '$keywordstring')");
			        sql_query("INSERT INTO resource_data(resource, resource_type_field, value) VALUES($ref, $type, '$values')");
			    }*/

			
	    	}
		}
	}
}
?>