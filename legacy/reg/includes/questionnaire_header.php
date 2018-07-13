<?php
namespace Ds3\Libraries\Legacy;
?>
<div class="cf sepH_c endpoint-permissions-menu"
     v-bind:doc-id="<?= (int)$_SESSION['patient_docid'] ?>"
     v-bind:patient-id="<?= (int)$_SESSION['pid'] ?>">
    <a href="symptoms.php" class="btn <?= ($_SERVER['PHP_SELF']=='/reg/symptoms.php')?'btn_bS':'btn_dS'; ?> fl">Symptoms</a>
    <a href="sleep.php" class="btn <?= ($_SERVER['PHP_SELF']=='/reg/sleep.php')?'btn_bS':'btn_dS'; ?> fl">Epworth/Thorton Scale</a>
    <a href="treatments.php" class="btn <?= ($_SERVER['PHP_SELF']=='/reg/treatments.php')?'btn_bS':'btn_dS'; ?> fl">Previous Treatments</a>
    <a href="history.php" class="btn <?= ($_SERVER['PHP_SELF']=='/reg/history.php')?'btn_bS':'btn_dS'; ?> fl">Health History</a>
    <a class="btn <?= ($_SERVER['PHP_SELF']=='/reg/history.php')?'btn_bS':'btn_dS'; ?> fl"
       v-for="group in indexedGroups" v-show="group.authorized" v-bind:href="group.slug + '.php'">
        {{ group.name }}
    </a>
</div>

