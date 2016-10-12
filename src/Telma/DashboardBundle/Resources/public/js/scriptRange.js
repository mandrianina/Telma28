$(function() {
  $('.range').next().text($('.range').val()); // Valeur par défaut
  $('.range').on('input', function() {
    var $set = $(this).val();
    $(this).next().text($set + '%');
  });
});