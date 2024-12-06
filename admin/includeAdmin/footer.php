<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

<script>
  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });
</script>

<script>
  $('.mydatatable').DataTable();
</script>

<script>
    $(document).ready(function() {
    $('a[data-confirm]').click(function(ev) {
        var href = $(this).attr('href');

        if (!$('#dataConfirmModal').length) {
            $('body').append('<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="dataConfirmLabel">Please Confirm</h3></div><div class="modal-body"></div><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button><a class="btn btn-primary" id="dataConfirmOK">OK</a></div></div>');
        } 
        $('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
        $('#dataConfirmOK').attr('href', href);
        $('#dataConfirmModal').modal({show:true});
        return false;
    });
});

$('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
});

</script>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#myModalCommand').modal('show');
    });
</script>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#myModalDetailsCommand').modal('show');
    });
</script>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#myModalUsers').modal('show');
    });
</script>

</body>

</html>
