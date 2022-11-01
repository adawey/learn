
var AVUtil = function(){

    var redirectionConfirmation = function (url){

        swal({
            title: "Are you sure ?",
            // text: "You will not be able to recover this post!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Confirm",
            cancelButtonText: "No, cancel",
        }).then(function (isConfirm) {
            console.log(isConfirm);
            if (isConfirm.dismiss != 'cancel') {
                window.location.href =  url;
            } else {
                swal("Don\'t Worry !", "You still here.", "success");
            }
        });

    }


    var deleteConfirmation = function(url, callback){
        swal({
            title: "Are you sure?",
            // text: "You will not be able to recover this post!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it",
            cancelButtonText: "No, cancel",
        }).then(async function(isConfirm) {
            if (isConfirm.dismiss != 'cancel') {
                await callback(url);
                swal("Deleted!", "Item have been deleted.", "success").then(function(){location.reload();});
                
            } else {
                swal("Cancelled", "Item is safe.", "error");
            }
        });

    };

    return {
        redirectionConfirmation,
        deleteConfirmation,
    };
}

