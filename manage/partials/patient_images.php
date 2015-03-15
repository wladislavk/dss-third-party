<?php namespace Ds3\Legacy; ?>    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" class="table table-bordered table-hover">
        <tr class="tr_bg_h">
            <th valign="top" class="col_head <?php echo  ($_REQUEST['sort'] == 'imagetypeid')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
                <a href="<?php echo  $_SERVER['PHP_SELF']; ?>?<?php echo  isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=imagetypeid&sortdir=<?php echo ($_REQUEST['sort']=='imagetypeid'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Image Type</a>
            </th>
            <th valign="top" class="col_head <?php echo  ($_REQUEST['sort'] == 'title')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="25%">
                <a href="<?php echo  $_SERVER['PHP_SELF']; ?>?<?php echo  isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=title&sortdir=<?php echo ($_REQUEST['sort']=='title'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Title</a>
            </th>
            <th valign="top" class="col_head <?php echo  ($_REQUEST['sort'] == 'adddate')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
                <a href="<?php echo  $_SERVER['PHP_SELF']; ?>?<?php echo  isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=adddate&sortdir=<?php echo ($_REQUEST['sort']=='adddate'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Add Date</a>
            </th>
            <th valign="top" class="col_head <?php echo  ($_REQUEST['sort'] == 'added_by')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
                <a href="<?php echo  $_SERVER['PHP_SELF']; ?>?<?php echo  isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=added_by&sortdir=<?php echo ($_REQUEST['sort']=='added_by'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Added By</a>
            </th>
            <th valign="top" class="col_head" width="10%">
                Preview
            </th>

    		<?php if($office_type == DSS_OFFICE_TYPE_FRONT) { ?>
                <th valign="top" class="col_head" width="20%">
                    Actions
                </th>
    		<?php } ?>
        </tr>
        <?php if(count($my) == 0) { ?>
            <tr class="tr_bg">
                <td valign="top" class="col_head" colspan="10" align="center">
                    No Records
                </td>
            </tr>
        <?php } else {
                if ($my) foreach ($my as $myarray) {
                    if($myarray["status"] == 1) {
                        $tr_class = "tr_active";
                    } else {
                        $tr_class = "tr_inactive";
                    }
                    $i_type_sql = "select * from dental_imagetype where imagetypeid='".$myarray["imagetypeid"]."'";

                    $i_type_myarray = $db->getRow($i_type_sql);
        ?>
                    <tr class="<?php echo $tr_class;?>">
                        <td valign="top">
                            <?php if($myarray['imagetypeid']==0){ ?>
                                Clinical Photos (Pre-Tx)
                            <?php } else { ?>
                            <?php echo st($i_type_myarray["imagetype"]);?>
                            <?php } ?>
                        </td>
                        <td valign="top">
                            <?php echo st($myarray["title"]);?>
                        </td>
                        <td valign="top">
                            <?php echo date('M d, Y H:i', strtotime(st($myarray["adddate"])));?>
                        </td>
        				<td valign="top">
        					<?php echo $myarray['added_by']; ?>
        				</td>
                        <td valign="top">
                            <a href="display_file.php?f=<?php echo addslashes($myarray["image_file"]);?>" target="_blank" class="btn btn-default btn-sm">
                                Preview
                                <span class="glyphicon glyphicon-eye-open"></span>
                            </a>
                        </td>
				        <?php if($office_type == DSS_OFFICE_TYPE_FRONT) { ?>
                            <td valign="top">
                                <a href="Javascript:;"  onclick="Javascript: loadPopupRefer('add_image.php?ed=<?php echo $myarray["imageid"];?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>&sh=<?php echo (!empty($_GET['sh']) ? $_GET['sh'] : ''); ?>');" class="editlink btn btn-primary btn-sm" title="EDIT">
                                    Edit
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                                <a href="<?php echo $_SERVER['PHP_SELF']?>?pid=<?php echo $_GET['pid'];?>&delid=<?php echo $myarray["imageid"];?>&sh=<?php echo (!empty($_GET['sh']) ? $_GET['sh'] : ''); ?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink btn btn-danger btn-sm" title="DELETE">
                                    Delete
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>
                            </td>
				        <?php } ?>
                    </tr>
        <?php   }
            }
        ?>
</table>

