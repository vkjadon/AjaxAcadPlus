<div class="navbar navbar-expand-md navbar-dark bg-two fixed-bottom">
  <div class="row">
    <div class="col">
      <p class="text-white m-0 p-0">Product of EISOFTECH INC</p>
    </div>
  </div>
</div>
<?php // echo $codePath; ?>
<script>
  $(document).on("keyup", '#indexSearch', function() {
    var searchString = $(this).val();
    // $.alert(searchString);
    if (searchString != '') {
      $.ajax({
        url: "http://localhost/acadplus/module/indexSearchSql.php",
        method: "POST",
        data: {
          searchString: searchString
        },
        success: function(data) {
          // $.alert("List - " + data)
          $('#indexAutoList').fadeIn();
          $('#indexAutoList').html(data);
        }
      });
    } else {
      $('#indexAutoList').fadeOut();
      $('#indexAutoList').html("");
    }
  });
  $(document).on("click", ".indexAutoList", function() {
      $('#indexSearch').val($(this).text());
      var id = $(this).attr("data-staff");
      $('#indexAutoList').fadeOut();
    });
</script>