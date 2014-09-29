$(document).ready(function() 
    { 
        $('#sort_table').tablesorter().tablesorterPager({container: $("#pager")});  
        $('#sort_table2').tablesorter().tablesorterPager({container: $("#pager2")});
        $('.sort_table').tablesorter();
    } 
); 