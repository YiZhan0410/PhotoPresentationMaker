/* Slide navigation */
/* Resource: https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_slideshow_gallery */
var slideIndex = 0;
var slides = [];
var st;
var previewImg = document.getElementById("previewImg");

function plusSlides(n) {
    slideIndex += n;
    if (slideIndex < 0) {
        slideIndex = slides.length - 1;
    }
    if (slideIndex == slides.length) {
        slideIndex = 0;
    }

    showSlides();
}

/* Slide transition */
/* Resources: http://jsfiddle.net/sxjuc8rn/3/ */
function showSlides() {
    if (transition.value != "empty") {
        // Fade transition
        if (transition.value == "fadeIn") {
            $(previewImg).fadeOut("500", function () {
                $.when($(previewImg).prop("src", slides[slideIndex])).then(function () {
                    $(previewImg).fadeIn("500");
                });
            });
            // Slide transition
        } else if (transition.value == "slideIn") {
            $(previewImg).toggle("slide", { direction: "right" }, 300, function () {
                $.when($(previewImg).prop("src", slides[slideIndex])).then(function () {
                    $(previewImg).toggle("slide", { direction: "left" }, 300);
                });
            });
        }
        //No transition
    } else {
        previewImg.src = slides[slideIndex];
    }
}

/* Keypress key for each button */
/* Resource: https://keycode.info/ */
document.onkeydown = function (e) {
    switch (e.keyCode) {
        // Left-arrow key for next image
        case 37:
            plusSlides(-1);
            break;
        
        // Right-arrow key for previous image
        case 39:
            plusSlides(1);
            break;

        // F for full screen
        case 70:
            openFullscreen();
            break;

        // Spacebar for auto play
        case 32:
            playSlide();
            break;

        // P for pause
        case 80:
            pauseSlide();
            break;
    }
};

/* Auto play */
/* Resources: http://jsfiddle.net/wtNhf/
            : https://www.bitdegree.org/learn/javascript-setinterval*/

var playBtn = document.getElementById("play");
var pauseBtn = document.getElementById("pause");

playBtn.enabled = true;
pauseBtn.enable = true;

function playSlide() {
    playBtn.disabled = true;
    pauseBtn.disabled = false;

    clearInterval(st);
    st = setInterval(function () {
        slideIndex++;
        if (slideIndex < 0) {
            slideIndex = slides.length - 1;
        }
        if (slideIndex == slides.length) {
            slideIndex = 0;
        }

        showSlides();
    }, 5000);
}

/* Pause */
/* Resource: https://stackoverflow.com/questions/21277900/how-can-i-pause-setinterval-functions 
           : https://www.wikitechy.com/tutorials/javascript/stop-set-interval-call-in-javascript */
function pauseSlide() {
    pauseBtn.disabled = true;
    playBtn.disabled = false;

    clearInterval(st);
}

/* Fullscreen */
/* Resource: https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_fullscreen */
var elem = document.getElementById("previewImg");
function openFullscreen() {
    if (elem.requestFullscreen) {
        elem.requestFullscreen();
    } else if (elem.webkitRequestFullscreen) { /* Safari */
        elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) { /* IE11 */
        elem.msRequestFullscreen();
    } else if (elem.mozRequestFullscreen) { /*Mozilla Firefox*/
        elem.mozRequestFullscreen();
    }
}

/* Display image in the content container */
/* Resource: Poster Creator (1st year assessment) */
function display(img) {
    previewImg.src = img.src;
}

/* Image drag and drop */
/* Resource: https://www.aspsnippets.com/Articles/Drag-and-Drop-images-from-one-DIV-to-another-using-jQuery.aspx */
$(function () {
    $("#menu img").draggable({
        revert: "invalid",
        refreshPositions: true,
        drag: function (event, ui) {
            console.log("drag");
            ui.helper.addClass("draggable");
        },
        stop: function (event, ui) {
            console.log("stop");
            ui.helper.removeClass("draggable");
        }
    });
    $("#arrange").droppable({
        drop: function (event, ui) {
            console.log("drop");
            if ($("#arrange img").length == 0) {
                $("#arrange").html("");
            }
            ui.draggable.addClass("dropped");
            $("#arrange").append(ui.draggable);

            if (previewImg.getAttribute('src') == "") {
                previewImg.src = ui.draggable[0].src;
            }

            slides.push(ui.draggable[0].src);
        }
    });
});
