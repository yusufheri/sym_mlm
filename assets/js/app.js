var $ = require('jquery');

global.$ = global.jQuery = $;

require('bootstrap');

$(document).ready(function(){
    var mytext = getUrlParam('id',-1);
    console.log(mytext);

    if(mytext == -1){
        $("#myModalMember").modal("show");
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
