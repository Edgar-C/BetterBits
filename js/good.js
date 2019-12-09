function _(z){
return document.getElementById(z);
}
function toggleElement(z){
var z = _(z);
if(z.style.display == 'block'){
z.style.display = 'none';
}else{
z.style.display = 'block';
}
}
