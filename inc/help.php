<section>
    <article>
        <h1>Help<i class="glyphicon glyphicon-education pull-right"></i></h1>
    </article>

    <article>
        Welcome to <?php echo $title." v".$version; ?>
    </article>

    <article>
        <h2>Features</h2>
        Avatar names list <i class="glyphicon glyphicon-ok text-success"></i><br />
        Teleport buttons <i class="glyphicon glyphicon-ok text-success"></i><br />
        Display my avatar (yes/no) <i class="glyphicon glyphicon-ok text-success"></i><br />
        For friends only (yes/no) <i class="glyphicon glyphicon-ok text-success"></i><br />
        More coming ...
    </article>

    <article>
        <h2>Requirment</h2>
        Mysql, Php5, Apache<br />
    </article>

    <article>
        <h2>Download</h2>
        <a class="btn btn-default btn-success btn-xs" href="<?php echo $github_url; ?>" target="_blank">
        <i class="glyphicon glyphicon-save"></i> GithHub</a> Source Code
    </article>

    <article>
        <h2>Install</h2>
        <h3>Database</h3>
        <ul>
            <li>Import sql/oswhoisonline_settings.sql into your database.</li>
        </ul>

        <h3>config.php</h3>
        <ul>
            <li>Configure variables in inc/config.php</li>
        </ul>
    </article>

    <article>
        <h2>License</h2>
        GNU/GPL General Public License v3.0<br />
    </article>

    <article>
        <h2>Credit</h2>
        Philippe Lemaire (djphil)
    </article>

    <article>
        <h2>Donation</h2>
        <p><?php include_once("inc/paypal.php"); ?></p>
    </article>
</section>
