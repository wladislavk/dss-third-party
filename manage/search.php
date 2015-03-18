<?php namespace Ds3\Libraries\Legacy; ?><?php include 'includes/top.htm'; ?>

    <link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
    <script src="admin/popup/popup2.js" type="text/javascript"></script>
    
    <br />
    <div>
        <?php
            // Get the search variable from URL
            $var = @$_GET['q'] ;
            $trimmed = trim($var); //trim whitespace from the stored variable
            // rows to return
            $limit = 10;
            // check for an empty string and display a message.
            if ($trimmed == "") {
                echo "<div style=\"padding-left:40px;\"><p>Please enter a search...</p></div>";
        ?>
                <form name="form" action="search.php" method="get">
                    <div style="padding-left:40px;">
                        <input type="text" name="q" />
                        <input type="submit" name="Submit" value="Search By Last Name" />
                    </div>
                </form>
                <div id="popupMemo" style="width:750px; z-index:9999; height:400px; position:absolute;">
                    <a id="popupContactClose">
                        <button>X</button>
                    </a>
                    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
                </div> 

                <div id="popupContact" style="width:750px;">
                    <a id="popupContactClose">
                        <button>X</button>
                    </a>
                    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
                </div> 

                <div id="backgroundPopup"></div>

                <br /><br />

                <?php include 'includes/bottom.htm'; ?> 
        <?php
                    trigger_error("Exit called", E_USER_ERROR);
            }
            // check for a search parameter
            if (!isset($var)) {
                echo "<div style=\"padding-left:40px;\"><p>We dont seem to have a search parameter!</p></div";
        ?>
                <form name="form" action="search.php" method="get">
                    <input type="text" name="q" />
                    <input type="submit" name="Submit" value="Search By Last Name" />
                </form>
                <div id="popupMemo" style="width:750px; z-index:9999; height:400px; position:absolute;">
                    <a id="popupContactClose">
                        <button>X</button>
                    </a>
                    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
                </div> 

                <div id="popupContact" style="width:750px;">
                    <a id="popupContactClose">
                        <button>X</button>
                    </a>
                    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
                </div> 

                <div id="backgroundPopup"></div>

                <br /><br />

                <?php include 'includes/bottom.htm';?> 
        <?php
                trigger_error("Exit called", E_USER_ERROR);
            }

            $sql = "select * from dental_patients where docid='".$_SESSION['docid']."'";
            if(!empty($_GET['sh']) && $_GET['sh'] != 2) {
	           $sql .= " and status = 1";
            }
            $sql .= " order by lastname, firstname";
            $query = "select * from dental_patients where docid='".$_SESSION['docid']."' AND lastname like \"%$trimmed%\" order by lastname,firstname";

            $numrows = $db->getNumberRows($query);

            // If we have no results, offer a google search as an alternative
            if ($numrows == 0)
            {
                echo "<div style=\"padding-left:40px;\"><h4>Results</h4>";
                echo "<p>Sorry, your search: &quot;" . $trimmed . "&quot; returned zero results</p></div>";
            }
            // next determine if s has been passed to script, if not use 0
            if (empty($s)) {
                $s = 0;
            }

            // get results
            $query .= " limit $s,$limit";
            $result = $db->getResults($query);

            // display what the person searched for
            echo "<div style=\"padding-left:40px;\"><p>You searched for: &quot;" . $var . "&quot;</p></div>";

            // begin to show results set
            echo "<div style=\"padding-left:40px;\">Results<br /></div>";
            $count = 1 + $s ;

            // now you can display the results returned
            if ($result) foreach ($result as $row) {
                $title = "<div style=\"padding-left:40px;\"><a style=\"padding-left:10px;\" href=\"manage_patient.php?pid=".$row['patientid']."\" target=\"_self\">".$row["lastname"].", ".$row['firstname']." ".$row['middlename']."</a></div>";

                echo " <div style=\"padding-left:40px;\"><font style=\"padding-left:20px;\">$count.)&nbsp;$title</font><br /></div>" ;
                $count++ ;
            }

            $currPage = (($s/$limit) + 1);

            //break before paging
            echo "<br />";

            // next we need to do the links to other results
            if ($s >= 1) { // bypass PREV link if s is 0
                $prevs = ($s-$limit);
                print "<div style=\"padding-left:40px;\">&nbsp;<a href=\"" . (isset($PHP_SELF) ? $PHP_SELF : '') . "?s=$prevs&q=$var\">&lt;&lt; 
                Prev 10</a>&nbsp&nbsp;</div>";
            }

            // calculate number of pages needing links
            $pages = intval($numrows / $limit);

            // $pages now contains int of pages needed unless there is a remainder from division

            if ($numrows%$limit) {
                // has remainder so add one page
                $pages++;
            }

            // check to see if last page
            if (!((($s+$limit)/$limit)==$pages) && $pages!=1) {
                // not last page so give NEXT link
                $news = $s + $limit;
                echo "<div style=\"padding-left:40px;\">&nbsp;<a href=\"" . (isset($PHP_SELF) ? $PHP_SELF : '') . "?s=$news&q=$var\">Next 10 &gt;&gt;</a></div>";
            }

            $a = $s + ($limit) ;
            if ($a > $numrows) { $a = $numrows ; }
            $b = $s + 1 ;
            echo "<div style=\"padding-left:40px;\"><p>Showing results $b to $a of $numrows</p></div>";
?>
            <form name="form" action="search.php" method="get">
                <div style="padding-left:40px;">
                    <input type="text" name="q" />
                    <input type="submit" name="Submit" value="Search By Last Name" />
                </div>
            </form>

            <div id="popupMemo" style="width:750px; z-index:9999; height:400px; position:absolute;">
                <a id="popupContactClose">
                    <button>X</button>
                </a>
                <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
            </div> 

            <div id="popupContact" style="width:750px;">
                <a id="popupContactClose">
                    <button>X</button>
                </a>
                <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
            </div> 

            <div id="backgroundPopup"></div>

            <br /><br />
            <?php include 'includes/bottom.htm'; ?> 
