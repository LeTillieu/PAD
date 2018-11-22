<script>
    var button = $(".button");

    button.click(function(e){
        var link = window.location.href+"article.php?article="+e.currentTarget.id;
        if(e.currentTarget.name === "comment"){
            history.pushState({"1":1},"page", e.currentTarget.href);
            window.location.replace(link+"#editor");
        }else if(e.currentTarget.name === "share"){
            var fbButton = $("<div>");
            var fbLink = $("<a>");
            var twitterButton = $("<div>");
            var twitterLink = $("<a>");
            var titre = $("h2").children("[href='article.php?article="+e.currentTarget.id+"']")[0].text;
            fbButton.addClass("facebookShare");
            twitterButton.addClass("twitterShare");


            fbLink.attr("href","https://www.facebook.com/sharer/sharer.php?u="+link);
            twitterLink.attr("href","https://twitter.com/intent/tweet?text="+titre+": &url="+link+"&hashtags=PlaceAuDébat");

            twitterLink.text("Tweeter");
            fbLink.text("Partager");

            fbButton.append(fbLink);
            twitterButton.append(twitterLink);
            this.after(fbButton[0]);
            this.after(twitterButton[0]);
        }else if(e.currentTarget.name === "report"){
            $.ajax({
                type: "POST",
                url: "php/controller.php",
                data: {report: "true", id: e.currentTarget.id},
                success: function () {
                    //redirection
                    window.location.replace("index.php");
                },
                error: function(e){
                    console.log("Impossible de report cet article");
                    console.log(e);
                },
                dataType: "html"
            })
        }
    });

</script>

<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">