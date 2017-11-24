            <footer class="footer">
                <div class="container">
                    <p class="text-muted">
                    <span class="pull-right"><?php echo $title." v".$version ?> by djphil <span class="label label-default">CC-BY-NC-SA 4.0</span></span>
                    &copy; 2015 - <?php $date = date('Y'); echo $date; ?> Digital Concepts - All rights reserved</p>
                </div>
            </footer>
        </div><!-- /.row -->
    </div><!-- /.container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>

    <!--ANIM ALERT MESSAGES-->
    <script>
    $(document).ready(function() {
        $(".alert-anim").fadeTo(2000, 500).slideUp(500, function() {
            $(".alert-anim").alert('close');
        });
    });
    </script>

    <!--YES/NO BUTTONS-->
    <script>
    $(document).ready(function(){
        // Use only for V1
        $('#radioBtn').on('click', function(){
            var sel = $(this).data('value');
            var tog = $(this).data('toggle');
            $('#'+tog).val(sel);
            // You can change these lines to change classes (Ex. btn-default to btn-danger)
            $('span[data-toggle="'+tog+'"]').not('[data-value="'+sel+'"]').removeClass('active btn-primary').addClass('notActive btn-default');
            $('span[data-toggle="'+tog+'"][data-value="'+sel+'"]').removeClass('notActive btn-default').addClass('active btn-primary');
        });
        
        // Use only for V2
        $('#radioBtnV2 span').on('click', function(){
            var sel = $(this).data('value');
            var tog = $(this).data('toggle');
            var active = $(this).data('active');
            var classes = "btn-default btn-primary btn-success btn-info btn-warning btn-danger btn-link";
            var notactive = $(this).data('notactive');
            $('#'+tog).val(sel);
            $('span[data-toggle="'+tog+'"]').not('[data-value="'+sel+'"]').removeClass('active '+classes).addClass('notActive '+notactive);
            $('span[data-toggle="'+tog+'"][data-value="'+sel+'"]').removeClass('notActive '+classes).addClass('active '+active);
        });
    });
    </script>
</body>
</html>
