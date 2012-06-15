<form method="POST" action="#" style="width:100%;">
        <?php
                $loc_sql = "SELECT * FROM dental_locations WHERE docid='".$docid."'";
                $loc_q = mysql_query($loc_sql);
        ?>
                <select name="location">
                        <option value="">Select</option>
        <?php
                while($loc_r = mysql_fetch_assoc($loc_q)){
                        ?><option <?= ($location==$loc_r['id'])?'selected="selected"':''; ?>value="<?= $loc_r['id']; ?>"><?= $loc_r['location']; ?></option><?php
                }
        ?>
                </select>
<br />
<input type="submit" name="locsubmit" value="Save Office Site">
</form>
