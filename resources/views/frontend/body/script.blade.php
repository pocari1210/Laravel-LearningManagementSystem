{{-- /// Start Wishlist Add Option // --}}
<script type="text/javascript">
  // これがないと保存がされない
  $.ajaxSetup({
      headers:{
          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
      }
  })

  function addToWishList(course_id){

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "/add-to-wishlist/"+course_id,
        success:function(data){
            console.log(data);
        }
    })
      
  }


</script>






{{-- /// End Wishlist Add Option // --}}