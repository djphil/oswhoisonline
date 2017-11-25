<article>
    <h1>Settings <span class="glyphicon glyphicon-cog pull-right"></span></h1>
</article>

<?php
if (isset($_SESSION['valid']))
{
    /* VISIBILITY */
    if (!empty($_POST['display_on_website']))
    {
        $user_uuid = $_SESSION['useruuid'];
        $visible = $_POST['display_on_website'];
        
        set_visibility($db, $tbmodu, $user_uuid, $visible);

        if ($visible == "no")
        {
            $visible_yes = "btn btn-default";
            $visible_no = "btn btn-danger active";
        }

        else if ($visible == "yes")
        {
            $visible_yes = "btn btn-success active";
            $visible_no = "btn btn-default";
        }
    }

    else if (empty($_POST['display_on_website']))
    {
        $user_uuid = $_SESSION['useruuid'];
        $visible = get_visibility($db, $tbmodu, $user_uuid);

        if ($visible == "no")
        {
            $visible_yes = "btn btn-default";
            $visible_no = "btn btn-danger active";
        }

        else if ($visible == "yes")
        {
            $visible_yes = "btn btn-success active";
            $visible_no = "btn btn-default";
        }

        else if ($visible == "" || $visible <> "yes" || $visible <> "no")
        {
            $visible_yes = "btn btn-default";
            $visible_no = "btn btn-default ";
        }
    }

    /* FRIENDS ONLY */
    if (!empty($_POST['display_friends_only']))
    {
        $user_uuid = $_SESSION['useruuid'];
        $friends_only = $_POST['display_friends_only'];
        
        set_friends_only($db, $tbmodu, $user_uuid, $friends_only);

        if ($friends_only == "no")
        {
            $friends_only_yes = "btn btn-default";
            $friends_only_no = "btn btn-danger active";
        }

        else if ($friends_only == "yes")
        {
            $friends_only_yes = "btn btn-success active";
            $friends_only_no = "btn btn-default";
        }
    }

    else if (empty($_POST['display_friends_only']))
    {
        $user_uuid = $_SESSION['useruuid'];
        $friends_only = get_friends_only($db, $tbmodu, $user_uuid);

        if ($friends_only == "no")
        {
            $friends_only_yes = "btn btn-default";
            $friends_only_no = "btn btn-danger active";
        }

        else if ($friends_only == "yes") 
        {
            $friends_only_yes = "btn btn-success active";
            $friends_only_no = "btn btn-default";
        }

        else if ($friends_only == "" || $friends_only <> "yes" || $friends_only <> "no")
        {
            $friends_only_yes = "btn btn-default";
            $friends_only_no = "btn btn-default ";
        }
    }

    if ($_POST)
    {
        $_SESSION['flash']['success'] = "Update succefully ...";
    }
}
else {;}

?>

<!-- Fash Message -->
<?php if(isset($_SESSION['flash'])): ?>
    <?php foreach($_SESSION['flash'] as $type => $message): ?>
        <div class="alert alert-<?php echo $type; ?> alert-anim">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo $message; ?>
        </div>
    <?php endforeach; ?>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<!-- Login Form -->
<?php if (!isset($_SESSION['valid'])): ?>
    <div class="alert alert-danger alert-anim">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Registred user</strong> access only ...
    </div>
    <form class="form-signin" role="form" action="?login" method="post">
        <h2 class="form-signin-heading">Please login 
            <i class="glyphicon glyphicon-lock pull-right"></i>
        </h2>
        <label for="username" class="sr-only">User name</label>
        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>        
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">
            <i class="glyphicon glyphicon-log-in"></i> Log-in
        </button>
    </form>
    
<?php else: ?>
    <div class="col-sm-3">
        <div class="row">
            Display my avatar
        </div>
    </div>

    <form class="form" role="form" action="?settings" method="post">
        <input type="hidden" name="display_on_website" id="display_on_website">
        <input type="hidden" name="display_friends_only" id="display_friends_only">

        <div class="col-sm-9">
            <div class="row">
                <div class="form-group">
                    <div id="radioBtnV2" class="btn-group btn-group-yesno">
                        <span class="<?php echo $visible_yes; ?>" data-toggle="display_on_website" data-value="yes" data-active="btn-success" data-notactive="btn-default">
                            Yes
                        </span>
                        <span class="<?php echo $visible_no; ?>" data-toggle="display_on_website" data-value="no" data-active="btn-danger" data-notactive="btn-default">
                            No
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="row">
                For friends only
            </div>
        </div>

        <div class="col-sm-9">
            <div class="row">
                <div class="form-group">
                    <div id="radioBtnV2" class="btn-group btn-group-yesno">
                        <span class="<?php echo $friends_only_yes; ?>" data-toggle="display_friends_only" data-value="yes" data-active="btn-success" data-notactive="btn-default">
                            Yes
                        </span>
                        <span class="<?php echo $friends_only_no; ?>" data-toggle="display_friends_only" data-value="no" data-active="btn-danger" data-notactive="btn-default">
                            No
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="glyphicon glyphicon-ok" name="save"></i> Save
        </button>

        <a href="./?home" id="cancel" name="cancel" class="btn btn-danger">
            <i class="glyphicon glyphicon-remove" name="cancel" id="cancel" value="cancel"></i> Cancel
        </a>
    </form>
<?php endif; ?>
