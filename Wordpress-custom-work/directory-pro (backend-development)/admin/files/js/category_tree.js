jQuery(document).ready(function () {
  var width = document.querySelector("#dirpro_categories_tree").offsetWidth;
  console.log(width);
  var col;
  if (width < 600) {
    col = "col-lg-10 col-md-6 mx-auto";
  } else if (width > 600 && width < 850) {
    col = "col-lg-6 col-md-6";
  } else if (width > 850 && width < 1000) {
    col = "col-lg-4 col-md-6";
  } else {
    col = "col-lg-4 col-md-6";
  }
  var divs = document.getElementsByClassName("column");
  //console.log(divs.length);
  for (let i = 0; i < divs.length; i++) {
    jQuery(divs[i]).addClass(col);
  }
});
