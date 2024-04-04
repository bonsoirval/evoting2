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
              <?php if (empty($name)) { ?>
              <?php echo "<tr><td><b>No Data To Display</b><td></tr>"; }else{?>
              <?= $session->getFlashdata('party_update'); ?>
              
              <?= form_open(); ?>
              <?= csrf_field(); ?>
              <?//= validation_list_errors();?>
              <td><input type="hidden" name="party_clicked" value="clicked" />
              <?= form_input($name); ?></td>
              <td><?= form_input($abbreviation); ?></td>
              <td><?= form_input($slogan); ?></td>
              <td><?= form_input($ideology); ?></td> 
              <td><?= form_dropdown($status, $options, $extra); ?>
              </td>
              <td><?= form_submit($submit = array('name' => 'party_update','class' => 'form-control primary', 'value'=>"Update")); ?></td>
              <?= "</tr>"; ?>
              <?= form_close(); } ?>
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>
  </section>  
</main><!-- End #main -->