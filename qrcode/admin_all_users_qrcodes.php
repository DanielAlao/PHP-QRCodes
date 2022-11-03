<fieldset>
    <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="pill" href="#text" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Dynamic <i class="fa fa-qrcode"></i></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#event" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Static <i class="fa fa-qrcode"></i></a>
                  </li>
                </ul>
            </div>
              <div class="card-body">
                <div class="tab-content" >
                    <div class="tab-pane fade show active" id="text" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                        <?php include BASE_PATH . '/tables/dynamic_table.php'; ?>      
                    </div>
                    <div class="tab-pane fade" id="event" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                        <?php include BASE_PATH . '/tables/static_table.php'; ?>  
                    </div>
                </div>
              </div>
    </div><!-- /.card -->
</fieldset>