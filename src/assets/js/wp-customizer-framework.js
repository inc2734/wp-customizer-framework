jQuery(function($) {
  $(document).on('change', '.customize-control-multiple-checkbox input[type="checkbox"]', function() {
    var checkbox_values = $(this).parents('.customize-control').find('input[type="checkbox"]:checked').map(
      function() {
        return this.value;
      }
    ).get().join( ',' );
    $(this).parents('.customize-control').find('input[type="hidden"]').val( checkbox_values ).trigger( 'change' );
  });
});
