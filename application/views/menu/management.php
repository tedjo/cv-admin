<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>



    <div class="row">
        <div class="col-lg-6">
            <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= $this->session->flashdata('message'); ?>

            <a href="" class="btn btn-primary mb-3 " data-toggle="modal" data-target="#newMenuModal">Add New Menu</a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($menu as $m) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $m['menu']; ?></td>
                            <th>
                                <button type="button" class=" btn btn-success btn-xs bg-gradient-success show_menumanager" data-show_id="<?= $m['id']; ?>"><i class="fas fa-edit"></i></button>
                                <?php if ($m['number'] > 3) : ?>
                                    <button type="button" class="btn btn-secondary btn-xs bg-gradient-danger delete_menumanager" data-show_id="<?= $m['id']; ?>"><i class="fas fa-trash-alt"></i></button>
                                <?php else : ?>
                                    <button type="button" class="btn btn-secondary btn-xs bg-gradient-danger" disabled><i class="fas fa-trash-alt"></i></button>
                                <?php endif; ?>
                            </th>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>


        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->

<!-- Modal -->
<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModal">Add New Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="add_menu" placeholder="Menu name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary bg-gradient-danger" data-dismiss="modal"><i class="fas fa-times"></i></button>
                    <button type="button" class="btn btn-primary bg-gradient-success add_menumanager"><i class="fas fa-check"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModal">Edit Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="menu_id">
                        <input type="text" class="form-control" id="show_menu">
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary bg-gradient-danger" data-dismiss="modal"><i class="fas fa-times"></i></button> -->
                    <button type="button" class="btn btn-primary bg-gradient-success edit_menumanager"><i class="fas fa-check"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal-->
<div class="modal fade" id="deletModalManagement" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Are you sure, delete the menu?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    <input type="hidden" id="delete_menu_id" placeholder="">
                </button>
            </div>
            <div class="modal-body">All data in the menu is deleted.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-fw fa-times"></i></button>
                <button class="btn btn-danger delete_menumanager" type="button" data-id_manager="1" data-menu_url="<?= base_url('admin/deleteManager'); ?>"><i class="fas fa-fw fa-check"></i></! -->
            </div>
        </div>
    </div>
</div>