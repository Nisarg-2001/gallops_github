

  
    $(document).ready(function(){
        $('[data-confirm]').on('click', function(e){
            e.preventDefault(); //cancel default action
    
            //Recuperate href value
            var href = $(this).attr('href');
            var message = $(this).data('confirm');
    
            //pop up
            swal({
                title: "Are you sure you want to delete ??",
                text: 'After Delete, you won\'t be able to revert back',
                position: 'top',
                icon: "error",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                swal("Poof! Your imaginary file has been deleted!", {
                  icon: "success",
                });
                window.location.href = href;
              }
            });
        });
    });

    