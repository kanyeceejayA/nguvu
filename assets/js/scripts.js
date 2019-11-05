function js_search() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue, field;
  input = document.getElementById("fast_search");
  field="div";
  if (document.getElementById("onlyCompany").checked == true) {field="strong"};
  filter = input.value.toUpperCase();
  table = document.getElementById("cardholder");
  tr = table.getElementsByClassName("card");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName(field)[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function no_amount() {
  amount =document.getElementById("amount");
  if (document.getElementById("noAmount").checked == true){
    amount.value=0;
    amount.setAttribute('value','0');


   holder = document.getElementById('amount_holder');
   holder.setAttribute('hidden','');
  }
  if (document.getElementById("noAmount").checked != true){
   amount.removeAttribute('value');
   holder = document.getElementById('amount_holder');
   holder.removeAttribute('hidden');
  }

}

  function reallySure (event) {
    var message = 'are you sure you want to delete this from the Database? this action is irreversible.';
    action = confirm(message) ? true : event.preventDefault();
}
var aElems = document.getElementsByClassName('myDelete');

for (var i = 0, len = aElems.length; i < len; i++) {
    aElems[i].addEventListener('click', reallySure);
}

function update_founders() {
                i=1;
                no = document.getElementById('no_founders').value;
                parent = document.getElementById('founders_parent');
                parent.innerHTML='';
                // alert(no);
                if(no<=10 && no>=1){
                  while(i<=no){
                    parent.innerHTML += '<h5 style="margin-bottom: -1.5em">Founder '+i+'</h5>'+
                                          '<div class="row" id="founder'+i+'">'+
                                            '<div class="form-group bmd-form-group col-sm-4">'+
                                              '<label for="f_name'+i+'" class="bmd-label">Founder\'s name</label><br>'+
                                              '<input  type="text" class="form-control" name="f_name'+i+'">'+
                                            '</div> <!-- form-group -->'+
                                            '<div class="form-group bmd-form-group col-sm-4">'+
                                              '<label for="f_email'+i+'" class="bmd-label">Founder\'s email</label><br>'+
                                              '<input  type="email" class="form-control" name="f_email'+i+'">'+
                                            '</div> <!-- form-group -->'+
                                            '<div class="form-group bmd-form-group col-sm-4">'+
                                              '<label for="f_phone'+i+'" class="bmd-label">Founder\'s Phone</label><br>'+
                                              '<input  type="text" class="form-control" name="f_phone'+i+'">'+
                                            '</div> <!-- form-group -->'+
                                          '</div> <!-- founder'+i+' row -->';
                    i += 1;
                  }
                }
                else{
                  alert('please enter a number between 1 and 10');
                  document.getElementById('no_founders').value=1;
                }
              }