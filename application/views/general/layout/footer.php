</br>
</article>
<script src="<?= base_url('node_modules/foundation-sites/dist/js/foundation.min.js') ?>"></script>
<script src="<?= base_url('node_modules/what-input/dist/what-input.js') ?>"></script>
<script src="<?= base_url('node_modules/responsive-tabs/js/jquery.responsiveTabs.js') ?>"></script>

<script>
  $(document).foundation();
  $('.title-bar').on('sticky.zf.stuckto:top', function() {
    $(this).addClass('shrink');
  }).on('sticky.zf.unstuckfrom:top', function() {
    $(this).removeClass('shrink');
  });
</script>

<script>
  $('#responsiveTabsDemo').responsiveTabs({
    startCollapsed: 'accordion'
  });
</script>
</body>

</html>