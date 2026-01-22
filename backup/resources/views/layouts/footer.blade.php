<footer class="sticky-footer ">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; ChallengerVet Hospital (Pvt) Ltd
                <script>
                    var CurrentYear = new Date().getFullYear()
                    document.write(CurrentYear)
                </script>
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
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="">
                @csrf
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <button class="btn btn-primary"  type="submit">Logout</button>
        </form>
        </div>


    </div>
</div>
</div>
