jQuery(document).ready(function () {
  jQuery("#dirpro_directories").listnav();

  var width = document.querySelector("#dirpro_directories").offsetWidth;
  console.log(width);
  var col;
  if (width < 500) {
    col = "col-lg-10 col-md-6 mx-auto";
  } else if (width > 500 && width < 600) {
    col = "col-lg-6 col-md-6";
  } else if (width > 600 && width < 850) {
    col = "col-lg-6 col-md-6";
  } else if (width > 850 && width < 1000) {
    col = "col-lg-4 col-md-6";
  } else {
    col = "col-lg-3 col-md-6";
  }
  var divs = document.getElementsByClassName("column");
  //console.log(divs.length);
  for (let i = 0; i < divs.length; i++) {
    jQuery(divs[i]).addClass(col);
  }
});
