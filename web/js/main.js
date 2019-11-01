$(document).ready(function () {
    $.post({
        url: '/api/graphql',
        data: JSON.stringify({query: "query {" +
            "photos {" +
                "description\n" +
                "filepath" +
                "}" +
            "}"}),
        contentType: 'application/json'

    }).done(function(response) {

        $(".photos").html("")
        response.data.photos.forEach(function (el) {
            var div = $("<div />").addClass("col-lg-3").addClass("photo");

            div.append(
                $("<div/>").addClass("photo-container")
                    .append($("<img/>").attr("src", el.filepath).addClass("thumbnail"))
            );
            div.append("<p>"+el.description+"</p>");
            $(".photos").append(div);
        });
    });
});
