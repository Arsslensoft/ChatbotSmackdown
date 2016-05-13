/**
 * Created by Arsslen on 09/05/2016.
 */

jQuery(document).ready(function() {

    setInterval('updateMessagesTime()', 1000);
});
function updateMessagesTime()
{
    $("time.time").each(function( ){
        var m = moment($(this).attr('datetime'), "DD/MM/YYYY HH:mm:ss").fromNow();
        $(this).text(m);
    });

}
function decodeMessage(encodedString) {
    var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
    var decodedString = Base64.decode(encodedString);
    //  console.log(decodedString);
    return decodedString;
}
function encodeMessage(string) {
    var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}


    var encodedString = Base64.encode(string);
    // console.log(encodedString);
    return encodedString;

}
function sendMessage(id,botname,username)
{
    var now = moment().format('DD/MM/YYYY HH:mm:ss');
    var message = $("input[id='messagebox']").val();
    var el = " <div class=\"answer left\"><div class=\"avatar\"><img src=\"images/chat/avatar1.png\" alt=\""+username+"\"> <div class=\"status online\"></div> </div><div class=\"name\">"+username+"</div> <div class=\"text\"> "+message+"</div>   <time class=\"time\" datetime=\""+now +"\">now</time> </div>";
    $(el).insertBefore("#sendbox");

    $("#chatholder").scrollTop($("#chatholder")[0].scrollHeight);

    $.get("chat.php",
        {
            id: id,
    message: encodeMessage(message)
},  function(data){
    var rnow = moment().format('DD/MM/YYYY HH:mm:ss');
    var el = " <div class=\"answer right\"><div class=\"avatar\"><img src=\"data/avatars/"+id+".jpg\" alt=\""+botname+"\"> <div class=\"status online\"></div> </div><div class=\"name\">"+botname+"</div> <div class=\"text\"> "+decodeMessage(data)+"</div>   <time class=\"time\" datetime=\""+rnow +"\">now</time> </div>";
    $(el).insertBefore("#sendbox");

    $("#chatholder").scrollTop($("#chatholder")[0].scrollHeight);
});
}


function recheckGame(id,stat)
{
    $.get("refresh.php",
        {
            id: id,
            m: "gstat"
        },  function(data){
            if(data != stat)
                location.reload();
        });
}
function recheckCompetition(id,stat)
{
    $.get("refresh.php",
        {
            id: id,
            m: "cstat"
        },  function(data){
            if(data != stat)
                location.reload();
        });
}