var browserType;

if (document.layers) {browserType = "nn4"}
if (document.all) {browserType = "ie"}
if (window.navigator.userAgent.toLowerCase().match("gecko")) {
 browserType= "gecko"
}

function hide1() {
  if (browserType == "gecko" )
     document.poppedLayer =
         eval('document.getElementById("hideshow1")');
  else if (browserType == "ie")
     document.poppedLayer =
        eval('document.getElementById("hideshow1")');
  else
     document.poppedLayer =
        eval('document.layers["hideshow1"]');
  document.poppedLayer.style.display = "none";
}

function show1() {
  if (browserType == "gecko" )
     document.poppedLayer =
         eval('document.getElementById("hideshow1")');
  else if (browserType == "ie")
     document.poppedLayer =
        eval('document.getElementById("hideshow1")');
  else
     document.poppedLayer =
         eval('document.layers["hideshow1"]');
  document.poppedLayer.style.display = "inline";
}

function hide2() {
  if (browserType == "gecko" )
     document.poppedLayer =
         eval('document.getElementById("hideshow2")');
  else if (browserType == "ie")
     document.poppedLayer =
        eval('document.getElementById("hideshow2")');
  else
     document.poppedLayer =
        eval('document.layers["hideshow2"]');
  document.hideshow2.display = "none";
}

function show2() {
  if (browserType == "gecko" )
     document.poppedLayer =
         eval('document.getElementById("hideshow2")');
  else if (browserType == "ie")
     document.poppedLayer =
        eval('document.getElementById("hideshow2")');
  else
     document.poppedLayer =
         eval('document.layers["hideshow2"]');
  document.poppedLayer.style.display = "inline";
}

function hide3() {
  if (browserType == "gecko" )
     document.poppedLayer =
         eval('document.getElementById("hideshow3")');
  else if (browserType == "ie")
     document.poppedLayer =
        eval('document.getElementById("hideshow3")');
  else
     document.poppedLayer =
        eval('document.layers["hideshow3"]');
  document.poppedLayer.style.display = "none";
}

function show3() {
  if (browserType == "gecko" )
     document.poppedLayer =
         eval('document.getElementById("hideshow3")');
  else if (browserType == "ie")
     document.poppedLayer =
        eval('document.getElementById("hideshow3")');
  else
     document.poppedLayer =
         eval('document.layers["hideshow3"]');
  document.poppedLayer.style.display = "inline";
}

function hide4() {
  if (browserType == "gecko" )
     document.poppedLayer =
         eval('document.getElementById("hideshow4")');
  else if (browserType == "ie")
     document.poppedLayer =
        eval('document.getElementById("hideshow4")');
  else
     document.poppedLayer =
        eval('document.layers["hideshow4"]');
  document.poppedLayer.style.display = "none";
}

function show4() {
  if (browserType == "gecko" )
     document.poppedLayer =
         eval('document.getElementById("hideshow4")');
  else if (browserType == "ie")
     document.poppedLayer =
        eval('document.getElementById("hideshow4")');
  else
     document.poppedLayer =
         eval('document.layers["hideshow4"]');
  document.poppedLayer.style.display = "inline";
}

function hide5() {
  if (browserType == "gecko" )
     document.poppedLayer =
         eval('document.getElementById("hideshow5")');
  else if (browserType == "ie")
     document.poppedLayer =
        eval('document.getElementById("hideshow5")');
  else
     document.poppedLayer =
        eval('document.layers["hideshow5"]');
  document.poppedLayer.style.display = "none";
}

function show5() {
  if (browserType == "gecko" )
     document.poppedLayer =
         eval('document.getElementById("hideshow5")');
  else if (browserType == "ie")
     document.poppedLayer =
        eval('document.getElementById("hideshow5")');
  else
     document.poppedLayer =
         eval('document.layers["hideshow5"]');
  document.poppedLayer.style.display = "inline";
}

