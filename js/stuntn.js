function ajaxObj( meth, url ) {
        var z = new XMLHttpRequest();
        z.open( meth, url, true );
        z.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        return z;
}
function ajaxReturn(z){
        if(z.readyState == 4 && z.status == 200){
            return true;
        }
}
