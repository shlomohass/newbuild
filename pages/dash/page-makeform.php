<?php
Trace::add_step(__FILE__,"Loading Sub Page: dash -> makeform");


/****************************** Load  Page Data ***********************************/
Trace::add_step(__FILE__,"Loading Forms available");
$Page->variable("all-forms-build", $Page::$conn->get("form_struct"));
$Page->variable("all-blocks", $Page::$conn->get("blocks"));
$Page->variable("all-forms-blocks", $Page::$conn->get("form_struct_blocks"));

/****************************** Manipulate Some data ******************************/
//Sort the index of the types available:
if (!empty($Page->variable("all-forms-build"))) {
    $temp_arr = $Page->variable("all-forms-build");
    usort($temp_arr, function($a,$b){  return $a["form_struct_index"]-$b["form_struct_index"];});
    $Page->variable("all-forms-build", $temp_arr);
    unset($temp_arr);
}
//Open jsons in the blocks:
if (!empty($Page->variable("all-blocks"))) {
    $res = array();
    foreach ($Page->variable("all-blocks") as $key => $block) {
        $res[$key] = $block;
        $res[$key]['block_name'] = json_decode($block['block_name'], true);
        $res[$key]['block_help'] = json_decode($block['block_help'], true);
    }
    $Page->variable("all-blocks", $res);
     unset($res);
}
//Sort the blocks by names:
/*
if (!empty($Page->variable("all-blocks"))) {
    $temp_arr = $Page->variable("all-blocks");
    usort($temp_arr, function($a,$b){ return strcmp($a['title'], $b['title']); });
    $Page->variable("all-blocks", $temp_arr);
    unset($temp_arr);
}
*/
//Group the blocks allowed on a form:
if (!empty($Page->variable("all-forms-blocks"))) {
    $res = array();
    foreach($Page->variable("all-forms-blocks") as $key => $block) {
        if (!isset($res[$block["struct_blocks_id_struct"]]))
            $res[$block["struct_blocks_id_struct"]] = array();
        $res[$block["struct_blocks_id_struct"]][] = array("block" => $block["struct_blocks_id_block"], "block-max" => $block["struct_blocks_max"]);
    }
    $Page->variable("all-forms-blocks", $res);
    unset($res);
}

/****************************** Page Debugger Output ***********************************/
Trace::reg_var("all-forms", $Page->variable("all-forms-build"));
Trace::reg_var("all-blocks", $Page->variable("all-blocks"));
Trace::reg_var("forms-blocks", $Page->variable("all-forms-blocks"));

?>
<h2><?php Lang::P("page_makeform_title"); ?></h2>
<div class="container-fluid">
    <div class="row dev">
        <h4>בחר תבנית טופס</h4>
        <div class="dash-make-select col-sm-12">
            <div class="dash-make-select-types">
                <?php
                    //TODO: escape title {help} from html entities.
                    foreach($Page->variable("all-forms-build") as $key => $form) {
                        //Skips disabled forms structures:
                        if (isset($form['form_struct_enable']) && $form['form_struct_enable'] == 0) continue;
                        
                        //Get the object for lang support:
                        $form['form_struct_name'] = json_decode($form['form_struct_name'], true);
                        $form['form_struct_help'] = json_decode($form['form_struct_help'], true);
                        
                        //If the lang is present print it otherwise try to print the english version:
                        if (isset($form['form_struct_name'][Lang::get_langCode().'-name'])) {
                            echo "<div class='dev' title='".$form['form_struct_help'][Lang::get_langCode().'-desc']."'>".
                                $form['form_struct_name'][Lang::get_langCode().'-name'].
                                "</div>";
                        } elseif(isset($form['form_struct_name']['en-name'])) {
                            echo "<div class='dev' title='".$form['form_struct_help']['en-name']."'>".
                                $form['form_struct_name']['en-name'].
                                "</div>";
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <br />
    <div>
        <div class="row  dev">
            <div class="dash-make-view col-sm-4 dev">
                <h4>חלונית צפייה</h4>
            </div>
            <div class="dash-make-build col-sm-8 dev">
                <h4>יצירת הטופס</h4>
                <form clas="dash-make-formele-build dev">
                    <div class="dash-make-add-ele">
                        <select name="" class="">
                            <?php
                            
                            ?>
                        </select>
                        <input type="button" value="הוסף" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>