require('./bootstrap');


window.addEventListener('toast', function (event) {
   switch (event.detail.type) {
       case 'info':
           toastr.info(event.detail.message,'',{closeButton:true,"timeOut": "500",});
           break;
       case 'warning':
            toastr.warning(event.detail.message,'',{closeButton:true,"timeOut": "500",});
           break;
       case 'success':
            toastr.success(event.detail.message,'',{closeButton:true,"timeOut": "500",});
           break;
       case 'error':
            toastr.error(event.detail.message,'',{closeButton:true,"timeOut": "500",});
           break;

       default:
            toastr.info(event.detail.message,'',{closeButton:true,"timeOut": "500",});
           break;
   }
});

var channel = Echo.channel('my-channel');

channel.listen('.event', function(data) {
    alert(JSON.stringify(data));
  });
