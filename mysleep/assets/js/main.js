$(function(){
    $(".exit").click(function(){
        var $location = $(this).data("location")
        bootbox.confirm({
            title: 'Exit the activity?',
            message: 'Are you sure you want to exit the activity?  Make sure your work is saved!',
            buttons: {
                confirm: {
                    label: 'Exit',
                    className: 'btn-simple btn-danger'
                },
                cancel: {
                    label: 'Keep Working',
                    className: 'btn-simple btn-default'
                }
            },
            callback: function (result) {
                // result will be true if button was click, while it will be false if users close the dialog directly.
                if (result) {
                    window.window.location.href = $location;
                } else {
                    this.modal('hide');
                }
            }
        });
    });
});
