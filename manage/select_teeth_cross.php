<?php namespace Ds3\Libraries\Legacy; ?><?php include "admin/includes/main_include.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta name="keywords" content="<?php echo st((!empty($page_myarray['keywords']) ? $page_myarray['keywords'] : ''));?>" />
        <title><?php echo $sitename;?></title>
        <link href="css/admin.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
        <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
        <script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="script/validation.js"></script>
        <script type="text/javascript" src="script/autocomplete.js"></script>
        <script type="text/javascript" src="/manage/js/select_teeth_cross.js"></script>
    </head>

    <body>
        <table width="100%" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
            <tr bgcolor="#FFFFFF">
                <td>
                    <br />
                    <span class="admin_head">
                        <?php
                            if (!empty($_GET['tx'])) {
                                switch($_GET['tx']) { 
                                    case 'crossbite':
                                        echo "Teeth in Crossbite";
                                        break;
                                    case 'initial_tooth':
                                        echo "Tooth Contacts prior to OAT Therapy";
                                        break;
                                    case 'open_proximal':
                                        echo "Open contacts";
                                        break;
                                    case 'deistema':
                                        echo "Diastemas";
                                        break;
                                }
                            }
                        ?>
                        <input type="button" value="save" onclick="fill_up()" />
                    </span>
                    <br /><br />
                    &nbsp;&nbsp;
                    <span class="form_info" style="font-size:18px; font-weight:bold;">
                        Select the first of two teeth
                    </span>

                    <form name="selfrm" action="<?php echo $_SERVER['PHP_SELF']?>?tx=<?php echo (!empty($_GET['tx']) ? $_GET['tx'] : '');?>" method="post">
                        <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
                            <tr>
                                <td valign="top" colspan="2" width="25%" >
                                    <table width="80%" cellpadding="3" cellspacing="1" border="0">
                                        <tr class="tr_bg_h">
                                            <td valign="top" class="col_head" colspan="2" class="col_head">
                                                Permanent Teeth
                                            </td>
                                        </tr>
                                        <?php
                                            $j = 32;
                                            for($i = 1; $i < 17; $i++) {
                                                if($i < 10) {
                                                    $i = '0'.$i;
                                                }
                                        ?>
                                                <tr>
                                                    <td valign="top" width="50%">
                                                        <input type="checkbox" id="per_teeth" name="per_teeth[]" value="<?php echo $i?>" onclick="cal_send_per()" />
                                                        <?php echo $i;?>
                                                    </td>
                                                    <td valign="top" width="50%">
                                                        <input type="checkbox" id="per_teeth" name="per_teeth[]" value="<?php echo $j?>" onclick="cal_send_per()" />
                                                        <?php echo $j;?>
                                                    </td>
                                                </tr>
                                        <?php
                                                $j--;
                                            }
                                        ?>
                                    </table>
                                </td>
                                <td valign="top" colspan="2" width="25%">
                                    <table width="80%" cellpadding="3" cellspacing="1" border="0">
                                        <tr class="tr_bg_h">
                                            <td valign="top" class="col_head" colspan="2" class="col_head">
                                                Primary Teeth
                                            </td>
                                        </tr>
                                        <?php
                                            $j = "K";
                                            for($i = 'A'; $i < 'K'; $i++) {
                                        ?>
                                                <tr bgcolor="#FFFFFF">
                                                    <td valign="top" width="50%">
                                                        <input type="checkbox" name="pri_teeth[]" value="<?php echo $i?>" onclick="cal_send_pri()" />
                                                        <?php echo $i;?>
                                                    </td>
                                                    <td valign="top" width="50%">
                                                        <input type="checkbox" name="pri_teeth[]" value="<?php echo $j?>" onclick="cal_send_pri()" />
                                                        <?php echo $j;?>
                                                    </td>
                                                </tr>
                                        <?php
                                                $j++;
                                            }
                                        ?>
                                    </table>
                                </td>
                                <td valign="top" colspan="2" width="25%">
                                    <table width="80%" cellpadding="3" cellspacing="1" border="0">
                                        <tr class="tr_bg_h">
                                            <td valign="top" class="col_head" colspan="2" class="col_head">
                                                Pairs Selected
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" colspan="2">
                                                <textarea name="t_text" class="tbox" style="width:250px; height:100px;"><?php echo str_replace(' , ','',(!empty($_GET['fval']) ? $_GET['fval'] : ''));?></textarea>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <br /><br />
                </td>
            </tr>
        </table>
    </body>
</html>
