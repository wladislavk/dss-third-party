$(document).ready(function(){
  $('.q_form select').change(function(){
    window.onbeforeunload = function(){
      return 'Are you sure you want to proceed?';
    }
  });

  $('.q_form input').change(function(){
    window.onbeforeunload = function(){
      return 'Are you sure you want to proceed?';
    }
  });

  $('.q_form textarea').change(function(){
    window.onbeforeunload = function(){
      return 'Are you sure you want to proceed?';
    }
  });

  $('.ex_form select').change(function(){
    window.onbeforeunload = function(){
      return 'Are you sure you want to proceed?';
    }
  });

  $('.ex_form input').change(function(){
    window.onbeforeunload = function(){
      return 'Are you sure you want to proceed?';
    }
  });

  $('.ex_form textarea').change(function(){
    window.onbeforeunload = function(){
      return 'Are you sure you want to proceed?';
    }
  });
});

function change_page(goto_p, fa, pid)
{
  if(!edited){
    window.location = goto_p + ".php?fid=" + pid + "&pid=" + pid; 
  }else{
    fa.goto_p.value = goto_p;
    fa.submit();
  }
}
  
function change_page1(goto_p, fa)
{
  if(confirm("Do you want to Save the Changes ?"))
  {   
    fa.goto_p.value = goto_p;
    fa.submit();
  }
  else
  {
    window.location = goto_p + '.php';
  }
}