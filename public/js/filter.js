var img = document.querySelector(".image-click");
var div = document.querySelector(".small-category");

img.onclick = function() {
    if (div.style.display === "none") {
        div.style.display = "block";
    } else {
        div.style.display = "none";
    }
}

var manu = document.querySelector(".image-click-manufacturer");
var smanu = document.querySelector(".small-manufacturer");

manu.onclick = function() {
    if (smanu.style.display === "none") {
        smanu.style.display = "block";
    } else {
        smanu.style.display = "none";
    }
}


