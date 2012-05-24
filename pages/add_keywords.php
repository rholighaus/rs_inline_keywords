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
			        add_keyword_mappings($ref, $keyword,$type);
			    	}
			    $inline_keyword_data = sql_query("SELECT * FROM resource_data WHERE resource_type_field = '$type'  AND resource = '$ref'");
			    if($inline_keyword_data)
			        {
			        $keywordstring = implode(', ',array_unique(array_merge($keywords, explode(', ',$inline_keyword_data[0]['value']))));
					sql_query("UPDATE resource_data  SET value = '$keywordstring' WHERE resource_type_field = '$type'  AND resource = '$ref'");
			        }
			    else
			        {
			        $keywordstring = implode(' ',$keywords);
			        sql_query("INSERT INTO resource_data(resource, resource_type_field, value) VALUES($ref, $type, '$keywordstring')");
			        }
		    	}
			}
		}
	}
?>
