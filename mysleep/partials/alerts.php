<!-- These are included on every page that may require an alert after form submission.  They are not shown by default and are displayed on an .ajax form submission.

The following data attributes should be passed through the form itself:

    data-form-location:     Where the form submits (eg. handler, other page, etc...)
    data-success-message:   Message to display when the form is successfully submitted
    data-error-message:     Message to display when the form is returned with an error, or was not able to be submitted

-->

<!-- Success -->
<div id="success-alert" class="alert alert-success" role="alert" style="display: none;">
    <div class="container-fluid">
	  <div class="alert-icon">
		<i class="material-icons">check</i>
	  </div>
      <b>Success:</b> <span id="success-alert-text"></span>
    </div>
</div>

<!-- Error -->
<div id="error-alert" class="alert alert-danger" role="alert" style="display: none;">
    <div class="container-fluid">
	  <div class="alert-icon">
		<i class="material-icons">error_outline</i>
	  </div>
      <b>Error:</b> <span id="error-alert-text"></span>
    </div>
</div>