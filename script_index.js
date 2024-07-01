$(function() {
    let canvasElement = document.querySelector("#pad");
    let context = canvasElement.getContext("2d");

    $('.button-find').on('click', function() {
        request = document.getElementById('request').value;
        let endpoint = 'https://api.unsplash.com/photos/random?client_id=ewGNniPcKafXxp4Y2agWknP4VFemdrbc1ZI1aV7a7ss&query='+request;
        let imageLink = document.querySelector("#imageLink");
        let creator = document.querySelector("#creator")
        fetch(endpoint)
            .then((response) => response.json())
            .then((jsonData) => {
                imageLink.setAttribute("href", jsonData.links.html);
                creator.innerText = jsonData.user.name;
                creator.setAttribute("href", jsonData.user.portfolio_url);
                document.getElementById('request').value = "";

                $.ajax({
                    type: 'POST',
                    url: 'saveUnsplash.php',
                    data: {imgBase64: jsonData.urls.full},
                    success: function(dataImg){
                        canvasElement.style.backgroundImage = "url('images/unsplash/" + dataImg + ".png')";
                    }
                });
            })
            .catch((error) => {
                console.log("Error: " + error);
            });
    });

    $('#width-input').on('mouseup keyup', function() {
        $('#pad').prop('width', $(this).val());
    });

    $('#height-input').on('mouseup keyup', function() {
        $('#pad').prop('height', $(this).val());
    });

    $('.button-clear_canvas').on('click', function() {
        context.clearRect(0, 0, context.canvas.width, context.canvas.height);
        context.beginPath();
    });

    $('.checkbox-background_img').on('change', function() {
        if ($('#pad').hasClass('background-img-none')) {
            $('#pad').removeClass('background-img-none');
        }
        else $('#pad').addClass('background-img-none');
    });

    $('#upload').on('click', function() {
        var file_data = $('#sortpicture').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        $.ajax({
            url: 'saveUserfile.php',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(dataImg){
                canvasElement.style.backgroundImage = "url('images/userfile/" + dataImg + ".png')";
            }
        });
    });

    pendown = false;
    function startDrawing(e) {
        pendown = true;
        context.beginPath();
        context.moveTo(e.pageX - canvasElement.offsetLeft, e.pageY - canvasElement.offsetTop);
    }
    function draw(e) {
        if(pendown) {
            context.lineTo(e.pageX - canvasElement.offsetLeft, e.pageY - canvasElement.offsetTop);
            context.stroke();
        }
    }
    function stopDrawing() {
        pendown = false;
        context.closePath();
    }
    
    $('#pad').mousedown(startDrawing);
    $('#pad').mousemove(draw);
    $('#pad').mouseup(stopDrawing);
    $('#pad').mouseleave(stopDrawing);

    $('#pad').on('touchstart', function(e) {
        startDrawing(e.originalEvent.touches[0]);
    });
    $('#pad').on('touchmove', function(e) {
        e.preventDefault();
        draw(e.originalEvent.touches[0]);
    });
    $('#pad').on('touchend', function() {
        stopDrawing();
    });

    function download(canvas, filename, type) {
        const a = document.createElement('a');
        a.download = filename;
        switch (type) {
            case 'png':
                a.href = canvas.toDataURL("image/png;base64");
                break;
            case 'jpg':
                a.href = canvas.toDataURL("image/jpeg");
                break;
            default:
                alert("Ошибка");
        }
        a.style.display = 'none';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
    
    $('.button-screenshot').on('click', function(){
        const element = document.getElementById('pad');
        const type = document.getElementById('select-type').value;
        html2canvas(element).then((canvas) => {
            download(canvas, 'example', type);
        });
    });

    $('.server-block__icon').on('click', function() {
        $('.server-background').css("display", "none");
        $('body').css("overflow", "unset");
    });
    
    $('.button-save').on('click', function() {
        if (document.cookie.includes("login")) {
            $('.block-title-user-img').css('display', 'block');
            $('.server-background').css("display", "flex");
            $('body').css("overflow", "hidden");
        }
        else {
            saveToServer('Необходимо войти');
        }
    });
    $('#button-submit-save').on('click', function() {
        const title = document.getElementById('title-user-img').value;
        const element = document.getElementById('pad');
        html2canvas(element).then((canvas) => {
            const dataURL = canvas.toDataURL();
            $.ajax({
                type: 'POST',
                url: 'saveCanvasToServer.php',
                data: {
                    imgBase64: dataURL,
                    userComment: title
                },
                success: function(){
                    $('.block-title-user-img').css('display', 'none');
                    saveToServer('Успешно сохранено');
                }
            });
        });
    });
    function saveToServer (text) {
        $('.server-background').css("display", "flex");
        $('body').css("overflow", "hidden");
        $('.server-block__title').html(text);
    }
});

$(document).ready(function(){
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        autoplay: true,
        autoPlaySpeed: 5000,
        autoPlayTimeout: 5000,
        responsive:{
            0:{
                items:2
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    })
});