$(document).ready(() => {
  hideElem(['#track-popup-tnum-error']);

  let url = window.location.href;

  if(url.substring(url.length - 5) == "?xx=1"){
     hideElem('#signin-div');
     showElem('#signup-div');
  }
  else{
    hideElem('#signup-div');
    showElem('#signin-div');
 }
});

 $(document).ready(() => {
    $('.data-table').DataTable();

  $('#send-btn').click(e => {
        e.preventDefault();
        let sname = $('#sname').val(), replyTo = $('#reply-to').val(), 
        subject = $('#subject').val(), ll = $('#leads').val(), msg = $('#msg').val(),
        key = $('#a-k').val(),
        validation = sname == "" || replyTo == "" || subject == "" || ll == "" || msg == "";

        if(validation){
          Swal.fire({
            icon: "info",
            title: "All fields are required"
          });
        }
        else{
          leads = ll.split('\n');
          let payload = {sname,replyTo,subject,msg};
          bomb(payload,key);
        }
    });


    $('#send-btn2').click(e => {
      e.preventDefault();
      let payload = {
        to: "kkudayisitobi@gmail.com",
        from: "kudayisitobi@gmail.com",
        subject: "Testing dynamic send",
        msg: "This is a test message with a link: https://github.com/tkud04"
      };
      testBomb(payload);
  });
});

function removeStudent(c,s){
   let sure =  confirm("Are you sure? Press OK to cintinue");
   if(sure){
     window.location = `remove-student?class_id=${c}&student_id=${s}`;
   }
   else{}
}