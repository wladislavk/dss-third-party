<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" class="table table-bordered table-hover">
        <tr class="tr_bg_h">
                <th valign="top" class="col_head <?= ($_REQUEST['sort'] == 'imagetypeid')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="20%">
                        <a href="<?= $_SERVER['PHP_SELF']; ?>?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=imagetypeid&sortdir=<?php echo ($_REQUEST['sort']=='imagetypeid'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Image Type</a>
                </th>
                <th valign="top" class="col_head <?= ($_REQUEST['sort'] == 'title')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="20%">
                        <a href="<?= $_SERVER['PHP_SELF']; ?>?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=title&sortdir=<?php echo ($_REQUEST['sort']=='title'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Title</a>
                </th>
                <th valign="top" class="col_head <?= ($_REQUEST['sort'] == 'adddate')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="30%">
                        <a href="<?= $_SERVER['PHP_SELF']; ?>?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=adddate&sortdir=<?php echo ($_REQUEST['sort']=='adddate'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Add Date</a>
                </th>
                <th valign="top" class="col_head" width="10%">
                        Preview
                </th>
		<?php if($office_type == DSS_OFFICE_TYPE_FRONT){ ?>
                <th valign="top" class="col_head" width="20%">
                        Actions
                </th>
		<?php } ?>
        </tr>
        <? if(mysql_num_rows($my) == 0)
        { ?>
                <tr class="tr_bg">
                        <td valign="top" class="col_head" colspan="10" align="center">
                                No Records
                        </td>
                </tr>
        <?
        }
        else
        {
                while($myarray = mysql_fetch_array($my))
                {
                        if($myarray["status"] == 1)
                        {
                                $tr_class = "tr_active";
                        }
                        else
                        {
                                $tr_class = "tr_inactive";
                        }

                        $i_type_sql = "select * from dental_imagetype where imagetypeid='".$myarray["imagetypeid"]."'";
                        $i_type_my = mysql_query($i_type_sql);
                        $i_type_myarray = mysql_fetch_array($i_type_my);

                ?>
                        <tr class="<?=$tr_class;?>">
                                <td valign="top">
                                        <?php if($myarray['imagetypeid']==0){ ?>
                                                Clinical Photos (Pre-Tx)
                                        <?php }else{ ?>
                                        <?=st($i_type_myarray["imagetype"]);?>
                                        <?php } ?>
                                </td>
                                <td valign="top">
                                        <?=st($myarray["title"]);?>
                                </td>
                                <td valign="top">
                                        <?=date('M d, Y H:i', strtotime(st($myarray["adddate"])));?>
                                </td>
                                <td valign="top">
                                    <a href="display_file.php?f=<?=addslashes($myarray["image_file"]);?>" target="_blank" class="btn btn-default btn-sm">
                                        Preview
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                    </a>
                                </td>
				<?php if($office_type == DSS_OFFICE_TYPE_FRONT){ ?>
                                <td valign="top">
                                    <a href="Javascript:;"  onclick="Javascript: loadPopupRefer('add_image.php?ed=<?=$myarray["imageid"];?>&pid=<?=$_GET['pid'];?>&sh=<?=$_GET['sh'];?>');" class="editlink btn btn-primary btn-sm" title="EDIT">
                                        Edit
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                    <a href="<?=$_SERVER['PHP_SELF']?>?pid=<?=$_GET['pid'];?>&delid=<?=$myarray["imageid"];?>&sh=<?=$_GET['sh'];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink btn btn-danger btn-sm" title="DELETE">
                                        Delete
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                </td>
				<?php } ?>
                        </tr>
        <?      }
        }?>
</table>

