function image_upload(){
    //var FileSaver = require('file-saver');

    imgInp = document.getElementById('formFile');
    tmpimg2 = document.querySelectorAll(".product_picture")[1];
    const [file] = imgInp.files
        if (file) {
          tmpimg2.src = URL.createObjectURL(file)
        }

    let resEle = document.querySelector(".result");
    resEle.style.display="flex";
    var context = resEle.getContext("2d");
    //context.imageSmoothingEnabled = false;
    var imageObj1 = new Image();
    imageObj1.src = document.querySelectorAll(".product_picture")[0].src;
    imageObj1.onload = function() {
      context.drawImage(imageObj1, 0, 0, imageObj1.width, imageObj1.height, 0, 0, 289, 150);
    };
    document.querySelectorAll(".product_picture")[0].style.display="none";
    var imageObj2 = new Image();
    imageObj2.src = document.querySelectorAll(".product_picture")[1].src;
    imageObj2.onload = function() {
      context.drawImage(imageObj2, 0, 0, imageObj2.width*3, imageObj2.height*3, 100, 50, resEle.width, resEle.height);
    };
    document.querySelectorAll(".product_picture")[1].style.display="none";
    // var imageURI = resEle.toDataURL("image/jpg");
    // var imageObj3 = new Image();
    // document.querySelectorAll(".product_picture")[2].src = imageURI;
    //imageObj3.src = document.querySelectorAll(".product_picture")[2].src;
    //imageObj3.src = imageURI;
    // var canvas = resEle;
    // canvas.toBlob(function(blob) {
    //     FileSaver.saveAs(blob, "pretty image.png");
    // });
    // console.log(imageURI);
  }