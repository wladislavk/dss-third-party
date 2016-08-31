<style src="../../../../../assets/css/manage/admin.css" scoped></style>
<style src="../../../../../assets/css/manage/form.css" scoped></style>
<style src="../../../../../assets/css/manage/device_guide.css" scoped></style>

<template>
    <div style="margin-left: 30px;">
        <a href="#" onclick="$('#instructions').show('200');$(this).hide();return false;" id="ins_show">Instructions</a>
        <div id="instructions" style="display:none;">
            <strong>Instructions</strong> <a href="#" onclick="$('#instructions').hide('200');$('#ins_show').show();">hide</a>
            <ol>
                <li>Evaluate pt for each category using sliding bar</li>
                <li>Choose the three most important categories (if needed)</li>
                <li>Click on Sort Devices</li>
                <li>Click the device to add to Pt chart, or click "Reset" to start over.</li>
            </ol>
        </div>
    </div>

    <h2 style="margin-top:20px;">Device C-Lect for {{ firstname + ' ' + lastname }}?</h2>

    <form action="device_guide_results.php" method="post" id="device_form" style="border:solid 2px #cce3fc;padding:0 10px 0 25px; width:24%; margin-left:2%; float:left;">
        <input type="hidden" name="id" value="{{ $route.query.id }}" />
        <input type="hidden" name="pid" value="{{ $route.query.pid }}" />

        <div
            v-if="s_q.length > 0"
            v-for="s_r in s_q"
            class="setting"
            id="setting_{{ s_r.id }}"
            style="padding: 5px 0;"
        >
            <strong style="padding: 5px 0;display:block;">{{ s_r.name }}</strong>
            <template v-if="s_r.setting_type == DSS_DEVICE_SETTING_TYPE_RANGE">
                <div class="slider" id="slider_{{ s_r.id }}"></div>
                <input type="checkbox" class="imp_chk" value="1" name="setting_imp_{{ s_r.id }}" id="setting_imp_{{ s_r.id }}" />
                <div class="label" id="label_{{ s_r.id }}" style="padding: 5px 0;display: block;"></div>
                <input type="hidden" name="setting{{ s_r.id }}" id="input_opt_{{ s_r.id }}" />

                <?php
                    $o_sql = "SELECT * FROM dental_device_guide_setting_options WHERE setting_id='".mysqli_real_escape_string($con,$s_r['id'])."' ORDER BY option_id ASC";
                    
                    $o_q = $db->getResults($o_sql);
                    $setting_options = count($o_q);
                    $setting_options = (($setting_options != 1) ? $setting_options : 2);
                    $range_step = ($s_r['range_end']-$s_r['range_start'])/($setting_options-1);
                  ?>

                  <?php
                    $labelArray = ""; 
                    if ($o_q) foreach ($o_q as $o_r){ 
                      $labelArray .= ',' . $o_r['label'] . '';
                    }
                  ?>

                  <script type="text/javascript">
                    setSlider("<?php echo $labelArray; ?>", <?php echo  $s_r['id']; ?>, <?php echo  $s_r['range_start']; ?>, <?php echo $s_r['range_end']; ?>, <?php echo $range_step; ?>);
                  </script>
            </template>
            <template v-else>
                <input type="checkbox" name="setting{{ s_r.id }}" value="1" />
            </template>
        </div>
    </form>

    <div style="float:left; width: 13%; margin-left:2%;">
        <a href="#" style="border:1px solid #000; padding: 5px;" class="device_submit addButton">Sort Devices</a>
    </div>

    <div style="float:left; width:50%;">
        <ul id="results" style="border:solid 2px #a7cefa;">
        </ul>
        <a href="#" class="addButton" onclick="reset_form();return false;">Reset</a>
    </div>
</template>

<!-- <script type="text/javascript" src="../js/device_guide.js"></script> -->

<script>
    module.exports = require('./deviceSelector.js');
</script>