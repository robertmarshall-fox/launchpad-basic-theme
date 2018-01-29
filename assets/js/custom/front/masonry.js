/** Gallery Masonry **/

var galleryMasonryDom = document.querySelector('.gallery');
if( galleryMasonryDom ){    
    
    var galleryMasonry = new Masonry( galleryMasonryDom, {
        itemSelector: '.gallery-item',
        percentPosition: true,
    });
     
    imagesLoaded( galleryMasonryDom ).on( 'progress', function() {
        galleryMasonry.layout();
    }); 
    
}