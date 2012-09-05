<? 
include "admin/includes/config.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="<?=st($page_myarray['keywords']);?>" />
<title><?=$sitename;?></title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body>

<table width="100%" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
    <tr bgcolor="#FFFFFF">
	    <td> 
<br />
<span class="admin_head">
	<?php
	 switch($_GET['tx']){ 
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
	?>
<input type="button" value="save" onclick="fill_up()" />
</span>
<br />
<br />
&nbsp;&nbsp;
<span class="form_info" style="font-size:18px; font-weight:bold;">
    Select the first of two teeth
</span>
            
<script type="text/javascript">
	function cal_send_per()
	{
		dd = document.selfrm;
		tt = dd.t_text.value;
		
		d_count = 0;
		d_msg = '';
		for(i=0; i<dd.elements.length; i++)
		{
			if(dd.elements[i].name == 'per_teeth[]' && dd.elements[i].checked)
			{
				if(d_msg != '')
					d_msg = d_msg + '/';
				d_msg = d_msg + dd.elements[i].value;
				d_count++;
			}
		}
		
		if(d_count == 2)
		{	
			if(tt != '')
				tt = tt + '\n';
			
			tt = tt + d_msg;
			
			dd.t_text.value = tt;
			
			for(i=0; i<dd.elements.length; i++)
			{
				if(dd.elements[i].name == 'per_teeth[]' && dd.elements[i].checked)
				{
					dd.elements[i].checked = false;
				}
			}
		}
	}
	
	function cal_send_pri()
	{
		dd = document.selfrm;
		tt = dd.t_text.value;
		
		d_count = 0;
		d_msg = '';
		for(i=0; i<dd.elements.length; i++)
		{
			if(dd.elements[i].name == 'pri_teeth[]' && dd.elements[i].checked)
			{
				if(d_msg != '')
					d_msg = d_msg + '/';
				d_msg = d_msg + dd.elements[i].value;
				d_count++;
			}
		}
		
		if(d_count == 2)
		{	
			if(tt != '')
				tt = tt + '\n';
			
			tt = tt + d_msg;
			
			dd.t_text.value = tt;
			
			for(i=0; i<dd.elements.length; i++)
			{
				if(dd.elements[i].name == 'pri_teeth[]' && dd.elements[i].checked)
				{
					dd.elements[i].checked = false;
				}
			}
		}
	}
</script>
<form name="selfrm" action="<?=$_SERVER['PHP_SELF']?>?tx=<?=$_GET['tx'];?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr>
		<td valign="top" colspan="2" width="25%" >
        
            <table width="80%" cellpadding="3" cellspacing="1" border="0">
            	<tr class="tr_bg_h">
                	<td valign="top" class="col_head" colspan="2" class="col_head">
                    	Permanent Teeth
                    </td>
                </tr>
                <? 
				$j=17;
				for($i=1;$i<17;$i++)
				{
					if($i<10)
						$i = '0'.$i;
				?>
                    <tr>	
                        <td valign="top" width="50%">
                        	<input type="checkbox" id="per_teeth" name="per_teeth[]" value="<?=$i?>" onclick="cal_send_per()" />
                            <?=$i;?>
                        </td>
                        <td valign="top" width="50%">
                        	<input type="checkbox" id="per_teeth" name="per_teeth[]" value="<?=$j?>" onclick="cal_send_per()" />
                            <?=$j;?>
                        </td>
                    </tr>
                <? 
					$j++;
				}?>
            </table>
            
		</td>
		<td valign="top" colspan="2" width="25%">
			
             <table width="80%" cellpadding="3" cellspacing="1" border="0">
            	<tr class="tr_bg_h">
                	<td valign="top" class="col_head" colspan="2" class="col_head">
                    	Primary Teeth
                    </td>
                </tr>
                <? 
				$j="K";
				for($i='A';$i<'K';$i++)
				{
				?>
                    <tr bgcolor="#FFFFFF">	
                        <td valign="top" width="50%">
                        	<input type="checkbox" name="pri_teeth[]" value="<?=$i?>" onclick="cal_send_pri()" />
                            <?=$i;?>
                        </td>
                        <td valign="top" width="50%">
                        	<input type="checkbox" name="pri_teeth[]" value="<?=$j?>" onclick="cal_send_pri()" />
                            <?=$j;?>
                        </td>
                    </tr>
                <? 
					$j++;
				}?>
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
                    	<textarea name="t_text" class="tbox" style="width:250px; height:100px;"><?=str_replace(' , ','
',$_GET['fval']);?></textarea>
                    </td>
                </tr>
            </table>
        </td>
	</tr>
</table>
</form>
<script type="text/javascript">
	function fill_up()
	{
		fa = document.selfrm.t_text.value;
		
		fa = fa.replace(/\n/g,', ');
		parent.document.ex_page4frm.<?=$_GET['tx']?>.value = fa;
		parent.disablePopupRefClean();
	}
</script>

<br /><br />	

			</td>
		</tr>
	</table>
    

</body>
</html>
