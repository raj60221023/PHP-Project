<footer id="footer">
    <!-- bottom footer -->
    <div id="bottom-footer" class="section">
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <ul class="footer-payments">
                        <li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
                        <li><a href="#"><i class="fa fa-credit-card"></i></a></li>
                        <li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
                        <li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
                        <li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
                        <li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
                    </ul>
                    <span class="copyright">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://github.com/raj60221023" target="_blank">Abhinav Raj</a>
                    </span>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /bottom footer -->
</footer>
<!-- /FOOTER -->

<!-- jQuery Plugins -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/nouislider.min.js"></script>
<script src="js/jquery.zoom.min.js"></script>
<script src="js/main.js"></script>
<script src="js/actions.js"></script>
<script src="js/sweetalert.min.js"></script>
<script src="js/jquery.payform.min.js"></script>
<script src="js/script.js"></script>
<script>
    var c = 0;
    function menu(){
        if(c % 2 == 0) {
            document.querySelector('.cont_d_rob').className = "cont_d_rob cont_d_rob_axon";
            document.querySelector('.c_n_rob').className = "c_n_rob c_n_rob_axon";
            document.querySelector('.cont_icon_trg').className = "cont_icon_trg cont_icon_trg_axon";
            c++; 
        } else {
            document.querySelector('.cont_d_rob').className = "cont_d_rob";
            document.querySelector('.c_n_rob').className = "c_n_rob";
            document.querySelector('.cont_icon_trg').className = "cont_icon_trg";
            c++;   
        }
    }
</script>
</body>
</html>