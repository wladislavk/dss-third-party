<?php
namespace Ds3\Libraries\Legacy;

include_once __DIR__ . '/includes/dual_app.php';
dualAppRedirect('main/edx-certificate');

include "includes/top.htm";
include_once "includes/constants.inc";
?>
<span class="admin_head">EdX Certificates</span>
<br /><br />
<ul class="fullwidth" style="list-style:none;">
    <?php
    $db = new Db();

    $c_sql = "SELECT * FROM edx_certificates c JOIN dental_users u ON c.edx_id = u.edx_id
        WHERE u.userid='".$db->escape( $_SESSION['userid'])."'";
    $c_q = $db->getResults($c_sql);
    foreach ($c_q as $c) { ?>
        <li>
            <a href="<?php echo $c['url']; ?>" target="_blank">
                <?php echo $c['course_name']; ?> -
                <?php echo $c['course_section']; ?> -
                <?php echo $c['course_subsection']; ?> -
                <?php echo $c['number_ce']; ?>
            </a>
        </li>
        <?php
    } ?>
</ul>
<?php
include 'includes/bottom.htm';
?>
