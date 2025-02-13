<?=
require_once 'includes/Type.php';
$type = new Type();
$types = $type->getRows();
?>

<!-- add/edit form modal -->
<div class="modal fade" id="dogModal" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Add/Edit Dog</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addform" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label for="name" class="col-form-label">Name:</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="dogname" name="dogname" required="required">
            </div>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Type:</label>
            <div class="input-group mb-3">
              <select class="form-control" id="type" name="type" required="required">
                  <option disabled selected value style="display:none"></option>
                <?php                  
                  foreach ($types as $t) { ?>
                    <option value="<?=$t['id']?>"><?=$t['type']?></option>
                  <?php
                  }
                  ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="voice" class="col-form-label">Voice:</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="voice" name="voice">
            </div>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Hunt:</label>
              <input class="form-control" type="checkbox" checked="true" id="canhunt" name="canhunt">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" id="addButton">Submit</button>
          <input type="hidden" name="action" value="adddog">
          <input type="hidden" name="dogid" id="dogid" value="">
        </div>
      </form>
    </div>
  </div>
</div>
<!-- add/edit form modal end -->
