<?php namespace Ds3\Legacy; ?><form method="POST" action="#" style="width:100%;">
        <?php
                $loc_sql = "SELECT * FROM dental_locations WHERE docid='".$docid."'";
                
                $loc_q = $db->getResults($loc_sql);
        ?>
                <select name="location">
                        <option value="">Select</option>
                        <?php if ($loc_q) foreach ($loc_q as $loc_r){ ?>
                                <option <?php echo  ($location==$loc_r['id'])?'selected="selected"':''; ?>value="<?php echo  $loc_r['id']; ?>"><?php echo  $loc_r['location']; ?></option>
                        <?php } ?>
                </select>
<input type="submit" name="locsubmit" value="Save Office Site">
</form>
