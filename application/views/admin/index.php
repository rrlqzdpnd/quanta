<? $announcements = $data['announcements']; ?>
<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <div class="sidebar" data-spy="affix" data-offset-top="50">
                <ul class="nav sidenav">
                    <li><a href="#ad-announcements"><i class="icon-bullhorn"></i>&nbsp; &nbsp; Announcements</a></li>
                    <li><a href="#ad-recentactivity"><i class="icon-calendar"></i>&nbsp; &nbsp; Recent Activity</a></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="dashb-section">
                <div class="page-header"><h1 id="ad-announcements">Announcements</h1></div>
                <p class="lead">Posted announcements</p>
                <form class="form" action="<?= base_url()?>announcements/set" method="POST">
                <ul class="tooltips">
                    <? if($announcements == false): ?>
                        <strong>There are no announcements.</strong>
                    <? else: ?>
                        <? foreach($announcements as $ann):?>
                        <li>
                            <?=($ann['tag'][2]=='f')?'<span class="label label-default">Inactive</span> ':''?>
                            <strong><?=$ann['title']?></strong>: <?=$ann['date']?> by <?=$ann['poster']?>
                            <button type="submit" class="pull-right btn btn-default btn-sm" name="annTag" value="<?=$ann['tag']?>" data-toggle="tooltip" data-placement="right" title="<?=($ann['tag'][2]=='f')?'Activate':'Inactivate'?>">
                                <i class="icon-check-<?=($ann['tag'][2]=='f')?'empty':'sign'?>">
                                </i>
                            </button>
                            <br/><?=$ann['message']?>
                        </li>
                        <? endforeach; ?>
                    <? endif; ?>
                </ul>
                </form>
                <p class="lead">Add announcement</p>
                <form class="form-horizontal" action="<?= base_url()?>announcements/add" method="POST">
                    <div class="form-group">
                        <label for="inputTitle" class="col-lg-2 control-label">Title</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="inputTitle" name="inputTitle" placeholder="Title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputMessage" class="col-lg-2 control-label">Message</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" id="inputMessage" name="inputMessage" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-offset-2 col-lg-10">
                            <button type="submit" class="btn btn-primary">Post announcement</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="dashb-section">
                <div class="page-header"><h1 id="ad-recentactivity">Recent Activity</h1></div>
                 <p class="lead">You can view all user's analytics on your <a href="<?= base_url()?>statistics/all">statistics page</a>.</p>
            </div>
        </div>
    </div>
</div>
