<?php
Trace::add_step(__FILE__,"Loading Sub Page: dash -> makeform");


/****************************** Load  Page Data ***********************************/
Trace::add_step(__FILE__,"Loading Forms available");
$Page->variable("all-forms-build", $Page::$conn->get("form_struct"));

/****************************** Manipulate Some data ******************************/
if (!empty($Page->variable("all-forms-build"))) {
    $temp_arr = $Page->variable("all-forms-build");
    usort($temp_arr, function($a,$b){  return $a["form_struct_index"]-$b["form_struct_index"];});
    $Page->variable("all-forms-build", $temp_arr);
    unset($tem_arr);
}

/****************************** Page Debugger Output ***********************************/
Trace::reg_var("all-forms", $Page->variable("all-forms-build"));
?>
<h2><?php Lang::P("page_makeform_title"); ?></h2>
<div class="container-fluid">
    <div class="row dev">
        <div class="dash-make-select col-sm-12">
            <h4>בחר תבנית טופס</h4>
            <div class="make-select-types">
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
                        } elseif(isset($form['form_struct_name']['en-name']) {
                            echo "<div class='dev' title='".$form['form_struct_help']['en-name']."'>".
                                $form['form_struct_name']['en-name'].
                                "</div>";
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="dash-make-settings col-sm-12 dev">
            <h4>הגדרות ומאפייני טופס</h4>
        </div>
    </div>
    <div class="row">
        <div class="dash-make-view col-sm-4 dev">
            <h4>חלונית צפייה</h4>
        </div>
        <div class="dash-make-build col-sm-8 dev">
            <h4>יצירת הטופס</h4>
        </div>
    </div>
</div>
<div class="clearfix"></div>