<?php include 'includes/top.htm';
include 'includes/sescheck.php';
?>
<br />
<span class="admin_head">
	My Page
</span>
<br />
<br />

<table>
	<tr>
    	<td valign="top" class="t_head" style="padding:10px;">
        	<a href="profile.php" class="dellink" title="DELETE" style="display:block;">
            	Edit Profile</a>
        </td>
    </tr>
    <? if($_SESSION['user_access'] >1)
	{?>
        <tr>
            <td valign="top" class="t_head" style="padding:10px;">
                <a href="manage_staff.php" class="dellink" title="DELETE" style="display:block;">
                    Manage Staff</a>
            </td>
        </tr>
    <? }?>
     <tr>
        <td valign="top" class="t_head" style="padding:10px;">
            <a href="manage_patient.php" class="dellink" title="DELETE" style="display:block;">
                Manage Patient</a>
        </td>
    </tr>
     <tr>
        <td valign="top" class="t_head" style="padding:10px;">
            <a href="manage_contact.php" class="dellink" title="DELETE" style="display:block;">
                Manage Contact</a>
        </td>
    </tr>
</table>


<? include 'includes/bottom.htm';?>