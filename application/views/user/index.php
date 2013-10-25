<? $announcements = $data['announcements']; ?>
<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <div class="sidebar" data-spy="affix" data-offset-top="50">
                <ul class="nav sidenav">
                    <li><a href="#announcements"><i class="icon-bullhorn"></i>&nbsp; &nbsp; Announcements</a></li>
                    <li><a href="#recentactivity"><i class="icon-calendar"></i>&nbsp; &nbsp; Recent activity</a></li>
                    <li><a href="#recommendedexams"><i class="icon-star"></i>&nbsp; &nbsp; Recommended</a></li>
                    <li><a href="#newresources"><i class="icon-compass"></i>&nbsp; &nbsp; New resources</a></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="dashb-section">
                <div class="page-header"><h1 id="announcements">Announcements</h1></div>
                <p class="lead">View site updates, changes in exams, and other memos.</p>
                <ul>
                    <? if($announcements == false): ?>
                        <li><strong>There are no announcements.</strong></li>
                    <? else: ?>
                        <? foreach($announcements as $ann):?>
                        <li><strong><?=$ann['title']?></strong>: <?=$ann['date']?><br/><?=$ann['message']?></li>
                        <? endforeach; ?>
                    <? endif; ?>
                </ul>
            </div>
            <div class="dashb-section">
                <div class="page-header"><h1 id="recentactivity">Recent Activity</h1></div>
                <p class="lead">You can also view detailed analytics on your <a href="<?= base_url()?>statistics">statistics page</a>.</p>
            </div>
            <div class="dashb-section">
                <div class="page-header"><h1 id="recommendedexams">Recommended Exams</h1></div>
                <p class="lead">See exams tailored for you or view them on your <a href="<?= base_url()?>practice">practice page</a>.</p>
            </div>
            <div class="dashb-section">
                <div class="page-header"><h1 id="newresources">New Resources</h1></div>
                <p class="lead">Check out all others on your <a href="#">resources page</a>.</p>
            </div>
        </div>
    </div>
</div>
