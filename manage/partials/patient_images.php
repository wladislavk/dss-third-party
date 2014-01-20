<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr class="tr_bg_h">
                <td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'imagetypeid')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="20%">
                        <a href="<?= $_SERVER['PHP_SELF']; ?>?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=imagetypeid&sortdir=<?php echo ($_REQUEST['sort']=='imagetypeid'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Image Type</a>
                </td>
                <td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'title')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="20%">
                        <a href="<?= $_SERVER['PHP_SELF']; ?>?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=title&sortdir=<?php echo ($_REQUEST['sort']=='title'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Title</a>
                </td>
                <td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'adddate')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="30%">
                        <a href="<?= $_SERVER['PHP_SELF']; ?>?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=adddate&sortdir=<?php echo ($_REQUEST['sort']=='adddate'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Add Date</a>
                </td>
                <td valign="top" class="col_head" width="10%">
                        Preview
                </td>
		<?php if($office_type == DSS_OFFICE_TYPE_FRONT){ ?>
                <td valign="top" class="col_head" width="20%">
                        Action
                </td>
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
                                                <a href="javascript:void(0)" onclick="window.open('/manage/q_file/<?=addslashes($myarray["image_file"]);?>',
'welcome','width=800,height=400,scrollbars=yes');">
                                                Preview</a>
                                </td>
				<?php if($office_type == DSS_OFFICE_TYPE_FRONT){ ?>
                                <td valign="top">
                                        <a href="Javascript:;"  onclick="Javascript: loadPopupRefer('add_image.php?ed=<?=$myarray["imageid"];?>&pid=<?=$_GET['pid'];?>&sh=<?=$_GET['sh'];?>');" class="editlink" title="EDIT">
                                                Edit 
                                        </a>

                    <a href="<?=$_SERVER['PHP_SELF']?>?pid=<?=$_GET['pid'];?>&delid=<?=$myarray["imageid"];?>&sh=<?=$_GET['sh'];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
                                                 Delete 
                                        </a>
                                </td>
				<?php } ?>
                        </tr>
        <?      }
        }?>
</table>

