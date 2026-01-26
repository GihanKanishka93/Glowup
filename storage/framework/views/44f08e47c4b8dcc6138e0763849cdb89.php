<footer class="sticky-footer ">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Glow Up Skin Care & Cosmetics
                <script>
                    var CurrentYear = new Date().getFullYear()
                    document.write(CurrentYear)
                </script>
                &nbsp;|&nbsp;Developed by
                <a class="footer-credit-link" href="https://metaxell.com" target="_blank"
                    rel="noopener noreferrer">MetaXell</a>
            </span>
        </div>
    </div>
</footer>
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="">
                    <?php echo csrf_field(); ?>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Logout</button>
                </form>
            </div>


        </div>
    </div>
</div><?php /**PATH /Users/gihan.finsbury/Downloads/Vet-APP/Glowup/resources/views/layouts/footer.blade.php ENDPATH**/ ?>