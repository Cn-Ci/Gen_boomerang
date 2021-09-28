
$(document).ready(function() {
    if($('title').text() ==="Generation Boomerang - Index"){     
        let positionElementInPage = $('.v_line').offset().top;
        $(window).scroll(
            function() {
                if ($(window).scrollTop() >= positionElementInPage) {
                // fixed
                    $('.v_line').addClass("floatable");
                    } else {
                    // relative
                    $('.v_line').removeClass("floatable");
                }
            });
    }   
})
 

/* **** */
$(window).on('load', function() {
    const texts = document.querySelectorAll(".inner_text")
    for(let text of texts){           
        let text_ex = text.dataset.id;
        let text_cut = text_ex.slice(0,350)+'...';
        text.innerHTML = text_cut;
        text.addEventListener("click",function(e){
            if(text.innerHTML === text_ex)
                text.innerHTML = text_cut;    
            else    
                text.innerHTML = text_ex;
            e.preventDefault();
    })
    }
});


/* console.log($('title').text());
    $(".inner_text").ready(function(e) {
        $("#inner_text").text(text_ex.slice(0,350)+'...');

    });

    $("#inner_text").click(function (e) {
        $("#inner_text").text(text_ex);
    });
  */
