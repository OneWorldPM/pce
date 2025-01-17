<?php
if (isset($_GET['testing']))
{
    echo "<pre>";
    print_r($sessions_data);
    exit ("</pre>");
}
?>

<div class="main-content" >
    <div class="wrap-content container" id="container">
        <div class="container-fluid container-fullw bg-white">
            <?php if (!isset($sessions_data)) { ?>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-primary" id="panel5">
                            <div class="panel-heading">
                                <h4 class="panel-title text-white">Import Poll</h4>
                            </div>
                            <div class="panel-body bg-white" style="border: 1px solid #b2b7bb;">
                                <form class="form-login" id="frm_poll_data" name="frm_poll_data" enctype="multipart/form-data" method="post" action="<?= base_url() ?>admin/sessions/importSessionsPoll/<?=$sessions->sessions_id?>">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <a href="<?= base_url() ?>uploads/sample2.csv" download>Download Sample CSV</a>
                                        </div>  
                                        <?php if (isset($sessions)) { ?>    
                                            <input type="hidden" name="sessions_id" value="<?= $sessions->sessions_id ?>">
                                        <?php } ?> 
                                        <div class="form-group">
                                            <label class="text-large">Select Choose File :</label>
                                            <label id="projectinput8" class="file center-block">
                                                <input type="file" name="sessions_poll_file" accept=".csv" id="sessions_poll_file">
                                                <span class="file-custom"></span>
                                            </label><br>
                                            <span id="errorsessions_poll_file" style="color:red;"></span>
                                        </div>
                                    </div>
                                    <div class="form-actions center">
                                        <button type="submit" id="btn_save" class="btn btn-info">
                                            <i class="la la-check-square-o"></i> Import Poll From CSV
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-primary" id="panel5">
                        <div class="panel-heading">
                            <h4 class="panel-title text-white">Create Poll
                                <?php if(isset($presenter)): ?>
                                    Session <?=$presenter->sessions_id?> -
                                <?php if(isset($presenter->presenter)&& !empty($presenter->presenter)): ?>
                                    <?php foreach($presenter->presenter as $presenterData): ?>
                                        <?=$presenterData->presenter_name?> |
                                    <?php endforeach; ?>
                                    <?php endif;?>
                                    <?=$presenter->session_title?>
                                <?php endif; ?>
                            </h4>
                        </div>
                        <div class="panel-body bg-white" style="border: 1px solid #b2b7bb;">
                            <form name="frm_add_Poll" id="frm_add_Poll" method="POST" >
                                <?php if (isset($sessions_data)) { ?>
                                    <input type="hidden" id="sessions_id" name="sessions_id" value="<?= $sessions_data->sessions_id ?>">
                                    <input type="hidden" name="sessions_poll_question_id" value="<?= $sessions_data->sessions_poll_question_id ?>">
                                <?php } ?>
                                <?php if (isset($sessions)) { ?>    
                                    <input type="hidden" name="sessions_id" value="<?= $sessions->sessions_id ?>">
                                <?php } ?>    
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <div class="form-group">
                                            <label class="text-large">Question:</label>
                                            <textarea type="text" name="question" id="question"  placeholder="Question" class="form-control text-dark" rows="3"><?= isset($sessions_data) ? $sessions_data->question : "" ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-large">Poll Name:</label>
                                            <input type="text" name="poll_name" id="poll_name" value="<?= isset($sessions_data) ? $sessions_data->poll_name : "" ?>" placeholder="eg; Presurvey 1" class="form-control">
                                        </div>
										<div class="form-group">
                                            <label class="text-large">Slide Number:</label>
                                            <input type="text" name="slide_number" id="slide_number" value="<?= isset($sessions_data) ? $sessions_data->slide_number : "" ?>" placeholder="Slide Number" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label class="text-large">Instruction:</label>
                                            <input type="text" name="poll_instruction" id="poll_instruction" value="<?= isset($sessions_data) ? $sessions_data->poll_instruction : "" ?>" placeholder="Slide Number" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label class="text-large">External Reference:</label>
                                            <input type="text" name="external_reference" id="external_reference" value="<?= isset($sessions_data->external_reference) ? $sessions_data->external_reference : "" ?>" placeholder="External Reference" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label class="text-large">Select Poll Type:</label>
                                            <select class="form-control" id="poll_type_id" name="poll_type_id">
                                                <option value="">Select Poll Type</option>
                                                <?php
                                                if (isset($poll_type) && !empty($poll_type)) {
                                                    foreach ($poll_type as $value) {
                                                        ?>
                                                        <option value="<?= $value->poll_type_id ?>" <?= isset($sessions_data) ? ($sessions_data->poll_type_id == $value->poll_type_id) ? "selected" : "" : "" ?>><?= $value->poll_type ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="text-large">Option:</label>
                                            <?php
                                            if (isset($sessions_data->option) && !empty($sessions_data->option)) {
                                                foreach ($sessions_data->option as $key => $value) {
                                                    $key++;
                                                    ?>
                                                    <input type="text" name="option_<?= $key ?>" id="option_<?= $key ?>" value="<?= htmlspecialchars($value->option) ?>" placeholder="Option <?= $key ?>" class="form-control input_cust_class">
                                                    <?php
                                                }
                                                $total = 10;
                                                $edit = sizeof($sessions_data->option);
                                                $edit = $edit + 1;
                                                for ($i = $edit; $i <= $total; $i++) {
                                                    ?>
                                                    <input type="text" name="option_<?= $i ?>" id="option_<?= $i ?>" value="" placeholder="Option <?= $i ?>" class="form-control input_cust_class">
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <input type="text" name="option_1" id="option_1" placeholder="Option 1" class="form-control input_cust_class">
                                                <input type="text" name="option_2" id="option_2" placeholder="Option 2" class="form-control input_cust_class">
                                                <input type="text" name="option_3" id="option_3" placeholder="Option 3"  class="form-control input_cust_class">
                                                <input type="text" name="option_4" id="option_4" placeholder="Option 4" class="form-control input_cust_class">
                                                <input type="text" name="option_5" id="option_5" placeholder="Option 5"  class="form-control input_cust_class">
                                                <input type="text" name="option_6" id="option_6" placeholder="Option 6" class="form-control input_cust_class">
                                                <input type="text" name="option_7" id="option_7" placeholder="Option 7" class="form-control input_cust_class">
                                                <input type="text" name="option_8" id="option_8" placeholder="Option 8" class="form-control input_cust_class">
                                                <input type="text" name="option_9" id="option_9" placeholder="Option 9" class="form-control input_cust_class">
                                                <input type="text" name="option_10" id="option_10" placeholder="Option 10"class="form-control input_cust_class">
                                            <?php } ?>
                                        </div>

                                        <div class="form-group">
                                            <label class="text-large">Correct Answer1:</label><br>
                                            <select class="form-control" name="correct_answer1" id="correct_answer1">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-large">Correct Answer 2:</label><br>
                                            <select class="form-control" name="correct_answer2" id="correct_answer2">
                                                <option value=""></option>
                                            </select>
                                            <p><small style="color:red"> If answers are empty, no correct answer will be indicated on poll result. If correct answer will be activated, then a green checkmark appears beside the correct answer on the poll result </small></p>
                                        </div>

                                        <?php
                                        if (!isset($sessions_data) && empty($sessions_data)) {
                                            ?>
                                            <div class="form-group">
                                                <label class="text-large">Poll Comparisons with:</label>
                                                <select class="form-control" id="poll_comparisons_with_us" name="poll_comparisons_with_us">
                                                    <option value="">Select Poll Comparison</option>
                                                    <?php
                                                    if (isset($poll_type) && !empty($poll_type)) {
                                                        foreach ($poll_type as $value) {
                                                            ?>
                                                            <option value="<?= $value->poll_type_id ?>" <?= isset($sessions_data) ? ($sessions_data->poll_type_id == $value->poll_type_id) ? "selected" : "" : "" ?>><?= $value->poll_type ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <?php
                                        }else{ ?>
                                            <div class="form-group">
                                                <label class="text-large">Poll Comparisons with:</label>
                                                <select class="form-control" id="poll_comparisons_id" name="poll_comparisons_id">
                                                    <option value="0">None</option>
                                                    <?php
                                                    if (isset($sessions_data->all_other_surveys) && !empty($sessions_data->all_other_surveys)) {
                                                        foreach ($sessions_data->all_other_surveys as $survey) {
                                                            ?>
                                                            <option value="<?= $survey->sessions_poll_question_id ?>" <?=(isset($sessions_data->comparison_with) && $survey->sessions_poll_question_id == $sessions_data->comparison_with[0]->sessions_poll_question_id)?"selected": ""?>><?= $survey->poll_name ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        <?php }
                                        ?>
                                        <h5 class="over-title margin-bottom-15">
                                            <button type="button" id="<?= isset($sessions_data) ? "edit_create_poll" : "save_create_poll" ?>" name="<?= isset($sessions_data) ? "edit_create_poll" : "save_create_poll" ?>" class="btn btn-green add-row">
                                                Submit
                                            </button>
                                        </h5>
                                    </div>
                                </div>
                            </form>    
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- end: DYNAMIC TABLE -->
    </div>
</div>
<?php
$msg = $this->input->get('msg');
switch ($msg) {
    case "S":
        $m = "Poll Added Successfully...!!!";
        $t = "success";
        break;
    case "U":
        $m = "Poll Updated Successfully...!!!";
        $t = "success";
        break;
    case "D":
        $m = "Poll Delete Successfully...!!!";
        $t = "success";
        break;
    case "E":
        $m = "Something went wrong, Please try again!!!";
        $t = "error";
        break;
    default:
        $m = 0;
        break;
}
?>

<script>

    $(document).ready(function () {

<?php if ($msg): ?>
            alertify.<?= $t ?>("<?= $m ?>");
<?php endif; ?>

        $('#plan_table').dataTable({
            "aaSorting": []
        });

//        $('.input_cust_class').keypress(function (e) {
//            var tval = $(this).val(),
//                    tlength = tval.length,
//                    set = 25,
//                    remain = parseInt(set - tlength);
//            if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
//                $(this).val((tval).substring(0, tlength - 1));
//                return false;
//            }
//        })

        $("#btn_save").on("click", function () {
            if ($('#sessions_poll_file').val() == '') {
                alertify.error('Select File');
                return false;
            } else {
                return true; //submit form
            }
            return false; //Prevent form to submitting
        });

        $('#save_create_poll').click(function () {

            if ($('#question').val() == '') {
                alertify.error('Please Enter Question');
                return false;
            } else if ($('#poll_type_id').val() == '') {
                alertify.error('Please Select Poll Type');
                return false;
            } else if ($('#option_1').val() == '') {
                alertify.error('Please Enter Option 1');
                return false;
            } else if ($('#option_2').val() == '') {
                alertify.error('Please Enter Option 2');
                return false;
            } else if($('#external_reference').val()==''){
                alertify.error('External Reference Is Required');
                return false;
            }
            else {

            let allOptions = $('.input_cust_class');
            let optionValues = [];
            for (option = 0; option < allOptions.length; option++)
            {
                if((allOptions[option]).value != '')
                {
                    optionValues.push((allOptions[option]).value);
                }
            }

            if(new Set(optionValues).size !== optionValues.length)
            {
                alertify.error('You have duplicate options');
                let optionValues = [];
                return false;
            }


                $('#frm_add_Poll').attr('action', '<?= base_url() ?>admin/sessions/add_poll_data');
                $('#frm_add_Poll').submit();
                return true;
            }
        });

        $('#edit_create_poll').click(function () {
            if ($('#question').val() == '') {
                alertify.error('Please Enter Question');
                return false;
            } else if ($('#poll_type_id').val() == '') {
                alertify.error('Please Select Poll Type');
                return false;
            } else if ($('#option_1').val() == '') {
                alertify.error('Please Enter Option 1');
                return false;
            } else if ($('#option_2').val() == '') {
                alertify.error('Please Enter Option 2');
                return false;
            } else if($('#external_reference').val()=='') {
                alertify.error('External Reference Is Required');
                return false;
            }
                else {

            let allOptions = $('.input_cust_class');
            let optionValues = [];
            for (option = 0; option < allOptions.length; option++)
            {
                if((allOptions[option]).value != '')
                {
                    optionValues.push((allOptions[option]).value);
                }
            }
            if(new Set(optionValues).size !== optionValues.length)
            {
                alertify.error('You have duplicate options');
                let optionValues = [];
                return false;
            }
            
                var sessions_id = $('#sessions_id').val();
                $('#frm_add_Poll').attr('action', '<?= base_url() ?>admin/sessions/update_poll_data/'+sessions_id);
                $('#frm_add_Poll').submit();
                return true;
            }
        });



    });
</script>
<script>
    var correct_answer1 = "<?=$sessions_data->correct_answer1?>";
    var correct_answer2 = "<?=$sessions_data->correct_answer2?>";
</script>
<script>
    $(function(){

        option_answer('correct_answer1', correct_answer1);
        option_answer('correct_answer2', correct_answer2);

        $('.input_cust_class').change(function(){
            option_answer('correct_answer1', correct_answer1);
            option_answer('correct_answer2', correct_answer2);

        });

        function option_answer(answer_index, correct_answer){

            var selected = '';
            var max_option =10;
            $('#'+answer_index+'').html('').append('<option value=""></option>');
            for (var i=1; i <= max_option; i++){
                if(correct_answer == i){
                    selected = 'selected';
                }else{
                    selected ='';
                }
                if($("#option_"+i+".input_cust_class").val() !== ''){
                    $('#'+answer_index+'').append('<option value="'+i+'" id="opttion_'+i+'" '+selected+'>Option '+i+'</option>');
                }else{
                    $('#'+answer_index+' #option_'+i+'').remove();
                }
            }
        }
    });
</script>








