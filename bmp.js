$(function() {
  $("#input_BMPD4").on("click", function() {
    const area = $('#BMPD3');
    if (!this.checked) {
      area.show();
    } else {
      area.hide();
    }
  });
});