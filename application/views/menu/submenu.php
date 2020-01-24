<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg">
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>

            <?= $this->session->flashdata('message'); ?>

            <button <?= $menuMax; ?> type="button" class="btn bg-gradient-primary text-white mb-3 show_icon_costume" data-toggle="modal" data-target="#add_new_menu">Add New Submenu</button>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Access</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php $i = 1; ?>
                    <?php foreach ($subMenu as $sm) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $sm['title']; ?></td>
                            <td><?= $sm['menu_template']; ?></td>
                            <td><?= $sm['icon']; ?></td>
                            <td>
                                <div class="input-group-prepend">
                                    <?php if ($sm['is_active'] != 0) : ?>
                                        <div class="input-group-text bg-gradient-success pt-2 pb-2">
                                        <?php else : ?>
                                            <div class="input-group-text bg-gradient-secondary pt-2 pb-2">
                                            <?php endif; ?>
                                            <input class="form-check-label check_access_menu" type="checkbox" <?= $sm['event']; ?> <?= check_access_menu($sm['is_active']); ?> data-template="<?= $sm['template_id']; ?>" data-active="<?= $sm['is_active']; ?>">
                                            </div>
                                        </div>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-success btn-xs bg-gradient-success show_edit_menu" <?= $sm['event']; ?> data-show_menu_="<?= $sm['template_id']; ?>"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-secondary btn-xs bg-gradient-danger delete_menu" <?= $sm['event']; ?> data-delete_menu_="<?= $sm['id']; ?>" data-templateid="<?= $sm['template_id']; ?>"><i class="fas fa-trash-alt"></i></button>
                            </td>
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


<!-- Add Modal-->
<div class="modal fade" id="add_new_menu" tabindex="-1" role="dialog" aria-labelledby="add_new_menu" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Sub Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form">
                <div class="modal-body">
                    <div class="form-group">
                        <p>Title</p>
                        <input type="text" class="form-control" id="add_title" name="add_title" placeholder="Input title">
                    </div>
                    <div class="form-group">
                        <p>Menu</p>
                        <select id="add_menu" class="form-control">
                            <?php foreach ($menuTemplate as $mT) : ?>
                                <option value="<?= $mT['id']; ?>" data-add_menu="<?= $mT['id']; ?>"><?= $mT['menu_template']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="mb-2"><span class="text-dark">Icon</span></div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-success text-white">
                                    <input type="radio" name="checked_icon" checked class="show_icon_costume">
                                </div>
                                <div class="input-group-text bg-gradient-secondary ml-1">
                                    <input type="radio" name="checked_icon" class="show_icon_default">
                                </div>
                            </div>
                            <input type="text" class="form-control ml-1" id="add_icon" name="add_icon" placeholder="Input icon">
                            <?php foreach ($menuTemplate as $mT) : ?>
                                <input type="hidden" class="form-control ml-1" id="show_id" value="<?= $mT['id']; ?>">
                            <?php endforeach; ?>
                        </div>
                        <div class="mt-3"><span class="text-dark font-weight-bold font-italic">*Icon Default</span></div>
                    </div>
                    <div class="form-group">
                        <div class="ml-2">
                            <input type="checkbox" value="2" id="add_is_active" checked disabled>
                            <span class="text-dark font-weight-bold font-italic"> Active?</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-times"></i></button>
                    <button type="button" class="btn btn-success add_sub_menu"><i class="fas fa-fw fa-check"></i></button>
                </div>
            </form">
        </div>
    </div>
</div>

<!-- Edit Modal-->
<div class="modal fade " id="edit_data_Modal" tabindex="-1" role="dialog" aria-labelledby="edit_data_Modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_data_Modal">Edit Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body mb-3">
                    <div class="form-group">
                        <div class="mb-2"><span>Title</span></div>
                        <input type="text" class="form-control" id="show_title" placeholder="">
                    </div>
                    <div class="form-group">
                        <div class="mb-2"><span class="text-dark">Menu</span></div>
                        <input type="text" class="form-control" id="show_menu" disabled>
                    </div>
                    <div class="mb-2"><span class="text-dark">Icon</span></div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-success text-white">
                                <input type="radio" name="checked_icon" id="show_checked_icon" class="show_icon_edit">
                            </div>
                            <div class="input-group-text bg-gradient-secondary ml-1">
                                <input type="radio" name="checked_icon" class="show_icon_default">
                            </div>
                        </div>
                        <input type="text" class="form-control ml-1" id="show_icon" placeholder="">
                    </div>
                    <input type="hidden" id="show_id" placeholder="">
                    <div class="mb-2 mt-3"><span class="text-dark font-weight-bold font-italic">*Icon Default</span></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-times"></i></button>
                    <button type="button" class="btn btn-success edit_menu"><i class="fas fa-fw fa-check"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal-->
<div class="modal fade" id="deletModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Are you sure, delete the menu?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    <input type="hidden" id="showid" placeholder="">
                    <input type="hidden" id="showTemplateid" placeholder="">
                </button>
            </div>
            <div class="modal-body">All data in the menu is deleted.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-fw fa-times"></i></button>
                <button class="btn btn-danger delete_menu" type="button" data-delete_menu_="1" data-deleteurl="<?= base_url('admin/delete'); ?>"><i class="fas fa-fw fa-check"></i></! -->
            </div>
        </div>
    </div>
</div>