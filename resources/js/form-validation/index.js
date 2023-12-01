// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        $("button[type='submit']").prop('disabled',true);
        var e = function(){
          var tmp = null;
          $.ajax({
            async: false,
            type: "POST",
            global: false,
            dataType: 'html',
            url: base_url + 'verifyPostData',
            data: $('form').serialize(),
            success: function(e){
              tmp = e;
            }
        });
        return tmp;
        }();
        if (form.checkValidity() === false || e == 'true') {
          event.preventDefault();
          event.stopPropagation();
          Swal.fire({
            icon: 'warning',
            title: 'Alguno de sus datos esta vacio.',
            text: 'Favor de completar los datos correctamente'
          })
          $("button[type='submit']").prop('disabled',false);
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();


$('form').bind('paste',function(e){

  arr = $('form').serializeArray();
  
  arr.forEach(foreachFunction);

  function foreachFunction(item,index){
    trim = item['value'].trim();
    if(e.keyCode === 32 && trim == ""){
      e.preventDefault();
    }
  }
  
})

$("input").on("keydown", function (e) {
  let val = $(this).val();
  let id = e.target.id;
  let keycode = e.which;
  let last_key = val.substr(val.length - 1);
  if (last_key == " " && keycode == 32) {
    val = val.slice(0, -1);
    $("#" + id).val(val);
  }
});

$("input").on("keydown", function (e) {
  let txt = $(this).val();
  if (e.which == 32) {
    if (txt.length == 0) {
      if (txt == "") {
        e.preventDefault();
      }
    }
  }
});
