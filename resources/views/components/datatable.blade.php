<link rel="stylesheet" href="{{asset('assets/datatable/dataTables.bootstrap5.css')}}">
<script src="{{asset('assets/js/jquery-3.7.1.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.bootstrap5.js')}}"></script>
<script>
    $(".disable-right-click").on("contextmenu",function(){
       return false;
    }); 
    new DataTable('#basic-datatable', {
        orderCellsTop: true,
        ordering: false
    });

</script>