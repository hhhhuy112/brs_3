$(function(){
    var bookId = $("#bookId").text();
    var userId = $("#userId").text();
    var userName = $("#userName").text();

    $(".mark-action").on('click', function () {
        var actionId = this.id;
        if (actionId.indexOf("reading") != -1) {
            $("#btn-reading").addClass('btn-success');
            if ($("#btn-read").hasClass("btn-success")){
                $("#btn-read").toggleClass('btn-success');
            }
        } else if (actionId.indexOf("favorite") != -1) {
            $("#btn-favorite").toggleClass('btn-success');
        } else {
            $("#btn-read").addClass('btn-success');
            if ($("#btn-reading").hasClass("btn-success")){
                $("#btn-reading").toggleClass('btn-success');
            }
        }

        $.ajax({
            url : "/books/view/"+bookId,
            type: 'POST',
            data: {
                bookId: $("#bookId").text(),
                action: actionId
            },
            success : function(response){
            }
        });
    });

    // Add new review
    $('#add-review').click(function(){
        $("#new-review").removeClass('hidden');
    });    

    // Submit new review
    $('#submit-review').click(function(){
        var review = $("#review-area").val();
        $.ajax({
            url : "/books/view/" + bookId,
            type: 'POST',
            data: {
                review: review,
                bookId: bookId,
                action: "addReview"
            },
            success : function(response){
                $("#add-review").addClass('hidden');
                $("#new-review").addClass('hidden');
                $('#old-review-js').removeClass('hidden');

                $('#old-review-js').prepend(
                    "<div class='panel panel-info'>" +
                        "<div class='panel-heading'>" +
                            "<a href='/users/index/" + userId + "'>" + userName + "</a>" +
                        "</div>" +
                        "<div class='panel-body'>" +
                            "<p>" +
                                review +
                            "</p>" +
                        "</div>" + 
                    "</div>"
                );
            }
        });
    });

    // Add new comment
    $(".add-comment").on('click', function () {
        var reviewId = this.id;
        reviewId = reviewId.substring(reviewId.lastIndexOf('-') +1);
        $(".new-comment").addClass('hidden');
        $(".add-comment").removeClass('hidden');
        $("#new-comment-" + reviewId).removeClass('hidden');
        $("#add-comment-" + reviewId).addClass('hidden');
        $("#new-review").addClass('hidden');
        $('#btn-review').removeClass('hidden');
    });

    // Submit new comment
    $(".submit-comment").on('click', function () {
        var reviewId = this.id;
        reviewId = reviewId.substring(reviewId.lastIndexOf('-') + 1);
        var comment = $("#comment-area-" + reviewId).val();
        $.ajax({
            url : "/books/view/" + bookId,
            type: 'POST',
            data: {
                comment: comment,
                reviewId: reviewId,
                action: "addComment"
            },
            success : function(response){
                $('#new-comment-' + reviewId).addClass('hidden');
                $('#add-comment-' + reviewId).removeClass('hidden');
                $('#old-comment-' + reviewId).append(
                    '<li class="list-group-item">' +
                        '<p class="user-comment">'+
                            comment +
                        '</p>' +
                        '<p class="user-name-comment">' +
                            "<a href='/users/index/" + userId + " class='btn btn-default btn-success'>" + userName + "</a>" +
                        '</p>' +
                    '</li>'
                ); 
            }
        });
    });


    // Rating
    $('.rating input').click(function () {
        $(".rating span").removeClass('checked');
        $(this).parent().addClass('checked');
    });

    $('input:radio').change(function(){
        var userRating = this.value;
        $.ajax({
            url : "/books/view/" + bookId,
            type: 'POST',
            data: {
                bookId: bookId,
                rating: userRating,
                action: "addRating"
            },
            success : function(response){
            }
        });
    });

    function showUpdateReviewButton() {
        $("#modify-review").toggleClass("hidden");
    }

    function showUpdateCommentButton(id) {
        $(".modify-comment").addClass("hidden");
        $("#modify-comment-" + id).toggleClass("hidden");
    }

    $(".update-review").click(function(){
        $("#modify-review").toggleClass("hidden");
        var elementId   = this.id;
        var reviewId    = elementId.substring(elementId.lastIndexOf('-') + 1);
        var type        = elementId.substring(0, elementId.indexOf('-'));
        $.ajax({
            url : "/books/view/" + bookId,
            type: 'POST',
            data: {
                updatedReview: $("#modifiable-review").text(),
                action: "modify-review",
                reviewId: reviewId,
                type: type
            },
            success : function(response){
                if (type === 'remove') {
                    $(".updateable-review").remove();
                }
            }
        });
    });

    $(".update-comment").on('click', function() {
        var elementId = this.id;
        var type = elementId.substring(0, elementId.indexOf('-'));
        var commentId = elementId.substring(elementId.lastIndexOf('-') + 1);
        $.ajax({
            url : "/books/view/" + bookId,
            type: 'POST',
            data: {
                action: "modify-comment",
                conmment: $("#comment-contain-" + commentId).text(),
                type: type,
                commentId: commentId
            },
            success : function(response) {
                if (type === 'remove') {
                    $("#comment-" + commentId).remove();
                }
            }
        });
    });
});
