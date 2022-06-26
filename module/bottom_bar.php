
<nav class="navbar fixed-bottom navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <span class="navbar-brand" href="#">A Product of EI Softech Inc</span>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item">
        <a href="<?php echo $codePath . '/access/event/'; ?>" class="float-right" target="_blank"> Event </a>
      </li>
    </ul>
    <input type="search" class="form-control mr-sm" id="indexSearch" name="indexSearch" placeholder="Search" aria-label="Search">
    <p class='list-group overlapList' id="indexAutoList"></p>
  </div>
</nav>

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