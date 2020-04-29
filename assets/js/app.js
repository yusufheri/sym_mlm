var $ = require('jquery');

global.$ = global.jQuery = $;

require('bootstrap');

$(document).ready(function(){
    var mytext = getUrlParam('id',-1);
   

    if(mytext != 1 & mytext != 2){
        $("#myModalMember").modal("show");
    }
    if($("#myModalPaiment") != undefined){
        $("#myModalPaiment").modal("show");
    }
   
   
    function getUrlParam(parameter, defaultvalue){
        var urlparameter = defaultvalue;
        if(window.location.href.indexOf(parameter) > -1){
            urlparameter = getUrlVars()[parameter];
        }
        return urlparameter;
    }

    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
    }
});
