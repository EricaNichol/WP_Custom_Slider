<?php function test_function($hi) { ?>
<script>
// Home Page Slider
console.log('hi from slider settings');
var slider_count = jQuery('#slider_container').length;

if (slider_count > 1) {
  $('#slider_container').bbslider({
    auto: true,
    timer: 7000,
    loop: true,
    transition: 'fade',
    pager: true,
    // pagerWrap:  '#pagination-wrapper',
    loopTrans: false
  });
}
</script>
<?php }; ?>
