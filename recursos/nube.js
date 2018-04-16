$(document).ready(function(){
        $("#wordcloud1").awesomeCloud({
          "size" : {
            "grid" : 16,
            "normalize" : false
          },
          "options" : {
            "color" : "random-dark",
            "rotationRatio" : 0.35,
            "printMultiplier" : 3,
            "sort" : "random"
          },
          "font" : "'Times New Roman', Times, serif",
          "shape" : "square"
        });
        $("#wordcloud2").awesomeCloud({
          "size" : {
            "grid" : 9,
            "factor" : 1
          },
          "options" : {
            "color" : "random-dark",
            "rotationRatio" : 0.35
          },
          "font" : "'Times New Roman', Times, serif",
          "shape" : "circle"
        });
        $("#wordcloud3").awesomeCloud({
          "size" : {
            "grid" : 1,
            "factor" : 3
          },
          "color" : {
            "background" : "#036"
          },
          "options" : {
            "color" : "random-light",
            "rotationRatio" : 0.5,
            "printMultiplier" : 3
          },
          "font" : "'Times New Roman', Times, serif",
          "shape" : "star"
        });
});