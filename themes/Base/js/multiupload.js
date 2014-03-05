$(document).ready(function()
{

    var settings = {
        url: "",
        method: "POST",
        allowedTypes:"jpg,png,gif,raw",
        fileName: "image",
        multiple: true,
        onSuccess:function(files,data,xhr)
        {
            $("#status").html("<font color='green'>Upload is success</font>");

        },
        onError: function(files,status,errMsg)
        {
            $("#status").html("<font color='red'>Upload is Failed</font>");
        }
    }
    $("#mulitplefileuploader").uploadFile(settings);

});