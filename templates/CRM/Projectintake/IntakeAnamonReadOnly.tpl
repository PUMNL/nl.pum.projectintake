{literal}
  <script type="text/javascript">
    cj(document).ready(function() {
      cj('#Intake_Customer_by_Anamon #Intake_Customer_by_Anamon td').each(function() {
        if (this.className == "html-adjust") {
          cj(this).children().prop("disabled", true);
        }
      })
    });
  </script>
{/literal}