jQuery(document).ready(function($){

    /*
    Legacy jQuery pattern.
    jQuery.browser was removed
    in newer jQuery versions.
    This will break after upgrade.
    */

    if ($.browser) {
        console.log("Old browser detected");
    }


    $("h1").click(function(){

        alert(
            "Welcome to SmartPost Enterprise Portal"
        );

    });

});