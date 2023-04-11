<?php
$this->title = 'Calendar';
$this->params['breadcrumbs'] = [['label' => $this->title]];
$bundle = \hail812\adminlte3\assets\PluginAsset::register($this);
$bundle->css[] = 'sweetalert2-theme-bootstrap-4/bootstrap-4.min.css';
$bundle->js[] = 'bootstrap\js\bootstrap.bundle.js';

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Calendar Table</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
                                        class="form-control select2" style="width: 100%;">
                                    <?php foreach ($months as $key=>$item): ?>
                                    <?php var_dump($key,$selectedMonth);?>
                                        <option value="<?=  $item['url'] ?>" <?php echo  $key==$selectedMonth?'selected="selected"':''; ?>><?= $item['name'] ?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>User</th>
                            <?php foreach ($data[$selectedMonth]['days'] as $item):?>
                                <th>
                                    <button <?=  (!Yii::$app->user->can('admin') && $item["day"] == "Sat")?"disabled" :""; ?>
                                        type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                                        <?= $item['header'] ?>
                                    </button>
                                </th>
                            <?php endforeach;?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user['username'] ?></td>
                                <?php foreach ($data[$selectedMonth]['days'] as $item):?>
                                <td><?= $item['date'] ?></td>
                                <?php endforeach;?>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Default Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->