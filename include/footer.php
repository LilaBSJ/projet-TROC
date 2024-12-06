<footer class="pt-5" style='background-color:lightgreen; min-height:50px;'>
    <h3 class="text-center mt-5"><div class="badge badge-dark text-wrap p-3 text-dark">&copy; TROC <?= date('Y') ?></div></h3>
</footer>

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

    // Fonction pour ouvrir la lightbox
    function openLightbox() {
        document.getElementById('commentLightbox').style.display = 'block';
    }

    // Fonction pour fermer la lightbox
    function closeLightbox() {
        document.getElementById('commentLightbox').style.display = 'none';
    }

    // Fonction pour rediriger vers une page spécifique
    function redirectTo(url) {
        window.location.href = url;
    }

   
    function updateRating(value) {
        document.getElementById('note').value = value;
        var stars = document.querySelectorAll('.five-rate-active a');
        stars.forEach(function(star){
            if (star.getAttribute('data-value') <= value) {
                star.classList.remove('rate-value-empty');
                star.classList.add('rate-value-filled');
            } else {
                star.classList.remove('rate-value-filled');
        };
    })
        };
    
    function changeTri() {
        var tri = document.getElementById('tri').value;
        window.location.href = "index.php?categorie=<?php echo $id_categorie; ?>&tri=" + tri;
    }


</script>

</body>
</html>

