<!-- Scripts -->

<!--   Core JS Files   -->
<script src="assets/js/jquery.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/js/material.min.js"></script>

<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="assets/js/nouislider.min.js" type="text/javascript"></script>

<!--  Plugin for the Datepicker, full documentation here: http://www.eyecon.ro/bootstrap-datepicker/ -->
<script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>

<!-- Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc -->
<script src="assets/js/material-kit.js" type="text/javascript"></script>

<!-- Bootstrap Table: Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

<!-- Bootstrap Wizard: Latest compiled and minified JavaScript -->
<script src="assets/js/wizard.min.js"></script>

<!-- Google Charts API -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<!-- Plugin for Easy Modals -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

<!-- Export Table To CSV -->
<script type="text/javascript" src="assets/js/excellentexport.min.js"></script>

<!-- Bootstrap Select -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>

<!-- Bootstrap Notify -->
<script src="assets/js/bootstrap-notify.min.js" type="text/javascript"></script>

<!-- Sweet Alert 2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.min.js" integrity="sha256-3LYQqRK22/5LQrP+JG5wnq3plxZcv0cO6CEktRawaDU=" crossorigin="anonymous"></script>

<!-- Any other JavaScript for MySleep -->
<script src="assets/js/main.js"></script>

<div id="alert" class="modal fade"  role="dialog" data-modal-index="1" aria-labelledby="alertLabel">
    <div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Alert</h4>
	    </div>
	    <div class="modal-body">
		<p id="alertMessage"></p>
	    </div>
	    <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    </div>
	</div>
    </div>
</div>

<script>
    (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-XXXXXXXX-X', 'auto');
    ga('send', 'pageview');


var disable = function () {
    if (typeof history.pushState === "function") {
        history.pushState("back", null, null);
        window.onpopstate = function () {
            history.pushState('back', null, null);
        };
    }
}

 var inactivityWarning = function () {
     var inactivityTime;
     window.onload = resetTimer;
     document.onkeypress = resetTimer;
     document.onmousemove = resetTimer;
     document.onmousedown = resetTimer;
     document.ontouchstart = resetTimer;
     document.onclick = resetTimer;
     document.onscroll = resetTimer;
     document.onkeypress = resetTimer;

     function resetTimer() {
         clearTimeout(inactivityTime);
         inactivityTime = setTimeout(function(){
	     $("#alertMessage").text("You are inactive over 10 minutes. Please refresh your page");
	     $("#alert").modal('show');
	 }, 10*60*1000);
         // 10 mins
     }
 };
 inactivityWarning();
 disable();
</script>
<script type="text/javascript">
 function googleTranslateElementInit() {
     new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'es', layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL}, 'google_translate_element');
 }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">

</script>
