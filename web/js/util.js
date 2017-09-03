
// apiUrl = "http://127.0.0.1:8000/api";
apiUrl = "http://izb02.dev/api";

// ************** User functions ************** //

function login (email, password) {
    $.ajax({
        url: apiUrl + "/oauth2/token",
        method: "POST",
        contentType: 'application/x-www-form-urlencoded',
        data: {
            'grant_type' : 'Bearer',
            'email' : email,
            'password' : password
        },
        success:
            function (data) {
                Cookies.set('Bearer', data);
                getUserData();
            },
        error:
            function () {
                alert("Error logging in.");
            }
    });
}

function logout () {

    Cookies.remove('Bearer');
    sessionStorage.removeItem('user');
    console.log("User logged out.");
}

function getUserData () {
    $.ajax({
        url: apiUrl + "/user",
        method: "GET",
        contentType: 'application/x-www-form-urlencoded',
        headers: {
            'Authorization' : 'Bearer ' + Cookies.get('Bearer')
        },
        success:
            function (data) {
                sessionStorage.setItem('user', JSON.stringify(data));
                location.reload();
            },
        error:
            function (e) {
                console.log(e.responseText);
            }
    });
}

function addNewUser (email, firstName, lastName, pass) {
    $.ajax({
        url: apiUrl + "/user",
        method: "POST",
        contentType: 'application/json',
        dataType: "json",
        data: JSON.stringify({
            "id": 0,
            'email' : email,
            'firstName' : firstName,
            "lastName": lastName,
            "pass": pass
        }),
        success:
            function (data) {
                console.log(data);
                console.log('User added.');
                showFlash('Successfully registered!');
                login(email, pass);
                location.reload();
            },
        error:
            function (e) {
                console.log(e.responseText);
                alert(e.responseText);
            }
    });
}

function changePass (oldpass, newpass) {
    $.ajax({
        url: apiUrl + "/user/changepass",
        method: "POST",
        contentType: 'application/x-www-form-urlencoded',
        headers: {
            'Authorization' : 'Bearer ' + Cookies.get('Bearer')
        },
        data: {
            "oldpass": oldpass,
            "newpass": newpass
        },
        success:
            function () {
                showFlash('Password changed');
            },
        error:
            function (e) {
                alert(e.responseText);
            }
    });
}

function updateUser (firstName, lastName) {
    $.ajax({
        url: apiUrl + "/user",
        method: "PUT",
        contentType: 'application/json',
        dataType: "json",
        headers: {
            'Authorization' : 'Bearer ' + Cookies.get('Bearer')
        },
        data: JSON.stringify({
            "id": JSON.parse(sessionStorage.getItem('user')).id,
            "email": JSON.parse(sessionStorage.getItem('user')).email,
            "firstName": firstName,
            "lastName": lastName
        }),
        success:
            function () {
                showFlash('User details updated');
                getUserData();
            },
        error:
            function (e) {
                console.log(e.responseText);
            }
    });
}

// ************** Article functions ************** //

function getAllArticles () {
    $.ajax({
        url: apiUrl + "/article",
        success: displayAllArticles,
        error:
            function (e) {
                console.log(e.responseText);
            }
    });
}

function postArticle(title, body) {
    $.ajax({
        url: apiUrl + "/article",
        method: "POST",
        contentType: 'application/json',
        headers: {
            'Authorization': 'Bearer ' + Cookies.get('Bearer')
        },
        data: JSON.stringify({
            "id": 0,
            'title': title,
            'body': body,
            // "poster": JSON.parse(sessionStorage.getItem('user')).id,
            "poster": 1,
            "datetime": new Date()
        }),
        success: function () {
            location.reload();
        },
        error: function (e) {
            alert(e.responseText);
        }
    });
}

function updateArticle(articleId, title, body) {
    $.ajax({
        url: apiUrl + "/article",
        method: "PUT",
        contentType: 'application/json',
        dataType: "json",
        headers: {
            'Authorization' : 'Bearer ' + Cookies.get('Bearer')
        },
        data: JSON.stringify({
            "id": articleId,
            "poster": currentUser.id,
            'body' : body,
            'title' : title,
            "datetime": new Date()
        }),
        success:
            function (data) {
                location.reload();
            },
        error:
            function (e) {
                console.log(e.responseText);
            }
    });
}

