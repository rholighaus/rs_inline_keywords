<?php
    function HookInline_keywordsSearchAdditionalheaderjs()
    {
        ?>
            <script type='text/javascript'>
                jQuery(document).ready(function() {
                    //jQuery(".keywordPanel").css('display','block');
                });
            </script>
                
        <?php
        return true;
  }

  function HookInline_keywordsSearchSearchbarbottomtoolbar()
  {
        global $lang, $inline_keywords_usertype, $inline_keywords_editable_fields;
        if(checkperm($inline_keywords_usertype))
            {
            ?>
            <div id="SearchBoxPanel" class="keywordPanel">
              <div class="SearchSpace">
                <h2><?php echo $lang["editfields"]; ?></h2>
                <p><?php echo $lang['keywordstoresource']; ?></p>
                
                <form id="manipulateKeywords">
                  <span class="wrap">
					<?php
				foreach(array_reverse($inline_keywords_editable_fields) as $field)
					{
					$label_result = sql_query("select title from resource_type_field where ref = '$field'");
					$label = ($label_result[0]['title']);
					
                    echo "<p>";
                        echo "<label for='ref_$field'>$label</label>";
                        echo "<input id='ref_$field' name='ref_$field' class='SearchWidth'/>";
                    echo "</p>";
					} ?>
                  </span>
                  <!--<input type="button" id="selectAllResourceButton" value="<?php echo $lang["selectall"]; ?>">
                  <input type="button" id="clearSelectedResourceButton" value="<?php echo $lang["unselectall"]; ?>">-->
                  <input type="checkbox" checked="checked" id="appendResourcesButton" name="append" value="append"><?php echo $lang["appendresources"]; ?>
                  <input type="button" id="submitSelectedResourceButton" value="<?php echo $lang["submitchanges"]; ?>">
                  <input type="button" id="archiveResourcesButton" value="<?php echo $lang["archiveresources"]; ?>">
                </form>
              </div>
            </div>
        <?php }
    }

?>
