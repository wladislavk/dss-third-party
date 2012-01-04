<html>
<head>
  <title>Dental Sleep Solutions :: Register</title>
  <link rel="stylesheet" href="css/style.css" />
  <script type="text/javascript" src="../manage/admin/script/jquery-1.6.2.min.js"></script>
</head>
<body>

<div id="container">
<header>
<h1>Dental Sleep Solutions</h1>
</header>
<ul>
  <li><a href="javascript:show(1);">1</a></li>
  <li><a href="javascript:show(2);">2</a></li>
  <li><a href="javascript:show(3);">3</a></li>
</ul>

<form>
<div class="step" id="step1">
1
</div>
<div class="step" id="step2" style="display:none;">
2
</div>
<div class="step" id="step3" style="display:none;">
3
</div>
</form>




</div>

<script type="text/javascript">

function show(n){
$('.step').hide();
$('#step'+n).show();
}
</script>
</body>
</html>