function deleteArticle(articleId) {
    $.ajax({
        url: apiUrl + "/article/" + articleId,
        method: "DELETE",
        contentType: 'application/json',
        headers: {
            'Authorization': 'Bearer ' + Cookies.get('Bearer')
        },
        success: function () {
            console.log('Article deleted.');
            location.reload(true);
        },
        error: function (e) {
            console.log(e.responseText);
        }
    });
}

// ************** Comment functions ************** //

function getComments (articleId) {
    $.ajax({
        url: apiUrl + "/article/" + articleId + "/comment",
        method: "GET",
        // async: false,
        success:
            function (data) {
                displayComments(data, articleId);
                console.log(data);
            },
        error:
            function (e) {
                console.log(e.responseText);
            }
    });
}

function postComment(articleId, title, body) {
    $.ajax({
        url: apiUrl + "/article/" + articleId + "/comment",
        method: "POST",
        contentType: 'application/json',
        dataType: "json",
        headers: {
            'Authorization': 'Bearer ' + Cookies.get('Bearer')
        },
        data: JSON.stringify({
            "id": 0,
            "poster": JSON.parse(sessionStorage.getItem('user')).id,
            "article" : articleId,
            'title': title,
            'body': body,
            "datetime": new Date()
        }),
        success: function (data) {
            console.log(data);
            console.log('Comment posted.');
            getComments(data.article);
        },
        error: function (e) {
            alert(e.responseText);
        }
    });
}

function updateComment(articleId, commentId, title, body) {

    $.ajax({
        url: apiUrl + "/article/" + articleId + "/comment",
        method: "PUT",
        contentType: 'application/json',
        dataType: "json",
        headers: {
            'Authorization' : 'Bearer ' + Cookies.get('Bearer')
        },
        data: JSON.stringify({
            "id": commentId,
            "poster": currentUser.id,
            "article" : articleId,
            'body' : body,
            'title' : title,
            "datetime": new Date()
        }),
        success:
            function (data) {
                console.log(data);
                getComments(data.article);
                showFlash('Comment updated');
            },
        error:
            function (e) {
                alert(e.responseText);
            }
    });
}

function deleteComment(articleId, commentId) {

    $.ajax({
        url: apiUrl + "/article/" + articleId + "/comment/" + commentId,
        method: "DELETE",
        contentType: 'application/json',
        headers: {
            'Authorization': 'Bearer ' + Cookies.get('Bearer')
        },
        success: function () {
            showFlash('Comment deleted');
            getComments(articleId);
        },
        error: function (e) {
            alert(e.responseText);
        }
    });
}

// ************** Utility functions ************** //

// Populate article page - a.k.a. The Abomination

