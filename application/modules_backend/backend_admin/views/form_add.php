<script type="text/javascript" src="<?php echo $assets; ?>/widgets/parsley/parsley.js"></script>

<script type="text/javascript">
    var enbl_btn_process = true;

    //------submit form ajax module admin----------
    $(function() { "use strict";
        // Variable to store your files
        var files;

        // Add events
        $('input[type=file]').on('change', prepareUpload);

        // Grab the files and set them to our variable
        function prepareUpload(event)
        {
            files = event.target.files;
        }

        var param = {
            'formid'            : '#dynamic_form',
            'btn_submit'        : '#dynamic_btn_process',
            'div_errmsg'        : '#dynamic_errmsg',
            'url_ajax_action'   : '<?php echo $ajax_action_add; ?>',
            'data_type'         : 'json',
            'panel_form'        : '#panel_form',
            'panel_list'        : '#panel_list',
            'add_data'          : '#add_data',
            'dynamic_btn_close'   : '#dynamic_btn_close',
            'callback'          : function(data) {
                if(data.err_msg == '') {
                    $(param.formid).find(':input').val('');
                    refreshTable();
                    autoScrolling(param.panel_form);
                    $(param.formid).find(':input:first').focus();
                    $.jGrowl(data.success_msg, {
                        sticky: false,
                        position: 'top-right',
                        theme: 'bg-orange'
                    });
                } else {
                    $(param.div_errmsg).html(data.err_msg);
                    $(param.div_errmsg).show();
                }
                enbl_btn_process = true;
                $(param.btn_submit).attr('disabled', false);
            }
        };

        var param_file = {
            'formid'            : '#dynamic_form',
            'btn_submit'        : '#dynamic_btn_process',
            'div_errmsg'        : '#dynamic_errmsg',
            'url_ajax_action'   : '<?php echo $ajax_image_add; ?>',
            'data_type'         : 'json',
            'panel_form'        : '#panel_form',
            'panel_list'        : '#panel_list',
            'add_data'          : '#add_data',
            'dynamic_btn_close'   : '#dynamic_btn_close',
            'callback'          : function(data) {
                if(data.err_msg == '') {
                    MYAPP.doFormSubmitUpload.process(param, data);
                } else {
                    $.jGrowl(data.err_msg, {
                        sticky: false,
                        position: 'top-right',
                        theme: 'bg-green'
                    });
                    $(param.dynamic_btn_close).trigger('click');
                }
            }
        };

        $(param.formid).submit(function(){
            MYAPP.doFormSubmitUploadTmp.process(param_file, files);
            return false;
        });

        $(param.dynamic_btn_close).click(function(e) {
            e.preventDefault();
            $(param.panel_form).empty();
            autoScrolling('html, body');
        });
    });
</script>

<div class="panel-body">
	<h3 class="title-hero">
	    Add Data
	</h3>
	<?php if(!empty($form_errmsg)) : ?>
        <div class="alert alert-danger">
            <p><?php echo $form_errmsg; ?></p>
        </div>
    <?php endif; ?>

    <div id="dynamic_errmsg" class="alert alert-danger" style="display:none">
        <p></p>
    </div>
	<div class="example-box-wrapper">
        <form method="post" class="form-horizontal bordered-row" id="dynamic_form" data-parsley-validate>
            <?php foreach($input_list as $val) : ?>
                <?php if(!empty($val['db_pk'])) : ?>
                    <?php continue; ?>
                <?php endif; ?>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo $val['label']; ?></label>
                    <div class="col-sm-6">
                        <?php if($val['input_type'] == 'select') : ?>
                            <select name="<?php echo $val['db_field']; ?>" id="<?php echo $val['db_field']; ?>" <?php echo $val['input_attr']; ?> <?php echo (!empty($val['required']) ? $val['required'] : ''); ?>>
                                <option value="">-- Choose --</option>
                                <?php foreach($val['data_source'] as $vOpt) : ?>
                                    <option value="<?php echo $vOpt['value']; ?>"><?php echo $vOpt['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php elseif($val['input_type'] == 'textarea') : ?>
                            <textarea name="<?php echo $val['db_field']; ?>" id="<?php echo $val['db_field']; ?>" <?php echo $val['input_attr']; ?> <?php echo (!empty($val['data_edit']['required']) ? $val['data_edit']['required'] : ''); ?> <?php echo (!empty($val['data_edit']['input_disabled']) ? $val['data_edit']['input_disabled'] : ''); ?>></textarea>
                        <?php else : ?>
                            <input name="<?php echo $val['db_field']; ?>" id="<?php echo $val['db_field']; ?>" <?php echo $val['input_attr']; ?> <?php echo (!empty($val['required']) ? $val['required'] : ''); ?> <?php echo (!empty($val['input_disabled']) ? $val['input_disabled'] : ''); ?> />
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="bg-default content-box text-center pad20A mrg25T">
                <button class="btn btn-success" id="dynamic_btn_process">Process</button>
                <button type="reset" class="btn btn-primary" id="dynamic_btn_process">Reset</button>
                <button class="btn btn-black" id="dynamic_btn_close">Close</button>
            </div>
        </form>
    </div>
</div>