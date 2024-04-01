
</ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Manage Party</h5>
            <!-- General Form Elements -->
            <div class="search-bar">
            <?php validation_list_errors(); ?>
              <?= form_open($action= base_url('h_admin/manage_party'), $attributes=array('method' => 'POST', "class" => "search-form d-flex align-items-center")); ?>
                <?= csrf_field(); ?>
                <?= form_input($query); ?>
                <?= form_dropdown('search_type', $search_type, $selected = 'default',$extra=$attr); ?>  
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
              <?= form_close(); ?>
            </div><!-- End Search Bar -->
            <table class="table">
            <thead>
              <tr>
                <th scope="col">Party</th>
                <th scope="col">Abbreviation</th>
                <th scope="col">Slogan</th>
                <th scope="col">Ideology</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($table_data)) { ?>
              <?= "<tr><td><b>No Data To Display</b><td></tr>"; }else{?>
              <?php for($index = 1; $index <= count(array($table_data)); $index++){ ?>
              <?= "<tr>";
                //echo "<th scope='row'>$index</th>";
                echo "<td>" . $table_data->name . "</td>";
                echo "<td>" . $table_data->abbreviation . "</td>";
                echo "<td>" . $table_data->slogan . "</td>";
                echo "<td>" . $table_data->ideology . "</td>";
                echo "<td>" . $table_data->status . "</td>";
                ?>
              <td><a target="_blank" href="<?= base_url('h_admin/update_party?name='.$table_data->name.'&abbreviation='.$table_data->abbreviation.'&slogan='.$table_data->slogan); ?>">Update</a></td>
              <?= "</tr>";
              ?>
              <?php } ?>
              <?php } ?>
            </tbody>
          </table>
          </div>
        </div>

      </div>
    </div>
  </section>  
</main><!-- End #main -->
