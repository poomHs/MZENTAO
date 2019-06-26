function setModal4List(colorboxClass, replaceID) {
    if (config.onlybody != 'yes') $('.iframe').modalTrigger({ width: 900, type: 'iframe', afterHide: function () { location.href = location.href; } })
}
$(document).ready(function(){ 
    　var  legendBranch = $("#legendBranch");
      var  method = "bug";
        if(legendBranch){
            legendBranch.find("table").html('<tr id ="ajaxSyncSvnInfo"><td>點擊檢測</td></tr>');
            legendBranch.find("#ajaxSyncSvnInfo").on('click',function(){
                $.ajax({
                    type: "GET",
                    url: "svn-ajaxSyncSvnInfo-"+method+"-1"+".json",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    beforeSend:function(){
                        $("#ajaxSyncSvnInfo").html("正在請求ing，請稍後");
                    },
                    success: function (message) {
                            console.log(message);
                    },
                    error: function (message) {
                        console.log("this"+message.responseText);
                        $("#ajaxSyncSvnInfo").html("請求失敗");
                    }
                });
            })
        }
    }); 
