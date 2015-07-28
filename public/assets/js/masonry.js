jQuery(document).ready(function() {

  jQuery('.masonry-grid').masonry({
    itemSelector: '.aesop-collection-item', // set itemSelector so .grid-sizer is not used in layout
    columnWidth: '.aesop-collection-item', // use element for option
    percentPosition: true
  });

});
