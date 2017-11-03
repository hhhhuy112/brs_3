$(function() {   
    $(".btn-follow").on('click', function() {
        var followingId = $("#followingId").text();
        $.ajax({
            url : "/users/view/" + followingId,
            type: 'POST',
            data: {
                action: 'follow'
            },
            success : function(response) {
                $("#follow").toggleClass('hidden');
                $("#unfollow").toggleClass('hidden');
            }
        });
    });

    $(".btn-like").on('click', function() {
        var elementId = this.id;
        var id = elementId.substr(elementId.indexOf("-") + 1);
        var action = elementId.substr(0, elementId.indexOf('-'));
        $("#" + elementId).addClass('hidden');
        if (action == 'like') {
            $("#unlike-" + id).removeClass('hidden');
        } else {
            $("#like-" + id).removeClass('hidden');
        }
    });

    $(".changeview").on('click', function() {
        $(".btn-home").toggleClass('btn-success');
        $(".btn-favorite").toggleClass('btn-success');
        $(".panel-view").toggleClass('hidden');
        $(".panel-favorite").toggleClass('hidden');
    });
}
