<div class="container">
    <div class="page-header"><h1>Manage Questions</h1></div>

    <form class="form-horizontal">
        <div class="form-group">
            <div class="col-lg-10">
                <select class="subselect form-control" name="subId">
                    <option class="disabled" disabled="disabled" selected>Select a subject to manage</option>
                    <? foreach($subjects as $id => $sub): ?>
                    <option value="<?=$id?>"><?=$sub['name']?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div class="subbtn col-lg-2">
                <a data-toggle="modal" href="#addSubject" class="btn btn-default btn-lg">Add subject</a>
            </div>
        </div>
        <div class="setdiv form-group">
            <div id="getSets" class="col-lg-12"></div>
            <br />
            <div class="addButton col-lg-12 text-center"></div>
        </div>
        <div class="commit form-group">
            <div class="col-lg-12 text-center">
                <button type="submit" class="btn btn-primary btn-lg">Commit changes</button>
            </div>
        </div>
    </form>

    <br />

    <div class="newSets hideme" hidden>
    <form class="form-horizontal">
        <input class="subId" name="subId" type="hidden" value="-1" />
        <div class="form-group">
            <div class="col-lg-12">
                <input class="form-control" name="newSetName" placeholder="New set name">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <input class="form-control" name="description" placeholder="Add a description">
            </div>
        </div>
        <div class="tooltips questions"></div>
        <br />
        <div class="form-group">
            <div class="col-lg-12 text-center">
                <a type="submit" class="btn btn-primary btn-lg">Commit changes</a>
            </div>
        </div>
    </form>
    </div>

    <!-- Add subject modal -->
    <div class="modal fade" id="addSubject" tabindex="-1" role="dialog" aria-labelledby="addSubject" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" action="<?=base_url()?>admin/managequestions/addsubject" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title">Add subject</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <input type="text" class="form-control" name="subjectname" placeholder="Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12">
                            <input type="text" class="form-control" name="subjectdescription" placeholder="Description">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<script type="text/javascript" src="<?= base_url()?>assets/js/admin.managequestions.js" ></script>
