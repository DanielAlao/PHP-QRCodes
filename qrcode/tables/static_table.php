<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive p-0">
      <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="5%">User</th> 
                <th width="10%">Filename</th>
                <th width="20%">Content</th>
                <th width="8%">Qr code</th>
                <th width="10%">Created</th>
                <th width="5%">Operations</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows2 as $row): ?>
            <tr>
                <td><?php echo $row['created_by_user']; ?></td>
                <td><?php echo htmlspecialchars($row['filename']); ?></td>
                <td><?php echo $row['content']; ?></td>
                <td>
                    <?php echo '<img src="'.PATH.htmlspecialchars($row['qrcode']).'" width="100" height="100">'; ?>
                </td>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                <td>
                    <!-- DOWNLOAD -->
                    <a href="<?php echo PATH.htmlspecialchars($row['qrcode']); ?>" class="btn btn-primary" download><i class="fa fa-download"></i></a>
                </td>
            </tr>
            <!-- /.Delete Confirmation Modal -->
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