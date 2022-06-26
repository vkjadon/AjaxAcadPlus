

<!-- Table -->
<table id='empTable' class='display'>

  <thead>
    <tr>
      <th> name</th>
      <th>Email</th>
      <th>Gender</th>
      <th>Mobile</th>
      <th>City</th>
    </tr>
  </thead>

</table>

<script>
  $(document).ready(function() {
  $('#empTable').DataTable({
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    'ajax': {
      'url': 'ajaxfile.php'
    },
    'columns': [{
        data: 'staff_name'
      },
      {
        data: 'staff_email'
      },
      {
        data: 'staff_gender'
      },
      {
        data: 'staff_mobile'
      },
      {
        data: 'dept_id'
      },
    ],    
  });
  });
</script>