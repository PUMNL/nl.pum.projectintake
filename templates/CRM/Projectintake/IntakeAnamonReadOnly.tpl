{literal}
  <script type="text/javascript">
    cj(document).ready(function() {
      // hide 'clear' option
      cj('#Intake_Customer_by_Anamon span').each(function() {
        if (this.className == "crm-clear-link") {
          cj(this).hide();
        }
      });
    });
  </script>
{/literal}