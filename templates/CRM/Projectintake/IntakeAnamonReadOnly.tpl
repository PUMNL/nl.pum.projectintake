{literal}
  <script type="text/javascript">
    cj(document).ready(function() {
      // hide 'clear' option
      cj('#Intake_Customer_by_Anamon #Intake_Customer_by_Anamon span').each(function() {
        if (this.className == "crm-clear-link") {
          cj(this).hide();
        }
      });
      cj('#Intake_Customer_by_Anamon #Intake_Customer_by_Anamon td').each(function() {
        if (this.className == "html-adjust") {
          cj(this).children().prop("disabled", true);
        }
      });
    });
  </script>
{/literal}