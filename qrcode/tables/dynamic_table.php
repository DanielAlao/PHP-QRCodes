<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive p-0">
      <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="5%">User</th> 
                <th width="15%">Filename</th>
                <th width="18%">Unique redirect identifier</th>
                <th width="36%">URL</th>
                <th width="8%">Qr code</th>
                <th width="20%">Created</th>
                <th width="5%">Scan</th>
                <th width="23%">Operations</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td><?php echo $row['created_by_user']; ?></td>
                <td><?php echo htmlspecialchars($row['filename']); ?></td>
                <td><?php echo htmlspecialchars($row['identifier']); ?></td>
                <td><?php echo htmlspecialchars($row['link']); ?></td>
                <td>
                    <?php echo '<img src="'.PATH.htmlspecialchars($row['qrcode']).'" width="100" height="100">'; ?>
                </td>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                <td><?php echo htmlspecialchars($row['scan']); ?></td>
                <td>
                    <!-- DOWNLOAD -->
                    <a href="<?php echo PATH.htmlspecialchars($row['qrcode']); ?>" class="btn btn-primary" download><i class="fa fa-download"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
   </div><!-- /.Card body -->
   
   <div class="card-footer clearfix">
       <?php echo paginationLinks($page, $total_pages, 'dynamic_qrcodes.php'); ?>
       </div><!-- /.Card footer -->
       
        </div><!-- /.Card -->
    </div><!-- /.col -->
</div><!-- /.row -->