function displayAllArticles (allArticles) {

    for (var i=0; i<allArticles.length; i++) {

        tempid = allArticles[i].id;

        $('.content').append('' +
            '<div class="col-md-10 col-md-offset-1 article" id="article_' + tempid + '">' +
                '<div class="article_title" contentEditable="false">' + allArticles[i].title + '</div>' +
                '<div class="article_body" contentEditable="false">' +  allArticles[i].body + '</div>' +
                '<span class="badge">Posted ' + moment(allArticles[i].datetime).format("LLL") + '</span> by' +
                '<span><a href="#"> ' + allArticles[i].poster.first_name + '</a><img src="images/5.jpg" class="small_image" alt=""></span>' +
                '<div class="comment row">' +
                    '<span class="label label-success article_comments col-md-2" id="comment_show_' + tempid + '">Show comments</span>' +
                    '<input class="new_comment_title col-md-2 hidden" id="new_comment_title_' + tempid + '" placeholder="Title">' +
                    '<input class="new_comment_body col-md-3 hidden" id="new_comment_body_' + tempid + '" placeholder="Body">' +
                    '<span class="label label-info comment_post hidden" id="comment_post_' + tempid + '">Post a comment</span>' +
                    '<span class="label label-danger pull-right article_delete hidden" id="delete_article_' + tempid + '">Delete Article</span>' +
                    '<span class="article_edit label label-warning pull-right hidden" id="edit_article_' + tempid + '">Edit Article</span>' +
                    '<span class="save_article_changes label pull-right hidden" id="update_article_' + tempid + '">Save Changes</span>' +
                '</div>' +
                '<div class="comment_space row" id="comment_space_' + tempid + '"></div>' +
                '<hr>' +
            '</div>');

        if (currentUser !== null && currentUser.id === allArticles[i].poster) {
            $('#delete_article_' + tempid).removeClass('hidden');
            $('#edit_article_' + tempid).removeClass('hidden');
        }
    }

    if (currentUser !== null) {
        $('.comment_post').removeClass('hidden');
        $('.new_comment_title').removeClass('hidden');
        $('.new_comment_body').removeClass('hidden');
    }

    $('.article_comments').each(function() {
        $(this).click(function () {
            res = $(this).attr('id').split("_");
            getComments(res[2]);
        })
    });

    $('.article_delete').each(function() {
        $(this).click(function () {
            res = $(this).attr('id').split("_");
            if (confirm('Delete this article?')) {
                deleteArticle(res[2]);
            }
        });
    });

    $('.article_edit').each(function() {
        $(this).click(function () {
            res = $(this).attr('id').split("_");
            makeEditable($('#article_'+res[2]+' .article_title'));
            makeEditable($('#article_'+res[2]+' .article_body'));
            $(this).addClass('hidden');
            $('#article_'+res[2]+' .save_article_changes').removeClass('hidden');
        });
    });

    $('.save_article_changes').each(function() {
        $(this).click(function () {
            res = $(this).attr('id').split("_");
            updateArticle(res[2], $('#article_'+res[2]+' .article_title').html(), $('#article_'+res[2]+' .article_body').html());
        });
    });

    $('.comment_post').each(function() {
        $(this).click(function () {
            res = $(this).attr('id').split("_");
            postComment(res[2], $('#new_comment_title_'+res[2]).val(), $('#new_comment_body_'+res[2]).val());
        });
    });
}

// Display comments

function displayComments(allArticleComments, articleId) {
    $('#comment_space_' + articleId).text('');

    for (var i=0; i<allArticleComments.length; i++) {

        tempArticleCommentId = allArticleComments[i].id;
        tempArticleId = allArticleComments[i].article;
        tempCommentTitle = allArticleComments[i].title;
        tempCommentBody = allArticleComments[i].body;

        $('#comment_space_' + tempArticleId).append('' +
            '<h3 class="comment_title" id="comment_title_'+tempArticleCommentId+'">'+ tempCommentTitle + '</h3>' +
            '<h4 class="comment_body" id="comment_body_'+tempArticleCommentId+'">' + tempCommentBody + '</h4>' +
            '<span class="label label-danger delete_comment pull-right hidden" id="delete_comment_'+tempArticleCommentId+'">Delete Comment</span>' +
            '<span class="label label-warning edit_comment pull-right hidden" id="edit_comment_'+tempArticleCommentId+'">Edit Comment</span>' +
            '<span class="label label-info update_comment pull-right hidden" id="update_comment_'+tempArticleCommentId+'">Save changes</span>' +
            '<br>');

        if (currentUser !== null && currentUser.id === allArticleComments[i].poster) {
            $('#delete_comment_'+tempArticleCommentId).removeClass('hidden');

            $('#edit_comment_'+tempArticleCommentId).removeClass('hidden').click(function () {
                res = $(this).attr('id').split("_");
                makeEditable($('#comment_title_'+res[2]));
                makeEditable($('#comment_body_'+res[2]));
                $(this).addClass('hidden');
                $('#update_comment_'+res[2]).removeClass('hidden');
            });
        }
    } // end loop

    $('.delete_comment').each(function() {
        $(this).click(function () {
            res = $(this).attr('id').split("_");
            deleteComment(tempArticleId, res[2]);
        });
    });

    $('.update_comment').each(function() {
        $(this).click(function () {
            res = $(this).attr('id').split("_");
            updateComment(tempArticleId, res[2], $('#comment_title_'+res[2]).html(), $('#comment_body_'+res[2]).html());
        });
    });
}

function makeEditable(e) {
    $(e).attr("contentEditable", true).addClass('editable_field');
}

function showFlash(message) {
        $('#flash').html(message).delay(200).fadeIn('fast', function() {
            $(this).delay(1000).fadeOut();
        });
}

// TODO: Frontend input validation

//BONUS TODO:
// TODO: Gulp minification
// TODO: Articles frontend pagination
// TODO: Article page styling

